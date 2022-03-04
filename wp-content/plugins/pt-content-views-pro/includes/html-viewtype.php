<?php
/**
 * HTML output for specific View types
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'PT_CV_Html_ViewType_Pro' ) ) {

	/**
	 * @name PT_CV_Html_ViewType_Pro
	 * @todo List of functions relates to View type output
	 */
	class PT_CV_Html_ViewType_Pro {

		/**
		 * Check if is old style Timeline
		 * @since 4.9.0
		 * @return bool
		 */
		static function ancient_timeline() {
			return PT_CV_Functions::get_global_variable( 'view_type' ) === 'timeline' && PT_CV_Functions::setting_value( PT_CV_PREFIX . 'timeline-simulate-fb' );
		}

		/**
		 * Wrap elements to Grid layout
		 *
		 * @param array $content_items
		 * @param string $column
		 * @param int $class
		 * @param string $defined_span
		 */
		static function grid_wrapper_simple( $content_items, $column = 0, $class = '', $defined_span = '' ) {
			$content = array();

			list( $columns, $span_width_last, $span_width, $span_class ) = PT_CV_Html_ViewType::process_column_width( $column );

			// Split items to rows
			$columns_item = array_chunk( $content_items, $columns, true );

			// Get HTML of each row
			foreach ( $columns_item as $items_per_row ) {
				$row_html = array();

				$idx = 0;
				foreach ( $items_per_row as $content_item ) {
					if ( !empty( $defined_span[ $idx ] ) ) {
						$_span_width = $defined_span[ $idx ];
					} else {
						$count		 = count( $items_per_row );
						$_span_width = ( $count == $columns && $idx + 1 == $count ) ? $span_width_last : $span_width;
					}

					// Wrap content of item
					$item_classes	 = apply_filters( PT_CV_PREFIX_ . 'item_col_class', array( $span_class . $_span_width, $class ), $_span_width );
					$item_class		 = implode( ' ', array_filter( $item_classes ) );
					$row_html[]		 = sprintf( '<div class="%s">%s</div>', esc_attr( $item_class ), $content_item );

					$idx ++;
				}

				$list_item = implode( "\n", $row_html );

				$content[] = $list_item;
			}

			return $content;
		}

		static function pin_mas_item_wrap( $content_item ) {
			$class = PT_CV_PREFIX . 'pinmas';
			return "<div class='$class'>$content_item</div>";
		}

		/**
		 * Wrap content of Pinterest layout
		 *
		 * @param array $content_items The array of Raw HTML output (is not wrapped) of each item
		 *
		 * @return array Array of HTML of items
		 */
		static function pinterest_wrapper( $content_items ) {
			$content		 = array();
			$content_items	 = array_map( array( __CLASS__, 'pin_mas_item_wrap' ), $content_items );
			PT_CV_Html_ViewType::grid_wrapper( $content_items, $content );
			return $content;
		}

		/**
		 * Wrap content of Masonry layout
		 *
		 * @param array $content_items The array of Raw HTML output (is not wrapped) of each item
		 *
		 * @return array Array of HTML of items
		 */
		static function masonry_wrapper( $content_items ) {
			$content		 = array();
			$content_items	 = array_map( array( __CLASS__, 'pin_mas_item_wrap' ), $content_items );

			$wpl		 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'masonry-wide-posts' );
			$wpl		 = preg_replace( '/[^\d,i]/', '', $wpl );
			$wider_posts = !empty( $wpl ) ? array_filter( explode( ',', $wpl ) ) : null;

			# 2 small items: 3md, 1 big item: 6md
			$column = 4;

			list( $columns, $span_width_last, $span_width, $span_class ) = PT_CV_Html_ViewType::process_column_width( $column, false );
			$count_big		 = $count_seq_small = $prev_width_big	 = 0;
			$idx			 = 0;
			foreach ( $content_items as $post_id => $content_item ) {
				if ( !empty( $wider_posts ) ) {
					if ( in_array( $post_id, $wider_posts ) || in_array( 'i' . ($idx + 1), $wider_posts ) ) {
						$_span_width = $span_width * 2;
					} else {
						$_span_width = $span_width;
					}
				} else {
					$rand		 = rand( 0, 1 );
					$force_big	 = apply_filters( PT_CV_PREFIX_ . 'masonry_post_big', false, $post_id, $idx );

					if ( $force_big || (( $rand || ( $count_seq_small > 3 && $count_big ) || ( $count_big === 0 && $count_seq_small === 2 ) ) && $count_seq_small > 1 && !$prev_width_big) ) {
						$count_big++;
						$count_seq_small = 0;
						$prev_width_big	 = true;

						$_span_width = $span_width * 2;
					} else {
						$count_seq_small++;
						$prev_width_big = false;

						$_span_width = $span_width;
					}
				}

				$_span_width = apply_filters( PT_CV_PREFIX_ . 'masonry_post_width', $_span_width, $idx, $content_items );

				// Wrap content of item
				$item_classes	 = apply_filters( PT_CV_PREFIX_ . 'item_col_class', array( $span_class . $_span_width ), $_span_width );
				$item_class		 = implode( ' ', array_filter( $item_classes ) );
				$content[]		 = PT_CV_Html::content_item_wrap( $content_item, $item_class, $post_id );

				$idx++;
			}

			return $content;
		}

		/**
		 * Wrap content of Timeline type
		 *
		 * @param array $content_items The array of Raw HTML output (is not wrapped) of each item
		 * @param int   $current_page  The current page
		 * @param int   $post_per_page The number of posts per page
		 *
		 * @return array Array of HTML of items
		 */
		static function timeline_wrapper( $content_items, $current_page, $post_per_page ) {
			$content = array();
			$wrap	 = apply_filters( PT_CV_PREFIX_ . 'timeline_wrap_items', $current_page === 1 || !empty( $_GET[ 'vpage' ] ) );

			// The spine
			if ( $wrap ) {
				$content[] = sprintf( '<div class="%s"><a href="#"></a></div>', 'tl-spine' );
			}

			// Wrap all items (start)
			if ( $wrap ) {
				$content[] = sprintf( '<div class="%s">', 'tl-items' );
			}

			$idx = 1;

			// Get index of item
			if ( $post_per_page % 2 == 1 ) {
				$idx = ( $current_page % 2 == 0 ) ? 2 : 1;
			}

			foreach ( $content_items as $post_id => $content_item ) {
				$_content	 = PT_CV_Html::content_item_wrap( $content_item, '', $post_id );
				$item_html	 = sprintf( '<div class="%s"><i class="%s"></i>%s</div>', 'tl-item-content', 'tl-pointer', $_content );
				$item_class	 = 'tl-item ' . ( ( $idx % 2 == 0 ) ? 'pt-right' : 'pt-left' );
				$content[]	 = sprintf( '<div class="%s">%s</div>', $item_class, $item_html );
				$idx ++;
			}

			// Wrap all items (close)
			if ( $wrap ) {
				$content[] = '</div>';
			}

			return $content;
		}

		/**
		 * Wrap content of Glossary layout
		 *
		 * @param array $content_items The array of Raw HTML output (is not wrapped) of each item
		 * @param int   $current_page  The current page
		 * @param int   $post_per_page The number of posts per page
		 *
		 * @return array Array of HTML of items
		 */
		static function glossary_wrapper( $content_items, $current_page, $post_per_page ) {
			if ( PT_CV_Functions::get_global_variable( 'no_post_found' ) ) {
				return PT_CV_Functions::get_global_variable( 'content_items' );
			}

			$glossary_list	 = (array) PT_CV_Functions::get_global_variable( 'glossary_list' );
			$content		 = array();

			foreach ( $glossary_list as $index => $items ) {
				$header = sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'gls-header', $index );

				$list		 = array();
				$items		 = @array_map( array( 'PT_CV_Html', 'grid_item_wrap' ), $items );
				PT_CV_Html_ViewType::grid_wrapper( $items, $list );
				$posts_list	 = sprintf( '<div class="%s">%s</div>', PT_CV_PREFIX . 'gls-content', implode( '', $list ) );

				$content[] = sprintf( '<div id="%s" class="%s">%s</div>', PT_CV_PREFIX . 'gls-' . PT_CV_Html_Pro::sanitize_glossary_heading( $index ), PT_CV_PREFIX . 'gls-group', $header . $posts_list );
			}

			return $content;
		}

		/**
		 * Wrap content of One-and-others layout
		 *
		 * @param array $content_items The array of Raw HTML output (is not wrapped) of each item
		 * @param int   $current_page  The current page
		 * @param int   $post_per_page The number of posts per page
		 *
		 * @return array Array of HTML of items
		 */
		static function one_others_wrapper( $content_items, $current_page, $post_per_page ) {
			$content_items	 = @array_map( array( 'PT_CV_Html', 'grid_item_wrap' ), $content_items );
			$groups			 = $first_group	 = $second_group	 = array();
			$dargs			 = PT_CV_Functions::get_global_variable( 'dargs' );

			# One posts
			PT_CV_Html_ViewType::grid_wrapper( array_slice( $content_items, 0, 1, true ), $first_group, 1, PT_CV_PREFIX . 'omain' );
			$groups[] = implode( '', $first_group );

			# Other posts
			$other_columns = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'one_others-number-columns-others' );
			PT_CV_Functions::set_global_variable( 'other_columns', $other_columns );
			PT_CV_Html_ViewType::grid_wrapper( array_slice( $content_items, 1, null, true ), $second_group, $other_columns ? $other_columns : 1, PT_CV_PREFIX . 'oothers' );

			// Force 2 columns for other posts
			$groups[] = str_replace( '1-col', '2-col', implode( '', $second_group ) );

			# Wrap in columns
			$defined_span	 = '';
			$on_left		 = ((int) $dargs[ 'number-columns' ] === 2);

			if ( $on_left ) {
				$width_proportion	 = isset( $dargs[ 'view-type-settings' ][ 'width-prop' ] ) ? $dargs[ 'view-type-settings' ][ 'width-prop' ] : '6-6';
				$defined_span		 = explode( '-', $width_proportion );
			}

			PT_CV_Functions::set_global_variable( 'one_above', !$on_left );
			return self::grid_wrapper_simple( $groups, 0, PT_CV_PREFIX . 'ocol', $defined_span );
		}

	}

}
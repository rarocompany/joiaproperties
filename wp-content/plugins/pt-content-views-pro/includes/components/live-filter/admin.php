<?php
/*
 * Admin hooks for Live Filter
 *
 * @since 5.0
 * @author ptguy
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

if ( is_admin() && class_exists( 'PT_Content_Views_Admin' ) ) {

	class CVP_LIVE_FILTER_ADMIN {

		static $instance;

		public static function init() {
			if ( !self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		public function __construct() {
			add_filter( PT_CV_PREFIX_ . 'taxonomy_settings', array( $this, 'filter_taxonomy_live_filter' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'ctf_settings', array( $this, 'filter_ctf_live_filter' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'search_settings', array( $this, 'filter_search_live_filter' ) );
			add_filter( PT_CV_PREFIX_ . 'orderby', array( $this, 'filter_sortby_live_filter' ), 999 );
			add_filter( PT_CV_PREFIX_ . 'ctf_sort_settings', array( $this, 'filter_ctf_sort_live_filter' ), 10, 2 );
		}

		/**
		 * Show Live Filter settings for each Taxonomy
		 * @param array $args
		 * @param string $taxonomy_slug
		 * @return array
		 */
		function filter_taxonomy_live_filter( $args, $taxonomy_slug ) {
			$prefix = $taxonomy_slug . '-';

			$args[]	 = CVP_LIVE_FILTER_SETTINGS::enable_live_filter( $prefix );
			$args[]	 = array(
				'label'			 => array(
					'text' => '',
				),
				'extra_setting'	 => array(
					'params' => array(
						'width' => 12,
					),
				),
				'params'		 => array(
					array(
						'type'		 => 'html',
						'content'	 => sprintf( '<p class="text-muted" style="margin-top: -8px">%s</p>', __( 'Leave the "Select Terms" above empty to show all terms', 'content-views-pro' ) ),
					),
				),
			);
			$args[]	 = array(
				'label'			 => array(
					'text' => '',
				),
				'extra_setting'	 => array(
					'params' => array(
						'width' => 12,
					),
				),
				'params'		 => array(
					array(
						'type'	 => 'group',
						'params' => $this->_live_filter_settings( $prefix ),
					),
				),
				'dependence'	 => array( $prefix . 'live-filter-enable', 'yes' ),
			);

			return $args;
		}

		/**
		 * Show Live Filter settings for each Custom Field
		 * @since 5.0
		 *
		 * @param array $args
		 * @param string $prefix
		 * @return array
		 */
		function filter_ctf_live_filter( $args, $prefix ) {
			$args[ 'live-filter-enable' ]	 = CVP_LIVE_FILTER_SETTINGS::enable_live_filter( $prefix );
			$args							 = array_merge( $args, $this->_live_filter_settings( $prefix ) );

			return $args;
		}

		// Show settings to enable Search field
		function filter_search_live_filter( $args ) {
			$prefix	 = 'search-';
			$args	 = array(
				'label'			 => array(
					'text' => '',
				),
				'extra_setting'	 => array(
					'params' => array(
						'width' => 12,
					),
				),
				'params'		 => array(
					array(
						'type'	 => 'group',
						'params' => array(
							$args,
							CVP_LIVE_FILTER_SETTINGS::enable_live_filter( $prefix, __( 'Show search field to visitors', 'content-views-pro' ) ),
							CVP_LIVE_FILTER_SETTINGS::label_text( $prefix, __( 'Search', 'content-views-pro' ) ),
							array(
								'label'		 => array(
									'text' => __( 'Placeholder', 'content-views-pro' ),
								),
								'params'	 => array(
									array(
										'type'	 => 'text',
										'name'	 => $prefix . 'live-filter-placeholder',
										'std'	 => '',
									),
								),
								'dependence' => array( $prefix . 'live-filter-enable', 'yes' ),
							),
						),
					),
				),
			);

			return $args;
		}

		function filter_sortby_live_filter( $args ) {
			$prefix = 'livesort-';

			$label = CVP_LIVE_FILTER_SETTINGS::label_text( $prefix, __( 'Sort by', 'content-views-pro' ) );
			unset( $label[ 'dependence' ] );

			$args[ __( 'Live filter', 'content-views-pro' ) ] = array(
				array(
					'label'			 => array(
						'text' => '',
					),
					'extra_setting'	 => array(
						'params' => array(
							'width' => 12,
						),
					),
					'params'		 => array(
						array(
							'type'	 => 'group',
							'params' => array(
								array(
									'label'	 => array(
										'text' => __( 'Options', 'content-views-pro' ),
									),
									'params' => array(
										array(
											'type'		 => 'select',
											'name'		 => $prefix . 'options',
											'options'	 => apply_filters( PT_CV_PREFIX_ . 'settings_sort_single', CVP_LIVE_FILTER_SORTBY::common_sortby(), $prefix . 'options' ),
											'std'		 => '',
											'desc'		 => __( 'Select options to show to visitors', 'content-views-pro' ),
											'class'		 => 'select2-sortable',
											'multiple'	 => '1',
										),
									),
								),
								array(
									'label'	 => array(
										'text' => '',
									),
									'params' => array(
										array(
											'type'	 => 'text',
											'name'	 => $prefix . 'options-text',
											'std'	 => '',
											'desc'	 => __( 'Customize texts of above options. Separate texts by comma', 'content-views-pro' ),
										),
									),
								),
								$label,
								array(
									'label'	 => array(
										'text' => __( 'Placeholder Text', 'content-views-pro' ),
									),
									'params' => array(
										array(
											'type'	 => 'text',
											'name'	 => $prefix . 'default-text',
											'std'	 => '',
											'desc'	 => __( 'Change the "Default" text', 'content-views-pro' ),
										),
									),
								),
								array(
									'label'	 => array(
										'text' => '',
									),
									'params' => array(
										array(
											'type'	 => 'text',
											'name'	 => 'position-live-filters',
											'std'	 => '',
										),
									),
								),
							),
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Show Live Filter settings for each Sort by >> Custom Field
		 * @since 5.0
		 *
		 * @param array $args
		 * @param string $prefix
		 * @return array
		 */
		function filter_ctf_sort_live_filter( $args, $prefix ) {
			$args[ 'live-filter-enable' ]	 = CVP_LIVE_FILTER_SETTINGS::enable_live_filter( $prefix, __( 'Show as sort option to visitors', 'content-views-pro' ), 'sort' );
			$args[ 'live-filter-heading' ]	 = CVP_LIVE_FILTER_SETTINGS::label_text( $prefix );

			return $args;
		}

		function _live_filter_settings( $prefix ) {
			$args								 = array();
			$args[ 'live-filter-type' ]			 = CVP_LIVE_FILTER_SETTINGS::output_type( $prefix );
			$args[ 'live-filter-operator' ]		 = CVP_LIVE_FILTER_SETTINGS::operator_options( $prefix );
			$args[ 'live-filter-heading' ]		 = CVP_LIVE_FILTER_SETTINGS::label_text( $prefix, '', __( 'Use a space to remove the default label text', 'content-views-pro' ) );
			$args[ 'live-filter-default-text' ]	 = CVP_LIVE_FILTER_SETTINGS::default_text( $prefix );
			$args[ 'live-filter-order-options' ] = CVP_LIVE_FILTER_SETTINGS::order_options_by( $prefix );

			if ( CVP_LIVE_FILTER_SETTINGS::typeof_filter( $prefix ) === 'ctf-filter' ) {
				$args[ 'live-filter-id-to-text' ] = CVP_LIVE_FILTER_SETTINGS::id_to_text( $prefix );
			}

			$args[ 'live-filter-show-count' ]	 = CVP_LIVE_FILTER_SETTINGS::show_posts_count( $prefix );
			$args[ 'live-filter-hide-empty' ]	 = CVP_LIVE_FILTER_SETTINGS::hide_empty_values( $prefix );

			if ( CVP_LIVE_FILTER_SETTINGS::typeof_filter( $prefix ) === 'ctf-filter' ) {
				$args[ 'live-filter-hide-non-matching' ]	 = CVP_LIVE_FILTER_SETTINGS::hide_non_matching( $prefix );
				$args[ 'live-filter-daterange-operator' ]	 = CVP_LIVE_FILTER_SETTINGS::date_range_operator( $prefix );
//				$args[ 'live-filter-rangeslider-from' ]		 = CVP_LIVE_FILTER_SETTINGS::range_slider_from( $prefix );
				$args[ 'live-filter-rangeslider-step' ]		 = CVP_LIVE_FILTER_SETTINGS::range_slider_step( $prefix );
				$args[ 'live-filter-rangeslider-prefix' ]	 = CVP_LIVE_FILTER_SETTINGS::range_slider_prefix( $prefix );
				$args[ 'live-filter-rangeslider-postfix' ]	 = CVP_LIVE_FILTER_SETTINGS::range_slider_postfix( $prefix );
				$args[ 'live-filter-rangeslider-thousandseparator' ] = CVP_LIVE_FILTER_SETTINGS::range_slider_thousand_separator( $prefix );
            } else {
				$args[ 'live-filter-require-exist' ] = CVP_LIVE_FILTER_SETTINGS::require_exist( $prefix );
			}

			return $args;
		}

	}

	CVP_LIVE_FILTER_ADMIN::init();
}
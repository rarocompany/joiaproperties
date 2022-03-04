<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class CVP_Replace_Layout {

	private static $instance;
	private $origin_query;
	private $which_page;
	private $which_view			 = false;
	private $show_heading		 = false;
	private $full_width			 = false;
	private $fix_duplicating	 = false;
	private $start_where		 = false;
	private $odd_case			 = false;
	private $force_replace		 = false;
	private $filter_settings	 = false;
	private $display_comments	 = false;
	private $enable_pagination	 = false;
	private $done				 = false;
	private $container_class	 = CVP_REPLAYOUT;
	private $extra_class;

	public static function get_instance() {
		if ( !CVP_Replace_Layout::$instance ) {
			CVP_Replace_Layout::$instance = new CVP_Replace_Layout();
		}

		return CVP_Replace_Layout::$instance;
	}

	public static function where_to_start() {
		$settings = get_option( CVP_REPLAYOUT );

		// @since 5.7.0: use pre_get_posts to able to change posts per page for SEO pagination
		if ( !empty( $settings[ '-1-use-standard-pagination' ][ 'rep_status' ] ) ) {
			$start_where = 'pre_get_posts';
		} else {
			// Not every themes call get_header() in template file, such as Thesis
			$start_where = has_action( 'get_header' ) ? 'get_header' : 'template_redirect';
		}

		return $start_where;
	}

	public function __construct() {
		if ( !is_admin() ) {
			// @since 5.7.0: use pre_get_posts to able to change posts per page for SEO pagination
			$this->start_where	 = $start_where		 = self::where_to_start();
			add_action( $start_where, array( $this, 'hook_header' ) );
			add_action( 'loop_start', array( $this, 'start_buffer' ), 0 );
			add_action( 'loop_end', array( $this, 'do_replace' ), 0 );

			add_filter( PT_CV_PREFIX_ . 'terms_data_for_shuffle', array( $this, 'filter_terms_data_for_shuffle' ) );

			if ( $this->start_where === 'pre_get_posts' ) {
				add_filter( PT_CV_PREFIX_ . 'pagination_link_format', array( $this, 'filter_pagination_link_format' ) );
				add_filter( PT_CV_PREFIX_ . 'pagination_params_removed', array( $this, 'filter_pagination_params_removed' ) );
			}
		} else {
			// For updating
			add_action( 'load-edit-tags.php', array( 'CVP_Replace_Layout_Admin', 'admin_action_term' ) );
			// For showing
			add_action( 'load-term.php', array( 'CVP_Replace_Layout_Admin', 'admin_action_term' ) );
		}
	}

	function hook_header( $query ) {
		if ( $this->start_where === 'pre_get_posts' && !$query->is_main_query() ) {
			return;
		}

		global $wp_query;
		$this->origin_query = $wp_query;

		$this->get_page( $wp_query );
		$this->get_view();
		$this->change_posts_per_page( $query );
	}

	function get_page( $wp_query ) {
		$arr = array(
//			'is_single',
//			'is_preview',
//			'is_page',
//			'is_archive',
			'is_date',
			'is_year',
			'is_month',
			'is_day',
			'is_time',
			'is_author',
			'is_category',
			'is_tag',
			'is_tax',
			'is_search',
//			'is_feed',
//			'is_comment_feed',
//			'is_trackback',
			'is_home',
//			'is_404',
//			'is_embed',
//			'is_paged',
//			'is_admin',
//			'is_attachment',
			'is_singular',
//			'is_robots',
//			'is_posts_page',
			'is_post_type_archive',
		);
		foreach ( $arr as $which ) {
			if ( !empty( $wp_query->$which ) ) {
				$page = str_replace( 'is_', '', $which );

				switch ( $which ):
					case 'is_date':
					case 'is_year':
					case 'is_month':
					case 'is_day':
					case 'is_time':
						$page = 'time';
						break;

					case 'is_category':
						$page = "tax-$page";
						break;

					case 'is_tag':
						$page = "tax-post_tag";
						break;

					case 'is_tax':
						$detail	 = $wp_query->get_queried_object()->taxonomy;
						$page	 = "tax-$detail";
						break;

					case 'is_singular':
						if ( $wp_query->is_single ) {
							$detail = !empty( $wp_query->query_vars[ 'post_type' ] ) ? $wp_query->query_vars[ 'post_type' ] : 'post';
						} elseif ( $wp_query->is_page ) {
							$detail = 'page';
						}

						$page = "is_singular-$detail";
						break;

					case 'is_post_type_archive':
						$detail	 = $wp_query->query_vars[ 'post_type' ];
						$page	 = "post_type-$detail";
						break;
				endswitch;

				$this->which_page = $page;
				break;
			}
		}
	}

	function get_view() {
		if ( !$this->which_page ) {
			return;
		}

		$settings	 = get_option( CVP_REPLAYOUT );
		$page		 = $this->which_page;
		if ( !empty( $settings[ $page ][ 'rep_status' ] ) ) {
			if ( !empty( $settings[ $page ][ 'selected_view' ] ) ) {
				$this->which_view = $settings[ $page ][ 'selected_view' ];
			}
			$this->modify_view();

			if ( !empty( $settings[ $page ][ 'sort_by' ] ) ) {
				$this->filter_settings = $settings[ $page ][ 'sort_by' ];
			}

			if ( !empty( $settings[ $page ][ 'show_comment' ] ) ) {
				$this->display_comments = $settings[ $page ][ 'show_comment' ];
			}
		}

		$this->show_heading		 = !empty( $settings[ '-1-show-heading' ][ 'rep_status' ] );
		$this->full_width		 = !empty( $settings[ '-1-full-width' ][ 'rep_status' ] );
		$this->fix_duplicating	 = !empty( $settings[ '-1-duplicating-content' ][ 'rep_status' ] );
		$this->odd_case			 = $this->which_page === 'search' && $this->filter_settings === 'use_returned_posts';
	}

	/** Change posts per page of the page, to leverage default pagination for SEO purpose
	 * @since 5.7.0
	 */
	function change_posts_per_page( $query ) {
		if ( $this->start_where === 'pre_get_posts' && $query && $this->is_right_place( $query ) && strpos( $this->which_page, 'is_singular-' ) === false && !$this->odd_case ) {
			$view_settings	 = PT_CV_Functions::view_get_settings( $this->which_view );
			$pagination		 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'enable-pagination', $view_settings );
			$ppp			 = (int) PT_CV_Functions::setting_value( PT_CV_PREFIX . 'pagination-items-per-page', $view_settings );
			if ( $pagination && $ppp ) {
				$query->set( 'posts_per_page', $ppp );
			}
		}
	}

	function start_buffer( $query ) {
		if ( $this->is_right_place( $query ) ) {
			ob_start();

			$this->fix_duplicating ? $this->fix_duplicate( $query ) : false;
		}
	}

	function fix_duplicate( &$query ) {
		$this->container_class .= ' cvp-hide-duplicating';

		// Force to stop while loop of theme
		$query->current_post = $query->post_count - 1;

		// Prevent notice, warning from theme functions caused by above command
		error_reporting( ~E_WARNING & ~E_NOTICE );

		// Prevent recursive loops
		remove_action( 'loop_start', array( $this, 'start_buffer' ), 0 );
		remove_action( 'loop_end', array( $this, 'do_replace' ), 0 );

		do_action( PT_CV_PREFIX_ . 'replace_layout_duplicating' );

		// Force to replace
		$this->force_replace = true;
		$this->do_replace( $query );
	}

	function is_right_place( $query ) {
		if ( PT_CV_Functions_Pro::user_can_manage_view() ) {
			if ( defined( 'PT_CV_VIEW_OVERWRITE' ) && $query->is_main_query() && $this->which_view && current_filter() === 'loop_start' ) {
				printf( '<div class="alert" style="background: #FFEB3B;padding: 10px;">%s</div>', __( 'For Administrator only: You already replaced layout by using method', 'content-views-pro' ) . ' <code>PT_CV_Functions_Pro::view_overwrite_tpl</code>' );
			}
		}

		return !is_feed() && !is_admin() && $query->is_main_query() && $this->which_view && !$this->done && !defined( 'PT_CV_VIEW_OVERWRITE' ) && apply_filters( PT_CV_PREFIX_ . 'replace_precheck', true );
	}

	function do_replace( $query ) {
		if ( $this->is_right_place( $query ) || $this->force_replace ) {
			do_action( PT_CV_PREFIX_ . 'do_replace_layout' );

			add_filter( PT_CV_PREFIX_ . 'set_current_page', array( $this, 'set_page_from_url' ) );
			add_action( PT_CV_PREFIX_ . 'finished_replace', array( $this, 'disable_existing_pagination' ) );

			$this->clean_old_html();
			$this->get_new_html();
			$this->finished();
		}
	}

	function clean_old_html() {
		$old_layout = ob_get_clean();

		if ( apply_filters( PT_CV_PREFIX_ . 'replace_use_old_class', true ) ) {
			# Extract class from theme, to maintain style
			$matches = array();
			preg_match( '/class="([^"]+)"/', $old_layout, $matches );
			if ( !empty( $matches[ 1 ] ) ) {
				$first_class		 = preg_replace( '/\d/', '0', $matches[ 1 ] );
				// Exclude some classes name
				$first_class		 = preg_replace( '/\s?[^\s]*(google|ad|nocontent)[^\s]*\s?/i', ' ', $first_class );
				$this->extra_class	 = preg_replace( '/\s+/', ' ', $first_class );
			}
		}
	}

	function get_new_html() {
		if ( !$this->which_view ) {
			return;
		}

		$view_id = $this->which_view;

		if ( apply_filters( PT_CV_PREFIX_ . 'replace_completely', false, $this->which_page ) ) {
			# Completely replace page layout by output of View
			$view_output = do_shortcode( "[pt_view id=$view_id]" );
		} else if ( $this->odd_case ) {
			# Store some info to access outside
			$GLOBALS[ 'cvp_replacing_info' ] = array( 'wview' => $this->which_view, 'wmode' => $this->filter_settings );

			# Custom filters for this case
			add_filter( PT_CV_PREFIX_ . 'query_params', array( __CLASS__, '_use_returned_posts_params' ), 99999 );
			add_filter( PT_CV_PREFIX_ . 'view_settings', array( __CLASS__, '_use_returned_posts_settings' ), 11 );

			# Show the returned posts
			$pids = array();

			$wp_query = $this->origin_query;
			foreach ( $wp_query->posts as $pob ) {
				$pids[] = $pob->ID;
			}
			$pids = implode( ',', $pids );

			$view_output = do_shortcode( "[pt_view id=$view_id post_id='$pids' post_type='_CVP_FOR_SEARCH_PAGE_']" );
		} else {
			$wp_query		 = $this->origin_query;
			$view_settings	 = PT_CV_Functions::view_get_settings( $view_id );
			$no_override	 = ($this->filter_settings != 'use_filter_settings');
			// When not enabling pagination & not replace result, prevent existing Limit value in View from showing more/less posts, and causing 404 error
			if ( empty( $view_settings[ PT_CV_PREFIX . 'enable-pagination' ] ) && $no_override ) {
				$view_settings[ PT_CV_PREFIX . 'limit' ] = $wp_query->query_vars[ 'posts_per_page' ];
			}

			if ( !empty( $view_settings[ PT_CV_PREFIX . 'enable-pagination' ] ) || ($view_settings[ PT_CV_PREFIX . 'view-type' ] === 'glossary') ) {
				if ( $no_override ) {
					$view_settings[ PT_CV_PREFIX . 'limit' ] = '-1';
				}
				$this->enable_pagination = true;
			}

			$this->modify_query( $wp_query, $view_settings );
			$view_settings[ PT_CV_PREFIX . 'rebuild' ] = $wp_query->query_vars;

			$view_html	 = PT_CV_Functions::view_process_settings( $view_id, $view_settings );
			$view_output = PT_CV_Functions::view_final_output( $view_html );
		}

		$this->modify_output( $view_output );

		$class	 = $this->container_class . ' ' . $this->extra_class . ($this->full_width ? ' cvp-full-width' : '');
		$html	 = "<div class='$class'>$view_output</div>";

		echo apply_filters( PT_CV_PREFIX_ . 'replace_output', $html );
	}

	/**
	 * Modify View of current page
	 * @since 4.6.0
	 */
	function modify_view() {
		// For tax page only
		if ( strpos( $this->which_page, 'tax-' ) === 0 ) {
			$term_id		 = get_queried_object_id();
			$selected_view	 = cvp_get_term_meta( $term_id, 'cvp_view', true );
			if ( $selected_view ) {
				$this->which_view = $selected_view;
			}
		}
	}

	/**
	 * Correct the query parameters
	 * @since 4.6.0
	 * @param type $query
	 * @param type $view_settings
	 */
	function modify_query( &$query, $view_settings ) {
		$status								 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'post_status', $view_settings );
		$query->query_vars[ 'post_status' ]	 = !empty( $status ) ? $status : 'publish';

		if ( $this->which_page === 'is_singular-page' ) {
			$query->query_vars[ 'post_type' ] = 'page';
		}

		$query->query_vars[ 'cvp_replace_layout_page' ]			 = $this->which_page;
		$query->query_vars[ 'cvp_replace_enable_pagination' ]	 = $this->enable_pagination;
		$query->query_vars[ 'cvp_replace_filter_settings' ]		 = $this->filter_settings;
	}

	/**
	 * Prepend/append more info to output
	 * since 4.6.0
	 */
	function modify_output( &$output ) {
		if ( $this->show_heading ) {
			$title = $this->get_the_archive_title();
			if ( $title ) {
				$output = sprintf( '<h1 class="page-title">%s</h1>', $title ) . $output;
			}
		}

		if ( $this->display_comments ) {
			ob_start();
			@comments_template();
			$output .= ob_get_clean();
		}
	}

	/**
	 * Disable pagination of theme/another plugin follows the replacing View
	 * @since 4.7
	 */
	function disable_existing_pagination() {
		if ( $this->enable_pagination || PT_CV_Functions::get_global_variable( 'force_disable_theme_pagination' ) ) {
			global $wp_query;
			$wp_query->max_num_pages = 1;
			$wp_query->found_posts	 = 1;

			if ( isset( $GLOBALS[ 'woocommerce_loop' ][ 'total_pages' ] ) ) {
				$GLOBALS[ 'woocommerce_loop' ][ 'total_pages' ] = 1;
			}
		}
	}

	/**
	 * Show correct posts in pages of replaced WP page
	 * @since 4.7
	 * @param int $page
	 * @return int
	 */
	function set_page_from_url( $page ) {
		global $wp_query;
		if ( !empty( $wp_query->query_vars[ 'paged' ] ) ) {
			$page = intval( $wp_query->query_vars[ 'paged' ] );
		}

		return $page;
	}

	/**
	 * Modify query parameters
	 * (make this static to use in Ajax pagination)
	 *
	 * @param array $args
	 * @return array
	 */
	static function modify_query_params( $args ) {
		if ( !isset( $args[ 'cvp_replace_layout_page' ] ) ) {
			return $args;
		}

		/**
		 * Show correct posts in pages of replaced WP page
		 * If this View doesn't enable pagination, leave the offset to be set by WP
		 * @since 4.7
		 */
		if ( !$args[ 'cvp_replace_enable_pagination' ] && !defined( 'PT_CV_DOING_PAGINATION' ) ) {
			unset( $args[ 'offset' ] );
		}

		// Use Filter Settings of View
		$val = $args[ 'cvp_replace_filter_settings' ];
		if ( $val ) {
			$view_settings	 = PT_CV_Functions::get_global_variable( 'view_settings' );
			$content_type	 = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'content-type', $view_settings );
			$view_args		 = PT_CV_Functions::view_filter_settings( $content_type, $view_settings );

			// Use "Sort by" setting
			if ( $val === 'use_view_order' ) {
				if ( !empty( $view_args[ 'orderby' ] ) ) {
					$args[ 'orderby' ] = $view_args[ 'orderby' ];
				}
				if ( !empty( $view_args[ 'order' ] ) ) {
					$args[ 'order' ] = $view_args[ 'order' ];
				}
			}

			// Use all Filter Settings
			if ( $val === 'use_filter_settings' ) {
				$args = array_merge( $args, $view_args );
			}
		}

		return $args;
	}

	/**
	 * Retrieve terms info to support Shuffle Filter
	 * @since 4.6.0
	 * @param type $terms
	 * @return type
	 */
	function filter_terms_data_for_shuffle( $terms ) {
		global $wp_query;
		if ( $this->is_right_place( $wp_query ) ) {
			$view_settings	 = PT_CV_Functions::get_global_variable( 'view_settings' );
			$selected_terms	 = cvp_get_selected_terms( $view_settings );
			if ( $selected_terms ) {
				$terms = $selected_terms;
			}
		}

		return $terms;
	}

	/** Change the format for pagination in replaced layout pages
	 * @since 5.7.0
	 * @param string $format
	 * @return string
	 */
	function filter_pagination_link_format( $format ) {
		global $wp_query, $wp_rewrite;

		// This can't work when redirect from old link
		// But will work in redirected page
		if ( $this->is_right_place( $wp_query ) ) {
			$format = $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
		}

		return $format;
	}

	/** Modify the pagination links
	 * @since 5.7.0
	 * @param array $params
	 * @return array
	 */
	function filter_pagination_params_removed( $params ) {
		global $wp_query;

		if ( $this->is_right_place( $wp_query ) ) {
			$params[] = '_page';
		}

		return $params;
	}

	/**
	 * Retrieve the archive title based on the queried object.
	 *
	 * @return string Archive title.
	 */
	function get_the_archive_title() {
		if ( is_category() ) {
			$title = sprintf( __( 'Category: %s' ), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( __( 'Tag: %s' ), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( __( 'Year: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( __( 'Month: %s' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( __( 'Day: %s' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Asides', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( __( 'Archives: %s' ), post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax	 = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
			$title	 = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
		} else {
			# Customized by CVP
			if ( is_search() ) {
				$text_domain = apply_filters( PT_CV_PREFIX_ . 'theme_text_domain', wp_get_theme()->get( 'TextDomain' ) );
				$title		 = sprintf( __( 'Search Results for: %s', $text_domain ), get_search_query() );
			} elseif ( is_home() || is_singular() ) {
				$title = '';
			} else {
				$title = __( 'Archives' );
			}
		}

		return apply_filters( 'get_the_archive_title', $title );
	}

	function finished() {
		$this->done			 = true;
		$this->which_view	 = null;

		do_action( PT_CV_PREFIX_ . 'finished_replace' );
	}

	/**
	 * Check if replace layout is enabled, for this page
	 * @global type $wp_query
	 * @return bool
	 */
	static function precheck_right_place() {
		global $wp_query;
		return self::get_instance()->is_right_place( $wp_query );
	}

	// For search page which uses returned posts
	public static function _use_returned_posts_params( $args ) {
		if ( isset( $args[ 'post_type' ] ) && $args[ 'post_type' ] === '_CVP_FOR_SEARCH_PAGE_' ) {
			$args[ 'post_type' ]		 = 'any';
			$args[ 'posts_per_page' ]	 = count( $args[ 'post__in' ] );

			unset( $args[ 'offset' ] );
			unset( $args[ 's' ] );
		}

		return $args;
	}

	/**
	 * Dynamic changing settings of View while replacing
	 * @param array $args
	 * @return type
	 */
	public static function _use_returned_posts_settings( $args ) {
		if ( !empty( $GLOBALS[ 'cvp_replacing_info' ] ) ) {

			extract( $GLOBALS[ 'cvp_replacing_info' ] );

			// If this View is selected to replace
			if ( $args[ PT_CV_PREFIX . 'view-id' ] === $wview ) {
				// If using returned posts
				if ( 'use_returned_posts' === $wmode ) {
					// Disable pagination as it won't show correct results of pages correctly
					$args[ PT_CV_PREFIX . 'enable-pagination' ] = '';
				}
			}
		}

		return $args;
	}

}

CVP_Replace_Layout::get_instance();

class CVP_Replace_Layout_Admin {

	static $term_field = 'cvp_view';

	/**
	 * Add setting to Admin term page, to set View for replacing layout
	 * @since 4.6.0
	 */
	public static function admin_action_term() {
		$replace_data	 = get_option( CVP_REPLAYOUT );
		$taxes			 = get_taxonomies( array( 'public' => true ) );

		foreach ( $taxes as $tax ) {
			if ( !empty( $replace_data[ "tax-$tax" ][ 'rep_status' ] ) ) {
				add_action( $tax . '_edit_form_fields', array( __CLASS__, 'custom_view_for_term' ), 999, 2 );
				add_action( 'edit_term', array( __CLASS__, 'save_view_for_term' ), 999, 3 );
			}
		}
	}

	/**
	 * Add View select box for term
	 *
	 * @param string $term
	 * @param string $taxonomy
	 */
	static function custom_view_for_term( $term, $taxonomy ) {
		$selected_view	 = cvp_get_term_meta( $term->term_id, self::$term_field, true );
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Content Views', 'content-views-pro' ); ?></label></th>
			<td>
				<select id="display_type" name="<?php echo self::$term_field; ?>" class="postform">
					<?php
					$views			 = cvp_get_view_list( sprintf( __( '(Use selected View in "%s" page)', 'content-views-pro' ), __( 'Replace Layout', 'content-views-pro' ) ) );
					foreach ( $views as $view_id => $title ) {
						printf( '<option value="%s" %s>%s</option>', esc_attr( $view_id ), selected( $selected_view, $view_id, false ), esc_html( $title ) );
					}
					?>
				</select>
				<p class="description">
					<?php _e( "Select the View to replace layout of this term's archive page", 'content-views-pro' ); ?>
				</p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save View for term
	 *
	 * @param int    $term_id  Term ID.
	 * @param int    $tt_id    Term taxonomy ID.
	 * @param string $taxonomy Taxonomy slug.
	 */
	static function save_view_for_term( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( isset( $_POST[ self::$term_field ] ) ) {
			cvp_update_term_meta( $term_id, self::$term_field, esc_attr( $_POST[ self::$term_field ] ) );
		}
	}

}

class CVP_Replace_Layout_Compatible {

	static function init() {
		add_action( PT_CV_PREFIX_ . 'replace_layout_duplicating', array( __CLASS__, 'extra_duplicating_fix' ) );
		add_action( PT_CV_PREFIX_ . 'do_replace_layout', array( __CLASS__, 'manage_other_hooks' ) );

		add_filter( PT_CV_PREFIX_ . 'replace_precheck', array( __CLASS__, 'not_replace_when' ) );
		add_filter( PT_CV_PREFIX_ . 'query_params', array( __CLASS__, 'modify_params_some_cases' ), 99999 );

		add_action( 'get_header', array( __CLASS__, 'theme_alora_search_results' ) );
		add_filter( 'template_include', array( __CLASS__, 'theme_enfold_change_template_file' ) );
		add_filter( 'avf_blog_style', array( __CLASS__, 'theme_enfold_blog_style' ), 10, 2 );
	}

	/**
	 * Check if replace layout is enabled for page
	 * @param string $page
	 * @param int $term_id
	 * @return boolean
	 */
	static function _is_enabled( $page, $term_id = 0 ) {
		$replace_data = get_option( CVP_REPLAYOUT );
		if ( empty( $replace_data[ $page ][ 'rep_status' ] ) ) {
			return false;
		}

		if ( !empty( $replace_data[ $page ][ 'selected_view' ] ) ) {
			return true;
		}

		$term_view = $term_id ? cvp_get_term_meta( $term_id, 'cvp_view', true ) : 0;
		if ( !empty( $term_view ) ) {
			return true;
		}

		return false;
	}

	static function extra_duplicating_fix() {
		// Flatsome theme: posts of theme still appear, when use another layout than Normal, in Customize > Blog > Blog Archive
		if ( get_template() === 'flatsome' ) {
			global $shortcode_tags;
			$shortcode_tags[ 'blog_posts' ] = '__return_false';
		}
	}

	// Manage hooks of other plugins
	static function manage_other_hooks() {
		/** Fix: SearchWP can't apply its order when use CVP to replace search results
		 * @since 4.2
		 */
		add_filter( 'searchwp_outside_main_query', '__return_true' );

		/**
		 * Fix: the "RYO Category Visibility" plugin caused the No posts found issue
		 * when replacing layout of category pages
		 *
		 * @since 4.9.0
		 */
		remove_action( 'pre_get_posts', 'ryocatvis_posts', 10, 1 );
	}

	// To not replace layout
	static function not_replace_when( $valid ) {
		// This plugin causes the posts from appearing above menu, in taxonomy archive page
		if ( (cv_is_active_plugin( 'seo-by-rank-math' ) || cv_is_active_plugin( 'ultimate-addons-for-gutenberg' )) && doing_action( 'wp_head' ) ) {
			$valid = false;
		}

		return $valid;
	}

	static function modify_params_some_cases( $args ) {
		if ( !isset( $args[ 'cvp_replace_layout_page' ] ) ) {
			return $args;
		}

		// Blog page: disable sticky posts in page > 1
		if ( $args[ 'cvp_replace_layout_page' ] === 'home' && PT_CV_Functions::get_global_variable( 'current_page' ) > 1 ) {
			$args[ 'ignore_sticky_posts' ] = true;
		}

		// Use WooCommerce orderby
		CVP_Replace_Layout_Compatible::plugin_woocommerce_set_order( $args );

		/**
		 * Search results is missing when select the 'use_filter_settings' option, with Goodlayers Core plugin
		 * Reason: CVP suppresses filters by default, but that plugin modified the 'posts_search' to find the keyword in its custom field (where stores post content)
		 * @since 5.1.1
		 */
		if ( function_exists( 'cv_is_active_plugin' ) && cv_is_active_plugin( 'goodlayers-core' ) ) {
			$args[ 'suppress_filters' ] = false;
		}

		return $args;
	}

	/*
	 * Theme4Press Alora theme
	 * Doesn't work on Search results page
	 */
	static function theme_alora_search_results() {
		if ( get_template() === 'alora' && is_search() && self::_is_enabled( 'search' ) ) {
			global $smof_data;
			unset( $smof_data[ 'search_results_per_page' ] );
		}
	}

	/**
	 * Enfold theme
	 * Doesn't work in Tag archive, Portfolio categories archive (these template files use the custom grid/loop)
	 */
	static function theme_enfold_change_template_file( $template ) {
		if ( CVP_Replace_Layout::precheck_right_place() && get_template() === 'enfold' ) {
			$file = false;

			if ( is_tag() ) {
				$file = 'tag.php';
			}

			if ( is_tax( 'portfolio_entries' ) ) {
				$file = 'taxonomy-portfolio_entries.php';
			}

			if ( $file ) {
				// Force to use archive.php (which uses the default loop)
				$template = str_replace( $file, 'archive.php', $template );
			}
		}

		return $template;
	}

	/**
	 * Enfold theme
	 * Prevent the 'blog-grid' style (which uses the custom grid/loop)
	 */
	static function theme_enfold_blog_style( $styles, $page ) {
		if ( CVP_Replace_Layout::precheck_right_place() && in_array( $page, array( 'blog', 'archive', 'tag' ) ) ) {
			$styles = 'single-small';
		}
		return $styles;
	}

	/**
	 * Woocommerce orderby doesn't work in Product Taxonomy page
	 *
	 * @since 4.7.2
	 * @param array $args
	 * @return array
	 */
	public static function plugin_woocommerce_set_order( &$args ) {
		if ( !empty( $args[ 'wc_query' ] ) && !empty( $_GET[ 'orderby' ] ) ) {
			$orderby = cv_esc_sql( $_GET[ 'orderby' ] );

			switch ( $orderby ) {
				case 'price':
					$args[ 'meta_key' ]	 = '_price';
					$args[ 'orderby' ]	 = array(
						'meta_value_num' => 'ASC',
						'ID'			 => 'DESC',
					);

					break;

				case 'price-desc':
					$args[ 'meta_key' ]	 = '_price';
					$args[ 'orderby' ]	 = array(
						'meta_value_num' => 'DESC',
						'ID'			 => 'DESC',
					);

					break;

				case 'popularity':
					$args[ 'meta_key' ]	 = 'total_sales';
					$args[ 'orderby' ]	 = array(
						'meta_value_num' => 'DESC',
						'ID'			 => 'DESC',
					);

					break;
			}
		}
	}

}

CVP_Replace_Layout_Compatible::init();

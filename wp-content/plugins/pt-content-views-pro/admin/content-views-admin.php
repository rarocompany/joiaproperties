<?php
/**
 * Content Views Admin
 *
 * @package   PT_Content_Views_Pro_Admin
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class PT_Content_Views_Pro_Admin extends PT_Content_Views_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		$this->plugin_slug = 'content-views-pro';

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ), 12 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 12 );
		add_action( 'admin_print_styles', array( $this, 'admin_print_styles' ), 12 );

		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Filter Setting options
		add_filter( PT_CV_PREFIX_ . 'view_version', array( $this, 'filter_view_version' ) );
		add_filter( PT_CV_PREFIX_ . 'view_row_actions', array( $this, 'filter_view_row_actions' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'view_actions', array( $this, 'filter_view_actions' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'upgrade_to_pro_text', array( $this, 'filter_upgrade_to_pro_text' ) );
		add_filter( PT_CV_PREFIX_ . 'custom_filters', array( $this, 'filter_custom_filters' ) );
		add_filter( PT_CV_PREFIX_ . 'setting_post_in', array( $this, 'filter_setting_post_in' ) );
		add_filter( PT_CV_PREFIX_ . 'setting_post_not_in', array( $this, 'filter_setting_post_not_in' ) );
		add_filter( PT_CV_PREFIX_ . 'exclude_extra_settings', array( $this, 'filter_exclude_extra_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'post_parent_settings', array( $this, 'filter_post_parent_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'after_limit_option', array( $this, 'filter_after_limit_option' ) );
		add_filter( PT_CV_PREFIX_ . 'post_types', array( $this, 'filter_post_types' ) );
		add_filter( PT_CV_PREFIX_ . 'post_types_list', array( $this, 'filter_post_types_list' ) );
		add_filter( PT_CV_PREFIX_ . 'orderby', array( $this, 'filter_orderby' ) );
		add_filter( PT_CV_PREFIX_ . 'orders', array( $this, 'filter_orders' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type', array( $this, 'filter_view_type' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type_settings', array( $this, 'filter_view_type_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type_settings_grid', array( $this, 'filter_view_type_settings_grid' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type_settings_collapsible_184', array( $this, 'filter_view_type_settings_collapsible' ) );
		add_filter( PT_CV_PREFIX_ . 'view_type_settings_scrollable', array( $this, 'filter_view_type_settings_scrollable' ) );
		add_filter( PT_CV_PREFIX_ . 'list_layouts', array( $this, 'filter_list_layouts' ) );
		add_filter( PT_CV_PREFIX_ . 'open_in', array( $this, 'filter_open_in' ) );
		add_filter( PT_CV_PREFIX_ . 'field_display', array( $this, 'filter_field_display' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'field_thumbnail_sizes', array( $this, 'filter_field_thumbnail_sizes' ) );
		add_filter( PT_CV_PREFIX_ . 'field_thumbnail_settings', array( $this, 'filter_field_thumbnail_settings' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'settings_other', array( $this, 'filter_settings_other' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'post_types_taxonomies', array( $this, 'filter_post_types_taxonomies' ) );
		add_filter( PT_CV_PREFIX_ . 'pagination_styles', array( $this, 'filter_pagination_styles' ) );
		add_filter( PT_CV_PREFIX_ . 'settings_sort', array( $this, 'filter_settings_sort' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'settings_sort_single', array( $this, 'filter_settings_sort_single' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'settings_sort_text', array( $this, 'filter_settings_sort_text' ) );
		add_filter( PT_CV_PREFIX_ . 'settings_title_display', array( $this, 'filter_settings_title_display' ), 10, 3 );
		add_filter( PT_CV_PREFIX_ . 'settings_taxonomies_display', array( $this, 'filter_settings_taxonomies_display' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'excerpt_settings', array( $this, 'filter_excerpt_settings' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'settings_pagination', array( $this, 'filter_settings_pagination' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'select_term_class', array( $this, 'filter_select_term_class' ) );
		add_filter( PT_CV_PREFIX_ . 'options_description', array( $this, 'filter_options_description' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'sticky_posts_setting', array( $this, 'filter_sticky_posts_setting' ) );
		add_filter( PT_CV_PREFIX_ . 'field_settings', array( $this, 'filter_field_settings' ), 10, 2 );
		add_filter( PT_CV_PREFIX_ . 'advanced_settings', array( $this, 'filter_advanced_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'advanced_settings_panel', array( $this, 'filter_advanced_settings_panel' ) );
		add_filter( PT_CV_PREFIX_ . 'taxonomies_custom_settings', array( $this, 'filter_taxonomies_custom_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'author_settings', array( $this, 'filter_author_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'viewtype_setting', array( $this, 'filter_viewtype_setting' ) );
		add_filter( PT_CV_PREFIX_ . 'format_settings', array( $this, 'filter_format_settings' ) );
		add_filter( PT_CV_PREFIX_ . 'contenttype_setting', array( $this, 'filter_contenttype_setting' ) );
		add_filter( PT_CV_PREFIX_ . 'pre_save_view_data', array( $this, 'filter_pre_save_view_data' ) );

		// Custom hooks for both preview & frontend
		PT_CV_Hooks_Pro::init();

		// Custom settings page
		PT_CV_Plugin_Pro::init();

		// Print custom CSS to header of Preview
		add_action( PT_CV_PREFIX_ . 'preview_header', array( 'PT_Content_Views_Pro', 'print_custom_css' ) );
		add_action( PT_CV_PREFIX_ . 'preview_footer', array( 'PT_Content_Views_Pro', 'print_custom_js' ) );

		// Add action before edit/trash View
		add_action( 'wp_trash_post', array( $this, 'action_before_delete_view' ) );
		add_action( 'before_delete_post', array( $this, 'action_before_delete_view' ) );

		// Add Tabs to Add/Edit View page
		add_action( PT_CV_PREFIX_ . 'setting_tabs_header', array( $this, 'action_setting_tabs_header' ) );
		add_action( PT_CV_PREFIX_ . 'setting_tabs_content', array( $this, 'action_setting_tabs_content' ) );

		// Add more buttons to View edit page
		add_action( PT_CV_PREFIX_ . 'admin_more_buttons', array( $this, 'action_admin_more_buttons' ) );

		// Ajax action to search posts by title
		$action = 'search_by_title';
		add_action( 'wp_ajax_' . $action, array( 'PT_CV_Functions_Pro', 'ajax_callback_' . $action ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {
		$screen = get_current_screen();
		if ( strpos( $screen->id, PT_CV_DOMAIN ) !== false ) {

			// Main admin style
			PT_CV_Asset::enqueue(
				'admin', 'style', array(
				'src'	 => plugins_url( 'assets/css/admin.css', __FILE__ ),
				'ver'	 => PT_CV_VERSION_PRO,
				), PT_CV_PREFIX_PRO
			);

			PT_CV_Asset::enqueue(
				'selectize', 'style', array(
				'src' => plugins_url( 'assets/css/selectize.bootstrap3.css', __FILE__ ),
				), PT_CV_PREFIX_PRO
			);

			// For Preview
			PT_CV_Html_Pro::frontend_styles();
		}
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {
		$screen = get_current_screen();
		if ( strpos( $screen->id, PT_CV_DOMAIN ) !== false ) {

			// Main admin script
			PT_CV_Asset::enqueue(
				'admin', 'script', array(
				'src'	 => plugins_url( 'assets/js/admin.js', __FILE__ ),
				'ver'	 => PT_CV_VERSION_PRO,
				'deps'	 => array( 'jquery' ),
				), PT_CV_PREFIX_PRO
			);

			// Localize strings
			PT_CV_Asset::localize_script(
				'admin', PT_CV_PREFIX_UPPER . 'ADMIN_PRO', array(
				'_nonce'				 => wp_create_nonce( PT_CV_PREFIX_ . 'ajax_nonce' ),
				'supported_version'		 => PT_CV_Functions::wp_version_compare( '3.5' ),
				'fonts'					 => array(
					'google' => json_encode( PT_CV_Functions_Pro::get_google_fonts() ),
				),
				'message'				 => array(
					'textcolor'		 => __( 'Text Color' ),
					'bgcolor'		 => __( 'Background Color' ),
					'delete'		 => __( 'Delete' ) . '?',
					'reposition_lf'	 => __( '[Preview Mode] You can drag & drop below filters to reposition them', 'content-views-pro' ),
				),
				'custom_field'			 => array(
					'type_operator' => array(
						'CHAR'		 => array( '=', 'IN', 'NOT IN', 'LIKE', 'NOT LIKE', 'EXISTS', 'NOT EXISTS' ),
						'NUMERIC'	 => array( '=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS', 'NOT EXISTS' ),
						'DECIMAL'	 => array( '=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS', 'NOT EXISTS' ),
						'DATE'		 => array( 'TODAY', 'NOW_PAST', 'NOW_FUTURE', 'IN_PAST', '=', '!=', '>', '>=', '<', '<=', 'BETWEEN', 'NOT BETWEEN', 'EXISTS', 'NOT EXISTS' ),
						'DATETIME'	 => array( 'NOW_PAST', 'NOW_FUTURE', 'IN_PAST', '=', '!=', '>', '>=', '<', '<=', 'BETWEEN', 'NOT BETWEEN', 'EXISTS', 'NOT EXISTS' ),
						'BINARY'	 => array( '=', '!=', 'EXISTS', 'NOT EXISTS' ),
					)
				),
				'enable_toggle_settings' => apply_filters( PT_CV_PREFIX_ . 'enable_toggle_settings', true ),
				'layout_image_dir'		 => plugins_url( 'assets/images/layouts/', __FILE__ )
				), PT_CV_PREFIX_PRO
			);

			// Color picker with Opacity
			PT_CV_Asset::enqueue(
				'color-picker', 'script', array(
				'src'	 => plugins_url( 'assets/js/color-picker.js', __FILE__ ),
				'ver'	 => PT_CV_VERSION_PRO,
				'deps'	 => array( 'wp-color-picker' ),
				), PT_CV_PREFIX_PRO
			);

			// Datepicker
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ) );

			// Select2 sortable
			PT_CV_Asset::enqueue(
				'select2.sortable', 'script', array(
				'src'	 => plugins_url( 'assets/js/select2.sortable.js', __FILE__ ),
				'ver'	 => '1.0',
				)
			);

			PT_CV_Asset::enqueue(
				'selectize', 'script', array(
				'src'	 => plugins_url( 'assets/js/selectize.js', __FILE__ ),
				'ver'	 => '1.0',
				)
			);

			// For Preview
			PT_CV_Html_Pro::frontend_scripts();
		}
	}

	/**
	 * Print custom style in Admin
	 *
	 * @since     1.0.0
	 *
	 * @return    null
	 */
	public function admin_print_styles() {

		$screen = get_current_screen();
		if ( is_object( $screen ) && strpos( $screen->id, PT_CV_DOMAIN ) !== false ) {

			// Datepicker
			wp_enqueue_style( 'jquery-ui', '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.8.24/themes/base/jquery-ui.css' );

			// For Google Font
			echo "<style>\n";
			echo PT_CV_Functions_Pro::get_google_fonts_background_position();
			echo "\n</style>";
		}
	}

	public function add_plugin_admin_menu() {
		$cv_admin	 = PT_Content_Views_Admin::get_instance();
		$user_role	 = current_user_can( 'administrator' ) ? 'administrator' : PT_CV_Functions::get_option_value( 'access_role', 'administrator' );
		$page		 = __( 'Replace Layout', 'content-views-pro' );

		$cv_admin->plugin_sub_screen_hook_suffix[] = PT_CV_Functions::menu_add_sub(
				$cv_admin->plugin_slug, $page, $page, $user_role, 'replayout', __CLASS__
		);
	}

	public static function display_sub_page_replayout() {
		include_once( 'includes/replayout.php' );
	}

	/**
	 * Version of current View (when it created/modified)
	 * @param string $args
	 * @return string
	 */
	public function filter_view_version( $args ) {
		$args = 'pro-' . PT_CV_VERSION_PRO;

		return $args;
	}

	/**
	 * Add more actions to All Views page : Duplicate
	 *
	 * @param array  $args    Array of actions
	 * @param string $view_id The View ID
	 *
	 * @return array
	 */
	public function filter_view_row_actions( $args, $view_id ) {
		$duplicate_link		 = PT_CV_Functions::view_link( $view_id, array( 'action' => 'duplicate' ) );
		$args[ 'duplicate' ] = '<a href="' . esc_url( $duplicate_link ) . '" target="_blank">' . __( 'Duplicate this view', 'content-views-pro' ) . '</a>';

		return $args;
	}

	/**
	 * Add view action buttons: Duplicate
	 *
	 * @param array  $args
	 * @param string $view_id The View ID
	 *
	 * @return string
	 */
	public function filter_view_actions( $args, $view_id ) {
		$args = sprintf( '<a class="btn btn-info" href="%s" style="float: right;">%s</a>', PT_CV_Functions::view_link( $view_id, array( 'action' => 'duplicate' ) ), __( 'Duplicate this view', 'content-views-pro' ) );

		return $args;
	}

	/**
	 * Filter upgrade to Pro text
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function filter_upgrade_to_pro_text( $args ) {
		return '';
	}

	/**
	 * Filter common filter: Add select Products
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_custom_filters( $args ) {
		// Select multiple post types
		$_post_types = PT_CV_Values::post_types();
		unset( $_post_types[ 'any' ] );
		$post_types	 = array(
			'label'		 => array(
				'text' => '',
			),
			'params'	 => array(
				array(
					'type'		 => 'select',
					'name'		 => 'multi-post-types',
					'options'	 => $_post_types,
					'std'		 => '',
					'class'		 => 'select2',
					'multiple'	 => '1',
					'desc'		 => __( 'Leave empty to include all post types', 'content-views-pro' )
				),
			),
			'dependence' => array( 'content-type', 'any' ),
		);

		// Products
		$woo = array(
			'label'		 => array(
				'text' => __( 'WooCommerce filters', 'content-views-pro' ),
			),
			'params'	 => array(
				array(
					'type'		 => 'radio',
					'name'		 => 'products-list',
					'options'	 => PT_CV_Values_Pro::field_product_lists(),
					'std'		 => '',
				),
			),
			'dependence' => array( 'content-type', 'product' ),
		);

		$args = array(
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
						$post_types,
						$woo,
					),
				),
			),
		);

		return $args;
	}

	// Add more description for Post_in
	public function filter_setting_post_in( $args ) {
		$args = __( 'Enter post IDs, or type to search by post Title', 'content-views-pro' ) . '. ' . __( 'Drag and drop to change display order of them', 'content-views-pro' );
		return $args;
	}

	// Add more description for Post_not_in
	public function filter_setting_post_not_in( $args ) {
		$args = __( 'Enter post IDs, or type to search by post Title', 'content-views-pro' );
		return $args;
	}

	/**
	 * Add options for Exclude setting
	 *
	 * @param array $args
	 */
	public function filter_exclude_extra_settings( $args ) {
		$args = array(
			'label'		 => array(
				'text' => '',
			),
			'params'	 => array(
				array(
					'type'	 => 'group',
					'params' => array(
						array(
							'label'			 => array(
								'text' => '',
							),
							'extra_setting'	 => array(
								'params' => array(
									'width'		 => 12,
									'wrap-class' => PT_CV_PREFIX . 'append-options',
									'wrap-id'	 => PT_CV_PREFIX . 'exclude-checkboxes',
								),
							),
							'params'		 => array(
								array(
									'type'		 => 'checkbox',
									'name'		 => 'exclude-current',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Exclude current post', 'content-views-pro' ) ),
									'std'		 => '',
								),
								array(
									'type'		 => 'checkbox',
									'name'		 => 'exclude-pw-protected',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Exclude password protected posts', 'content-views-pro' ) ),
									'std'		 => '',
								),
								array(
									'type'		 => 'checkbox',
									'name'		 => 'exclude-children-posts',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Exclude children posts', 'content-views-pro' ) ),
									'std'		 => '',
								),
							),
						),
					),
				),
			),
			'dependence' => array( 'post__in', '' ),
		);

		return $args;
	}

	/**
	 * Add options for Parent page
	 *
	 * @param array $args
	 */
	public function filter_post_parent_settings( $args ) {

		$args = array(
			'label'		 => array(
				'text' => '',
			),
			'params'	 => array(
				array(
					'type'	 => 'group',
					'params' => array(
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
									'type'		 => 'checkbox',
									'name'		 => 'post_parent-current',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Use current page as base/parent page then', 'content-views-pro' ) ),
									'std'		 => '',
								),
							),
						),
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
									'type'		 => 'select',
									'name'		 => 'post_parent-auto',
									'options'	 => PT_CV_Values_Pro::parent_page_options(),
									'std'		 => '',
								),
							),
							'dependence'	 => array( 'post_parent-current', 'yes' ),
						),
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
													'content'	 => sprintf( '<p style="margin-bottom:0">%s</p>', __( 'Show this information of Parent page:', 'content-views-pro' ) ),
												),
											),
										),
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
													'type'		 => 'select',
													'name'		 => 'post_parent-auto-info',
													'options'	 => PT_CV_Values_Pro::parent_page_info(),
													'std'		 => '',
												),
											),
										),
									),
								),
							),
							'dependence'	 => array( array( 'post_parent', '', '!=' ), array( 'post_parent-current', 'yes' ) ),
						),
					),
				),
			),
			'dependence' => array( 'content-type', apply_filters( PT_CV_PREFIX_ . 'hierarchical_post_type', array( 'page' ) ) ),
		);

		return $args;
	}

	/**
	 * Filter common filter: Add Offset
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_after_limit_option( $args ) {
		// Offset
		$args = array(
			'label'	 => array(
				'text' => __( 'Offset', 'content-views-pro' ),
			),
			'params' => array(
				array(
					'type'	 => 'number',
					'name'	 => 'offset',
					'std'	 => '',
					'min'	 => '0',
					'desc'	 => __( 'The number of posts to skip. Leave empty to start from the first post', 'content-views-pro' ),
				),
			),
		);

		return $args;
	}

	/**
	 * Filter post types: Get all registered post types
	 *
	 * @param array $args Array to filter
	 *
	 * @return boolean
	 */
	public function filter_post_types( $args ) {
		unset( $args[ '_builtin' ] );

		return $args;
	}

	/**
	 * Add option to query any post types
	 *
	 * @return array
	 */
	public function filter_post_types_list( $args ) {
		$args[ 'attachment' ]	 = __( 'Media' );
		$args[ 'any' ]			 = __( 'All / Multi post types', 'content-views-pro' );

		return $args;
	}

	/**
	 * Filter orderby: Add advanced options
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_orderby( $args ) {

		$args[ 'common' ][ 'dragdrop-pids' ]		 = array(
			'label'		 => array(
				'text' => '',
			),
			'params'	 => array(
				array(
					'type'	 => 'text',
					'name'	 => 'order-dragdrop-pids',
					'std'	 => '',
				),
			),
			'dependence' => array( 'orderby', 'dragdrop' ),
		);
		$args[ 'common' ][ 'dragdrop-nosupport' ]	 = array(
			'label'		 => array(
				'text' => '',
			),
			'params'	 => array(
				array(
					'type'		 => 'html',
					'content'	 => sprintf( '<p class="cvp-notice" style="margin-top:-10px">%s</p>', __( "It works with 3 layouts: Grid, Scrollable list, Collapsible list.<br>It does <strong>NOT work</strong> with Shuffle Filter, Live Filter, Replace Layout, Pagination (load more, infinite scrolling).", 'content-views-pro' ) ),
				),
			),
			'dependence' => array( 'orderby', 'dragdrop' ),
		);

        // Custom field order by
		$args[ __( 'Custom Fields' ) ] = array(
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
						'type'		 => 'html',
						'content'	 => self::sort_by_custom_fields(),
					),
					array(
						'type'		 => 'html',
						'content'	 => self::sort_by_custom_fields_footer(),
					),
					array(
						'type'		 => 'html',
						'content'	 => sprintf( '<br><p class="cvp-notice">%s.</p>', __( 'Sorting by custom field will remove posts (which don\'t have the field) from result.<br> Please change or delete field if there are missing posts in result', 'content-views-pro' ) ),
					),
				),
			),
		);

		return $args;
	}

	/**
	 * Add dependence for Order
	 * @param array $args
	 * @return array
	 */
	public function filter_orders( $args ) {
		$args[ 'dependence' ] = array( 'orderby', array( 'rand', 'dragdrop' ), '!=' );

		return $args;
	}

	/**
	 * Filter view type : Add timeline, calendar ...
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_view_type( $args ) {
		$args = array_merge( $args, PT_CV_Values_Pro::view_type_pro() );

		return $args;
	}

	/**
	 * Filter view type settings : Add Scrollable List, Pinterest, Timeline ... settings
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_view_type_settings( $args ) {

		// Settings of One and others
		$args[ 'one_others' ] = PT_CV_Settings_Pro::view_type_settings_one_and_others();

		// Settings of Pinterest type
		$args[ 'pinterest' ] = PT_CV_Settings_Pro::view_type_settings_pinterest();

		// Settings of Masonry type
		$args[ 'masonry' ] = PT_CV_Settings_Pro::view_type_settings_masonry();

		// Settings of Timeline type
		$args[ 'timeline' ] = PT_CV_Settings_Pro::view_type_settings_timeline();

		// Settings of Glossary type
		$args[ 'glossary' ] = PT_CV_Settings_Pro::view_type_settings_glossary();

		return $args;
	}

	/**
	 * Filter settings for Grid
	 *
	 * @param type $args
	 */
	public function filter_view_type_settings_grid( $args ) {
		$prefix		 = 'grid-';
		$settings	 = array();

		$settings[] = array(
			'label'			 => array(
				'text' => '',
			),
			'extra_setting'	 => array(
				'params' => array(
					'wrap-class' => 'has-popover',
					'width'		 => 12,
				),
			),
			'params'		 => array(
				array(
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'same-height',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Line up fields across items', 'content-views-pro' ) ),
					'std'		 => '',
					'popover'	 => sprintf( "<img src='%s'>", plugins_url( 'assets/images/popover/grid-lineup.png', __FILE__ ) ),
				),
			),
		);

		$settings[] = array(
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
					'content'	 => sprintf( '<p class="text-muted" style="margin-top:-10px">%s</p>', __( 'If images are not same size, please <a href="https://docs.contentviewspro.com/show-thumbnail-image-size-difference/" target="_blank">show images in same size</a>', 'content-views-pro' ) ),
				),
			),
			'dependence'	 => array( 'grid-same-height', 'yes' ),
		);

		$settings[] = array(
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
					'type'		 => 'checkbox',
					'name'		 => 'post-border',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show border around posts', 'content-views-pro' ) ),
					'std'		 => '',
				),
			),
		);

		$settings[] = array(
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
					'content'	 => sprintf( '<p class="cvp-notice" style="margin-top: 10px">%s</p>', __( 'Above features do NOT work with Shuffle Filter', 'content-views-pro' ) ),
				),
			),
			'dependence'	 => array( 'enable-taxonomy-filter', 'yes' ),
		);

		$args[] = array(
			'label'	 => array(
				'text' => __( 'Options', 'content-views-pro' ),
			),
			'params' => array(
				array(
					'type'	 => 'group',
					'params' => $settings,
				),
			),
		);

		return $args;
	}

	/**
	 * Filter settings for Collapsible List
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function filter_view_type_settings_collapsible( $args ) {
		$prefix = 'collapsible-';

		$args[] = array(
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
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'open-all',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Open all items', 'content-views-pro' ) ),
					'std'		 => '',
				),
			),
		);

		return $args;
	}

	/**
	 * Settings of View type = Scrollable
	 *
	 * @return array
	 */
	public function filter_view_type_settings_scrollable( $args ) {
		$prefix = 'scrollable-';

		$args = array(
			// Number of columns
			array(
				'label'	 => array(
					'text' => __( 'Items per row', 'content-views-query-and-display-post-page' ),
				),
				'params' => array(
					array(
						'type'			 => 'number',
						'name'			 => $prefix . 'number-columns',
						'std'			 => '2',
						'append_text'	 => '1 &rarr; 12',
					),
				),
			),
			// Number of rows
			array(
				'label'			 => array(
					'text' => __( 'Rows per slide', 'content-views-pro' ),
				),
				'extra_setting'	 => array(
					'params' => array(
						'wrap-class' => PT_CV_PREFIX . 'w200',
					),
				),
				'params'		 => array(
					array(
						'type'			 => 'number',
						'name'			 => $prefix . 'number-rows',
						'std'			 => '2',
						'append_text'	 => '1 &rarr; 12',
					),
				),
			),
			array(
				'label'	 => array(
					'text' => __( 'Options', 'content-views-pro' ),
				),
				'params' => array(
					array(
						'type'	 => 'group',
						'params' => array(
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
										'type'		 => 'checkbox',
										'name'		 => $prefix . 'navigation',
										'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show Next/Prev button' ) ),
										'std'		 => 'yes',
									),
								),
							),
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
										'type'		 => 'checkbox',
										'name'		 => $prefix . 'indicator',
										'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show circle indicators' ) ),
										'std'		 => 'yes',
									),
								),
							),
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
										'type'		 => 'checkbox',
										'name'		 => $prefix . 'auto-cycle',
										'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Automatic cycle' ) ),
										'std'		 => 'yes',
									),
								),
							),
							array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'		 => 12,
										'wrap-class' => PT_CV_PREFIX . 'w200',
									),
								),
								'params'		 => array(
									array(
										'type'	 => 'number',
										'name'	 => $prefix . 'interval',
										'std'	 => '5',
										'min'	 => '1',
										'desc'	 => __( 'Seconds to delay between cycles', 'content-views-pro' ),
									),
								),
								'dependence'	 => array( $prefix . 'auto-cycle', 'yes' ),
							),
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
										'type'		 => 'checkbox',
										'name'		 => $prefix . 'textbelow',
										'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show text below thumbnail' ) ),
										'std'		 => '',
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
	 * Filter List layouts : Add Pinterest, Portfolio ...
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_list_layouts( $args ) {
		$args = array_merge(
			$args, array(
			'pinterest' => __( 'Pinterest', 'content-views-pro' ),
			)
		);

		return $args;
	}

	/**
	 * Filter Open in: Add Lightbox
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_open_in( $args ) {
		$args = array_merge(
			$args, array(
			PT_CV_PREFIX . 'window'			 => __( 'New window', 'content-views-pro' ),
			PT_CV_PREFIX . 'lightbox'		 => __( 'Light box of Post Content', 'content-views-pro' ),
			PT_CV_PREFIX . 'lightbox-image'	 => __( 'Light box of Post Thumbnail', 'content-views-pro' ),
			PT_CV_PREFIX . 'none'			 => sprintf( '%s (%s)', __( 'None' ), __( 'no link, no action', 'content-views-pro' ) ),
			)
		);

		return $args;
	}

	/**
	 * Filter Field Display options: Add Show Price & Add to cart button
	 *
	 * @param array  $args
	 * @param string $prefix The prefix for name of option
	 *
	 * @return array
	 */
	public function filter_field_display( $args, $prefix ) {
		// Show Custom fields
		$args[] = array(
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
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'custom-fields',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show Custom Fields', 'content-views-pro' ) ),
					'std'		 => '',
				),
			),
		);

		// Show Price
		$args[] = array(
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
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'price',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show Price & Add To Cart Button', 'content-views-pro' ) ),
					'std'		 => 'yes',
				),
			),
			'dependence'	 => array( 'content-type', 'product' ),
		);

		// Show Sale badge
		$args[] = array(
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
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'woosale',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show Sale Badge', 'content-views-pro' ) ),
					'std'		 => 'yes',
				),
			),
			'dependence'	 => array( 'content-type', 'product' ),
		);

		// Show EDD Purchase Link
		$args[] = array(
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
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'edd-purchase',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show Purchase Button (EDD)', 'content-views-pro' ) ),
					'std'		 => 'yes',
				),
			),
			'dependence'	 => array( 'content-type', 'download' ),
		);

		// Show Post Format icon
		$args[] = array(
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
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'format-icon',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show Post Format Icon', 'content-views-pro' ) ),
					'std'		 => '',
				),
			),
			'dependence'	 => array( 'content-type', 'post' ),
		);

		return $args;
	}

	/**
	 * Filter Thumbnail Sizes: Add Custom Size, Auto Fit
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_field_thumbnail_sizes( $args ) {

		$args[ PT_CV_PREFIX . 'custom' ] = __( '< Custom Size >', 'content-views-pro' );

		return $args;
	}

	/**
	 * Filter Thumbnail Settings: Add Custom Size Settings, Thumbnail Style
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_field_thumbnail_settings( $args, $prefix ) {

		// Move "disable wp 4.4 responsive image" to below custom widthxheight
		$disable_wp44_resimg = array();
		if ( isset( $args[ 'disable-wp44-resimg' ] ) ) {
			$disable_wp44_resimg = $args[ 'disable-wp44-resimg' ];
			unset( $args[ 'disable-wp44-resimg' ] );
		}

		$args = array_merge(
			$args, array(
			// Custom Size
			array(
				'label'		 => array(
					'text' => '',
				),
				'params'	 => array(
					array(
						'type'	 => 'group',
						'params' => array(
							// Width
							array(
								'label'	 => array(
									'text' => __( 'Width' ),
								),
								'params' => array(
									array(
										'type'			 => 'number',
										'name'			 => $prefix . 'thumbnail-size-custom-width',
										'std'			 => '',
										'append_text'	 => 'px',
									),
								),
							),
							// Height
							array(
								'label'	 => array(
									'text' => __( 'Height' ),
								),
								'params' => array(
									array(
										'type'			 => 'number',
										'name'			 => $prefix . 'thumbnail-size-custom-height',
										'std'			 => '',
										'append_text'	 => 'px',
									),
								),
							),
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
										'type'		 => 'radio',
										'name'		 => $prefix . 'thumbnail-resize',
										'options'	 => array(
											''		 => __( 'Hard resize (generate new image if not existing). Width or height can be empty.<br><span class="cvp-notice">Do NOT work when using external URL, cloud CDN, Jetpack Photon, etc. for images.</span>', 'content-views-pro' ),
											'soft'	 => __( 'Soft resize (show full image in selected size by CSS). Width and height are required.', 'content-views-pro' ),
										),
										'std'		 => '',
									),
								),
							),
						),
					),
				),
				'dependence' => array( $prefix . 'thumbnail-size', PT_CV_PREFIX . 'custom' ),
			),
			array(
				'label'		 => array(
					'text' => '',
				),
				'params'	 => array(
					array(
						'type'		 => 'checkbox',
						'name'		 => $prefix . 'thumbnail-same-size',
						'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show all images in same size', 'content-views-pro' ) ),
						'std'		 => '',
					),
				),
				'dependence' => array( $prefix . 'thumbnail-size', array( 'full', PT_CV_PREFIX . 'custom' ), '!=' ),
			),
			$disable_wp44_resimg,
			array(
				'label'			 => array(
					'text' => __( 'Style', 'content-views-query-and-display-post-page' ),
				),
				'extra_setting'	 => array(
					'params' => array(
						'wrap-class' => PT_CV_PREFIX . 'w200',
					),
				),
				'params'		 => array(
					array(
						'type'		 => 'select',
						'name'		 => $prefix . 'thumbnail-style',
						'options'	 => PT_CV_Values_Pro::field_thumbnail_styles(),
						'std'		 => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::field_thumbnail_styles() ),
					),
				),
			),
			array(
				'label'		 => array(
					'text' => '',
				),
				'params'	 => array(
					array(
						'type'		 => 'html',
						'content'	 => sprintf( '<p class="text-muted" style="margin-top:-8px">%s</p>', __( 'This style does not work with Animation/Overlay', 'content-views-pro' ) ),
					),
				),
				'dependence' => array( $prefix . 'thumbnail-style', 'img-shadow' ),
			),
			array(
				'label'			 => array(
					'text' => __( 'Border radius', 'content-views-pro' ),
				),
				'extra_setting'	 => array(
					'params' => array(
						'wrap-id' => PT_CV_PREFIX . 'thumbnail-border-radius',
					),
				),
				'params'		 => array(
					array(
						'type'			 => 'number',
						'name'			 => 'thumbnail-border-radius',
						'std'			 => '6',
						'append_text'	 => 'px',
					),
				),
				'dependence'	 => array( $prefix . 'thumbnail-style', 'img-rounded' ),
			),
			array(
				'label'	 => array(
					'text' => __( 'Substitute', 'content-views-pro' ),
				),
				'params' => array(
					array(
						'type'	 => 'group',
						'params' => array(
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
										'type'		 => 'html',
										'content'	 => sprintf( '<p style="margin-bottom:0;padding-top:5px">%s:</p>', __( 'Show below thing', 'content-views-pro' ) ),
									),
								),
							),
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
										'type'		 => 'select',
										'name'		 => $prefix . 'thumbnail-auto',
										'options'	 => PT_CV_Values_Pro::auto_thumbnail(),
										'std'		 => 'image',
									),
								),
							),
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
										'type'		 => 'select',
										'name'		 => $prefix . 'thumbnail-ctf',
										'options'	 => PT_CV_Values_Pro::custom_fields( 'default empty' ),
										'std'		 => '',
										'class'		 => 'select2',
										'desc'		 => __( 'Select the custom field contains image URL or ID', 'content-views-pro' ),
									),
								),
								'dependence'	 => array( $prefix . 'thumbnail-auto', 'image-ctf' ),
							),
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
										'type'		 => 'radio',
										'name'		 => $prefix . 'thumbnail-role',
										'options'	 => array(
											''				 => __( 'if no featured image found', 'content-views-pro' ),
											'replacement'	 => __( 'even featured image was found', 'content-views-pro' ),
										),
										'std'		 => '',
									),
								),
							),
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
										'type'		 => 'checkbox',
										'name'		 => $prefix . 'thumbnail-nodefault',
										'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Do not show default image (if no image/video/audio found)' ) ),
										'std'		 => '',
									),
								),
							),
						),
					),
				),
			),
			array(
				'label'	 => array(
					'text' => __( 'Lazy load', 'content-views-pro' ),
				),
				'params' => array(
					array(
						'type'		 => 'checkbox',
						'name'		 => $prefix . 'thumbnail-lazyload',
						'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Enable' ) ),
						'std'		 => '',
						'desc'		 => __( 'Defer loading of image, iframe to improve performance' ),
					),
				),
			),
			)
		);

		return $args;
	}

	/**
	 * Filter View Type Other settings: Add Lightbox Size option
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_settings_other( $args, $prefix ) {

		/**
		 * Social share buttons
		 */
		$social_links = array(
			'label'	 => array(
				'text' => __( 'Social sharing', 'content-views-pro' ),
			),
			'params' => array(
				array(
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'social-show',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Enable' ) ),
					'std'		 => '',
				),
			),
		);

		$social_links_detail = array(
			'label'			 => array(
				'text' => '',
			),
			'extra_setting'	 => array(
				'params' => array(
					'wrap-class' => PT_CV_PREFIX . 'social-links',
					'width'		 => 9,
				),
			),
			'params'		 => array(
				array(
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'social-buttons[]',
					'options'	 => PT_CV_Values_Pro::social_buttons(),
					'std'		 => array( 'facebook', 'twitter', 'googleplus' ),
				),
			),
			'dependence'	 => array( $prefix . 'social-show', 'yes' ),
		);

		// Social count
		$social_count = array(
			'label'		 => array(
				'text' => '',
			),
			'params'	 => array(
				array(
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'social-count',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show share count', 'content-views-pro' ) ),
					'std'		 => '',
				),
			),
			'dependence' => array( $prefix . 'social-show', 'yes' ),
		);

		/**
		 * Link settings: nofollow
		 */
		$link_settings = array(
			'label'	 => array(
				'text' => __( 'Nofollow', 'content-views-pro' ),
			),
			'params' => array(
				array(
					'type'		 => 'checkbox',
					'name'		 => 'link-follow',
					'options'	 => PT_CV_Values::yes_no( 'yes', sprintf( __( 'Use %s for item links', 'content-views-pro' ), '<code>rel="nofollow"</code>' ) ),
					'std'		 => '',
				),
			),
		);

		array_unshift( $args, $link_settings );
		array_unshift( $args, $social_count );
		array_unshift( $args, $social_links_detail );
		array_unshift( $args, $social_links );

		/**
		 * Window Size
		 */
		$prefix2 = $prefix . 'window-';

		$args = array_merge(
			$args, array(
			array(
				'label'		 => array(
					'text' => __( 'Window size', 'content-views-pro' ),
				),
				'params'	 => array(
					array(
						'type'	 => 'group',
						'params' => array(
							// Width
							array(
								'label'	 => array(
									'text' => __( 'Width' ),
								),
								'params' => array(
									array(
										'type'			 => 'number',
										'name'			 => $prefix2 . 'size-width',
										'std'			 => '600',
										'placeholder'	 => 'for example: 600',
										'min'			 => '100',
										'append_text'	 => 'px',
									),
								),
							),
							// Height
							array(
								'label'	 => array(
									'text' => __( 'Height' ),
								),
								'params' => array(
									array(
										'type'			 => 'number',
										'name'			 => $prefix2 . 'size-height',
										'std'			 => '400',
										'placeholder'	 => 'for example: 400',
										'min'			 => '100',
										'append_text'	 => 'px',
									),
								),
							),
						),
					),
				),
				'dependence' => array( $prefix . 'open-in', PT_CV_PREFIX . 'window' ),
			),
			)
		);

		/**
		 * Lightbox size
		 */
		$prefix2 = $prefix . 'lightbox-';

		$args = array_merge(
			$args, array(
			array(
				'label'		 => array(
					'text' => '',
				),
				'params'	 => array(
					array(
						'type'		 => 'checkbox',
						'name'		 => $prefix2 . 'enable-navigation',
						'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Enable navigation in lightbox', 'content-views-pro' ) ),
						'std'		 => '',
					),
				),
				'dependence' => array( $prefix . 'open-in', PT_CV_PREFIX . 'lightbox-image' ),
			),
			array(
				'label'		 => array(
					'text' => '',
				),
				'params'	 => array(
					array(
						'type'		 => 'checkbox',
						'name'		 => $prefix2 . 'full-image',
						'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show full size image in lightbox', 'content-views-pro' ) ),
						'std'		 => '',
					),
				),
				'dependence' => array( $prefix . 'open-in', PT_CV_PREFIX . 'lightbox-image' ),
			),
			// Lightbox size
			array(
				'label'		 => array(
					'text' => __( 'Lightbox size', 'content-views-pro' ),
				),
				'params'	 => array(
					array(
						'type'	 => 'group',
						'params' => array(
							// Width
							array(
								'label'	 => array(
									'text' => __( 'Width' ),
								),
								'params' => array(
									array(
										'type'			 => 'number',
										'name'			 => $prefix2 . 'size-width',
										'std'			 => '75',
										'placeholder'	 => 'for example: 75',
										'append_text'	 => '%',
									),
								),
							),
							// Height
							array(
								'label'	 => array(
									'text' => __( 'Height' ),
								),
								'params' => array(
									array(
										'type'			 => 'number',
										'name'			 => $prefix2 . 'size-height',
										'std'			 => '75',
										'placeholder'	 => 'for example: 75',
										'append_text'	 => '%',
									),
								),
							),
						),
					),
				),
				'dependence' => array( $prefix . 'open-in', PT_CV_PREFIX . 'lightbox' ),
			),
			// Lightbox content id
			array(
				'label'		 => array(
					'text' => __( 'Content selector', 'content-views-pro' ),
				),
				'params'	 => array(
					array(
						'type'	 => 'text',
						'name'	 => $prefix2 . 'content-selector',
						'std'	 => '',
						'desc'	 => sprintf( __( 'By default, whole page will be loaded (Header, Content, Footer). To load only Content, please enter selector to identify it %s', 'content-views-pro' ), '(for example: <code>#content</code> or <code>#main</code> or <code>.post</code> or <code>.hentry</code> or <code>article</code>). This value depends on the active theme' ),
					),
				),
				'dependence' => array( $prefix . 'open-in', PT_CV_PREFIX . 'lightbox' ),
			),
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
								'label'		 => array(
									'text' => '',
								),
								'params'	 => array(
									array(
										'type'		 => 'html',
										'content'	 => sprintf( '<p class="cvp-notice">%s.</p>', __( 'Loading only content is not a complete environment as whole page. Styles and scripts of theme and other plugins might be missing or not executed, which cause unexpected output', 'content-views-pro' ) ),
									),
								),
								'dependence' => array( $prefix2 . 'content-selector', '', '!=' ),
							),
						),
					),
				),
				'dependence'	 => array( $prefix . 'open-in', PT_CV_PREFIX . 'lightbox' ),
			),
			)
		);

		return $args;
	}

	/**
	 * Add ('any' => all taxonomies) to post types list
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function filter_post_types_taxonomies( $args ) {
		// Get all taxonomies
		$taxonomies		 = get_taxonomies();
		$args[ 'any' ]	 = array_values( $taxonomies );

		return $args;
	}

	/**
	 * Filter Pagination Style: add Load more option
	 *
	 * @param array $args Array to filter
	 *
	 * @return array
	 */
	public function filter_pagination_styles( $args ) {

		$args[ 'infinite' ]	 = __( 'Infinite scrolling', 'content-views-pro' );
		$args[ 'loadmore' ]	 = __( 'Load more button', 'content-views-pro' );

		return $args;
	}

	/**
	 * Sort array of settings by saved order
	 *
	 * @param array  $args
	 * @param string $prefix
	 */
	public function filter_settings_sort( $args, $prefix ) {

		// Get settings of current View
		global $pt_cv_admin_settings;

		if ( is_array( $pt_cv_admin_settings ) ) {
			$args = PT_CV_Functions_Pro::settings_sort( $prefix, $args, array_keys( $pt_cv_admin_settings ) );
		}

		return $args;
	}

	/**
	 * Sort values inside a single option
	 *
	 * @param array  $args
	 * @param string $option_name Name of parameter
	 *
	 * @return array
	 */
	public function filter_settings_sort_single( $args, $option_name ) {
		// Get settings of current View
		global $pt_cv_admin_settings;

		$saved_data = isset( $pt_cv_admin_settings[ PT_CV_PREFIX . $option_name ] ) ? $pt_cv_admin_settings[ PT_CV_PREFIX . $option_name ] : '';

		if ( !$saved_data ) {
			return $args;
		}

		$result = array();

		// Get value of saved key
		foreach ( (array) $saved_data as $key ) {
			if ( isset( $args[ $key ] ) ) {
				$result[ $key ] = $args[ $key ];
				unset( $args[ $key ] );
			}
		}

		// Append other keys to result
		$result = $result + $args;

		if ( $result ) {
			$args = $result;
		}

		return $args;
	}

	/**
	 * Filter description to sorting fields
	 *
	 * @param string $args
	 *
	 * @return string
	 */
	public function filter_settings_sort_text( $args ) {
		$args = __( 'Drag & drop above checkboxes to change display order of fields', 'content-views-pro' );

		return $args;
	}

	/**
	 * Add custom settings for Title display
	 *
	 * @param array $args
	 */
	public function filter_settings_title_display( $args, $prefix, $prefix2 ) {
		$args = array(
			'label'			 => array(
				'text' => __( 'Title' ),
			),
			'extra_setting'	 => array(
				'params' => array(
					'group-class'	 => PT_CV_PREFIX . 'field-setting',
					'wrap-class'	 => PT_CV_Html::html_group_class() . ' ' . PT_CV_PREFIX . 'title-setting',
				),
			),
			'params'		 => array(
				array(
					'type'	 => 'group',
					'params' => PT_CV_Settings_Pro::field_title_settings( $prefix ),
				),
			),
			'dependence'	 => array( $prefix2 . 'title', 'yes' ),
		);

		return $args;
	}

	/**
	 * Add custom settings for Taxonomies display
	 *
	 * @param array $args
	 */
	public function filter_settings_taxonomies_display( $args, $prefix ) {
		$prefix_taxonomy = $prefix . 'taxonomy-';

		$args = array(
			'label'			 => array(
				'text' => '',
			),
			'extra_setting'	 => array(
				'params' => array(
					'group-class' => PT_CV_PREFIX . 'field-setting' . ' ' . PT_CV_PREFIX . 'metafield-extra',
				),
			),
			'params'		 => array(
				array(
					'type'	 => 'group',
					'params' => array(
						// Common settings
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
											'label'			 => array(
												'text' => __( 'Common', 'content-views-query-and-display-post-page' ),
											),
											'extra_setting'	 => array(
												'params' => array(
													'wrap-class' => PT_CV_PREFIX . 'full-fields',
												),
											),
											'params'		 => array(
												array(
													'type'		 => 'checkbox',
													'name'		 => $prefix . 'hide-slash',
													'options'	 => PT_CV_Values::yes_no( 'yes', sprintf( __( 'Remove %s between fields', 'content-views-pro' ), '<code>/</code>' ) ),
													'std'		 => '',
												),
											),
										),
										array(
											'label'	 => array(
												'text' => '',
											),
											'params' => array(
												array(
													'type'		 => 'checkbox',
													'name'		 => $prefix_taxonomy . 'use-icons',
													'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show icon before each field', 'content-views-pro' ) ),
													'std'		 => '',
												),
											),
										),
									),
								),
							),
							'dependence'	 => array( 'show-field-' . 'meta-fields', 'yes' ),
						),
						// Date settings
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
															'label'			 => array(
																'text' => __( 'Date' ),
															),
															'extra_setting'	 => array(
																'params' => array(
																	'wrap-class' => PT_CV_PREFIX . 'w200',
																),
															),
															'params'		 => array(
																array(
																	'type'		 => 'select',
																	'name'		 => $prefix . 'date-format-setting',
																	'options'	 => PT_CV_Values_Pro::mtf_date_formats(),
																	'std'		 => '',
																	'desc'		 => __( 'Date format', 'content-views-pro' ),
																),
															),
														),
														array(
															'label'			 => array(
																'text' => '',
															),
															'extra_setting'	 => array(
																'params' => array(
																	'wrap-class' => PT_CV_PREFIX . 'w200',
																),
															),
															'params'		 => array(
																array(
																	'type'	 => 'text',
																	'name'	 => $prefix . 'date-format-custom',
																	'std'	 => get_option( 'date_format' ),
																	'desc'	 => __( 'To define your format, please check', 'content-views-pro' ) . ' <a target="_blank" href="https://codex.wordpress.org/Formatting_Date_and_Time">' . __( 'this document', 'content-views-pro' ) . '</a>',
																),
															),
															'dependence'	 => array( $prefix . 'date-format-setting', 'custom_format' ),
														),
													),
												),
											),
											'dependence'	 => array( $prefix . 'date', 'yes' ),
										),
									),
								),
							),
							'dependence'	 => array( 'show-field-' . 'meta-fields', 'yes' ),
						),
						// Author settings
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
											'label'			 => array(
												'text' => __( 'Author' ),
											),
											'extra_setting'	 => array(
												'params' => array(
													'wrap-class' => PT_CV_PREFIX . 'w200',
												),
											),
											'params'		 => array(
												array(
													'type'		 => 'select',
													'name'		 => $prefix . 'author-settings',
													'options'	 => PT_CV_Values_Pro::meta_field_author_settings(),
													'std'		 => '',
													'desc'		 => sprintf( '<a href="%s" target="_blank">%s</a>', 'https://codex.wordpress.org/How_to_Use_Gravatars_in_WordPress#Using_Gravatars_on_your_Site', __( 'To show avatar, you must enable it', 'content-views-pro' ) ),
												),
											),
											'dependence'	 => array( $prefix . 'author', 'yes' ),
										),
									),
								),
							),
							'dependence'	 => array( 'show-field-' . 'meta-fields', 'yes' ),
						),
						// Taxonomies settings
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
										// Display in better place
										array(
											'label'			 => array(
												'text' => __( 'Taxonomy', 'content-views-query-and-display-post-page' ),
											),
											'extra_setting'	 => array(
												'params' => array(
													'wrap-class' => PT_CV_PREFIX . 'taxonomy-settings',
												),
											),
											'params'		 => array(
												array(
													'type'	 => 'group',
													'params' => array(
														array(
															'label'			 => array(
																'text' => '',
															),
															'extra_setting'	 => array(
																'params' => array(
																	'wrap-class' => implode( ' ', array( PT_CV_PREFIX . 'full-fields', PT_CV_PREFIX . 'mb_10' ) ),
																	'width'		 => 12,
																),
															),
															'params'		 => array(
																array(
																	'type'		 => 'checkbox',
																	'name'		 => $prefix_taxonomy . 'special-place',
																	'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show at top left corner of item', 'content-views-pro' ) ),
																	'std'		 => '',
																	'desc'		 => __( 'It works best when showing thumbnail at top', 'content-views-pro' ),
																),
															),
															'dependence'	 => array( 'show-field-' . 'thumbnail', 'yes' ),
														),
													),
												),
											),
											'dependence'	 => array( $prefix . 'taxonomy', 'yes' ),
										),
										// Terms to display heading
										array(
											'label'		 => array(
												'text' => '',
											),
											'params'	 => array(
												array(
													'type'		 => 'html',
													'content'	 => __( 'Terms to show', 'content-views-pro' ) . ':',
												),
											),
											'dependence' => array( $prefix . 'taxonomy', 'yes' ),
										),
										// Terms to display options
										array(
											'label'			 => array(
												'text' => '',
											),
											'extra_setting'	 => array(
												'params' => array(
													'wrap-class' => PT_CV_PREFIX . 'full-fields',
												),
											),
											'params'		 => array(
												array(
													'type'		 => 'radio',
													'name'		 => $prefix_taxonomy . 'display-what',
													'options'	 => PT_CV_Values_Pro::meta_field_taxonomy_display_what(),
													'std'		 => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::meta_field_taxonomy_display_what() ),
												),
											),
											'dependence'	 => array( $prefix . 'taxonomy', 'yes' ),
										),
										// Select custom taxonomy to display terms
										array(
											'label'		 => array(
												'text' => '',
											),
											'params'	 => array(
												array(
													'type'	 => 'group',
													'params' => array(
														array(
															'label'			 => array(
																'text' => '',
															),
															'extra_setting'	 => array(
																'params' => array(
																	'wrap-class' => PT_CV_PREFIX . 'w200',
																	'width'		 => 12,
																),
															),
															'params'		 => array(
																array(
																	'type'		 => 'select',
																	'name'		 => $prefix_taxonomy . 'display-custom',
																	'options'	 => apply_filters( PT_CV_PREFIX_ . 'settings_sort_single', PT_CV_Values::taxonomy_list(), $prefix_taxonomy . 'display-custom' ),
																	'std'		 => '',
																	'class'		 => 'select2-sortable',
																	'multiple'	 => '1',
																),
															),
															'dependence'	 => array( $prefix_taxonomy . 'display-what', 'custom_taxo' ),
														),
													),
												),
											),
											'dependence' => array( $prefix . 'taxonomy', 'yes' ),
										),
									),
								),
							),
							'dependence'	 => array( 'show-field-' . 'meta-fields', 'yes' ),
						),
					),
				),
			),
		);

		return $args;
	}

	/**
	 * Filter Exceprt settings
	 *
	 * @param array  $args   The setting options of Exceprt
	 * @param string $prefix The prefix string for option name
	 */
	public function filter_excerpt_settings( $args, $prefix ) {

		// Replace checkbox in Free version by select box, with more options
		$args[ 2 ] = array(
			'label'	 => array(
				'text' => '',
			),
			'params' => array(
				array(
					'type'		 => 'select',
					'name'		 => 'field-excerpt-allow_html',
					'options'	 => PT_CV_Values_Pro::excerpt_html_options(),
					'std'		 => '',
					'desc'		 => __( 'If HTML tags existed in excerpt', 'content-views-pro' ),
				),
			),
		);

		$args[] = array(
			'label'	 => array(
				'text' => '',
			),
			'params' => array(
				array(
					'type'		 => 'select',
					'name'		 => $prefix . 'manual',
					'options'	 => PT_CV_Values_Pro::manual_excerpt_settings(),
					'std'		 => 'yes',
					'desc'		 => __( 'If manual excerpt existed', 'content-views-pro' ),
				),
			),
		);

		$args[] = array(
			'label'	 => array(
				'text' => '',
			),
			'params' => array(
				array(
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'hide_dots',
					'options'	 => PT_CV_Values::yes_no( 'yes', sprintf( __( "Do not show %s at the end of excerpt", 'content-views-pro' ), '<code>...</code>' ) ),
					'std'		 => '',
				)
			),
		);

		$args[] = array(
			'label'	 => array(
				'text' => '',
			),
			'params' => array(
				array(
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'remove-tag',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Exclude content of these HTML tags', 'content-views-pro' ) ),
					'std'		 => '',
				),
			),
		);

		$args[] = array(
			'label'		 => array(
				'text' => '',
			),
			'params'	 => array(
				array(
					'type'	 => 'text',
					'name'	 => $prefix . 'tag-to-remove',
					'std'	 => '',
					'desc'	 => sprintf( __( 'Separate multi tags by comma, for example: %s', 'content-views-pro' ), '<code>h1,h2</code>' ),
				),
			),
			'dependence' => array( $prefix . 'remove-tag', 'yes' ),
		);

		$args[] = array(
			'label'	 => array(
				'text' => '',
			),
			'params' => array(
				array(
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'enable_filter',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Enable line breaks, translate, do shortcodes, apply filters in excerpt', 'content-views-pro' ) ),
					'std'		 => '',
					'desc'		 => __( 'Only check this option if excerpt went wrong', 'content-views-pro' ),
				)
			),
		);

		// Read more button/link
		$args[] = array(
			'label'	 => array(
				'text' => __( 'Read More', 'content-views-query-and-display-post-page' ),
			),
			'params' => array(
				array(
					'type'		 => 'checkbox',
					'name'		 => $prefix . 'readmore',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Enable' ) ),
					'std'		 => 'yes',
				),
			),
		);

		$args[] = array(
			'label'			 => array(
				'text' => '',
			),
			'extra_setting'	 => array(
				'params' => array(
					'wrap-class' => PT_CV_PREFIX . 'readmore-settings',
				),
			),
			'params'		 => array(
				array(
					'type'	 => 'group',
					'params' => array(
						// Read more text
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
									'type'	 => 'text',
									'name'	 => $prefix . 'readmore-text',
									'std'	 => ucwords( rtrim( __( 'Read more...' ), '.' ) ),
									'desc'	 => __( 'Read more text', 'content-views-query-and-display-post-page' ),
								),
							),
						),
						// Text link, not button
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
									'type'		 => 'checkbox',
									'name'		 => $prefix . 'readmore-textlink',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show as link instead of button', 'content-views-pro' ) ),
									'std'		 => '',
								),
							),
						),
					),
				),
			),
			'dependence'	 => array( $prefix . 'readmore', 'yes' ),
		);

		return $args;
	}

	/**
	 * Filter Pagination settings
	 *
	 * @param array  $args   The setting options of Exceprt
	 * @param string $prefix The prefix string for option name
	 */
	public function filter_settings_pagination( $args, $prefix ) {

		$args[] = array(
			'label'	 => array(
				'text' => '',
			),
			'params' => array(
				array(
					'type'		 => 'html',
					'content'	 => sprintf( '<p class="cvp-notice cvp-show-on-lf-pagination hidden">%s.</p>', __( 'Live Filter supports only Ajax numbered pagination', 'content-views-pro' ) ),
				),
			),
		);

		$args[] = array(
			'label'		 => array(
				'text' => '',
			),
			'params'	 => array(
				array(
					'type'	 => 'group',
					'params' => array(
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
											'label'			 => array(
												'text' => '',
											),
											'extra_setting'	 => array(
												'params' => array(
													'wrap-class' => PT_CV_PREFIX . 'w200',
													'width'		 => 12,
												),
											),
											'params'		 => array(
												array(
													'type'	 => 'text',
													'name'	 => $prefix . 'loadmore' . '-text',
													'std'	 => __( 'More', 'content-views-pro' ),
													'desc'	 => __( '"Load more" text', 'content-views-pro' ),
												),
											),
											'dependence'	 => array( $prefix . 'style', 'loadmore' ),
										),
									),
								),
							),
							'dependence'	 => array( $prefix . 'type', 'ajax' ),
						),
					),
				),
			),
			'dependence' => array( 'enable-pagination', 'yes' ),
		);

		$args[] = array(
			'label'		 => array(
				'text' => '',
			),
			'params'	 => array(
				array(
					'type'	 => 'group',
					'params' => array(
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
													'content'	 => sprintf( '<p class="cvp-notice" style="margin-top: -20px">%s.</p>', __( 'Normal pagination is not recommended for Shuffle Filter. Please use Ajax pagination for better result', 'content-views-pro' ) ),
												),
											),
											'dependence'	 => array( 'enable-taxonomy-filter', 'yes' ),
										),
									),
								),
							),
							'dependence'	 => array( $prefix . 'type', 'normal' ),
						),
					),
				),
			),
			'dependence' => array( 'enable-pagination', 'yes' ),
		);

		// Alignment
		$args[] = array(
			'label'			 => array(
				'text' => __( 'Alignment' ),
			),
			'extra_setting'	 => array(
				'params' => array(
					'wrap-class' => PT_CV_PREFIX . 'w200',
				),
			),
			'params'		 => array(
				array(
					'type'		 => 'select',
					'name'		 => $prefix . 'alignment',
					'options'	 => PT_CV_Values_Pro::pagination_alignment(),
					'std'		 => 'left',
				),
			),
			'dependence'	 => array( 'enable-pagination', 'yes' ),
		);

		return $args;
	}

	/**
	 * Filter class for Select terms option
	 *
	 * @param array $args
	 */
	public function filter_select_term_class( $args ) {
		$args = 'select2-sortable';

		return $args;
	}

	/**
	 * Filter description of each setting option
	 *
	 * @param string $args  The content of description
	 * @param type   $param The setting array of this option
	 */
	public function filter_options_description( $args, $param ) {

		if ( !empty( $param[ 'popover' ] ) ) {
			$place = !empty( $param[ 'popover_place' ] ) ? $param[ 'popover_place' ] : 'bottom';
			$args .= sprintf( ' <span class="glyphicon glyphicon-question-sign pop-over-trigger" rel="popover" data-content="%s" title="" data-original-title="" data-placement="%s"></span>', $param[ 'popover' ], $place );
		}

		return $args;
	}

	/**
	 * Add option to choose whether or not to exclude sticky post
	 *
	 * @param array $args
	 */
	public function filter_sticky_posts_setting( $args ) {

		// Ignore sticky post
		$args = array(
			'label'			 => array(
				'text' => __( 'Sticky Post' ),
			),
			'extra_setting'	 => array(
				'params' => array(
					'wrap-class' => PT_CV_PREFIX . 'full-fields',
				),
			),
			'params'		 => array(
				array(
					'type'		 => 'select',
					'name'		 => 'sticky-posts',
					'options'	 => PT_CV_Values_Pro::sticky_posts(),
					'std'		 => 'default',
				),
			),
		);

		if ( apply_filters( PT_CV_PREFIX_ . 'sticky_posts_dependence', true ) ) {
			$args[ 'dependence' ] = array( 'content-type', 'post' );
		}

		return $args;
	}

	/**
	 * Append more settings to Field settings
	 *
	 * @param array  $args
	 * @param string $prefix2
	 */
	public function filter_field_settings( $args, $prefix2 ) {
		$prefix = 'custom-fields';

		// Custom fields settings
		$args[] = array(
			'label'			 => array(
				'text' => __( 'Custom Fields' ),
			),
			'extra_setting'	 => array(
				'params' => array(
					'group-class' => PT_CV_PREFIX . 'field-setting',
				),
			),
			'params'		 => array(
				array(
					'type'	 => 'group',
					'params' => array(
						// Select fields
						array(
							'label'	 => array(
								'text' => __( 'Select fields', 'content-views-pro' ),
							),
							'params' => array(
								array(
									'type'		 => 'select',
									'name'		 => $prefix . '-list',
									'options'	 => PT_CV_Values_Pro::custom_fields( false, 'sort', 'show-ctf' ),
									'std'		 => '',
									'class'		 => 'select2-sortable',
									'multiple'	 => '1',
									'desc'		 => sprintf( '<strong>%s</strong>', __( 'A field is selectable only if it was added to at least one post', 'content-views-pro' ) ) . '. ' . __( 'Drag & drop to change display order of fields', 'content-views-pro' ),
								),
							),
						),
						cvp_ctf_multi_plugins() ? array(
							'label'			 => array(
								'text' => __( 'Which plugin', 'content-views-pro' ),
							),
							'extra_setting'	 => array(
								'params' => array(
									'wrap-class' => PT_CV_PREFIX . 'w200',
								),
							),
							'params'		 => array(
								array(
									'type'		 => 'select',
									'name'		 => $prefix . '-ctf-plugin',
									'options'	 => array_merge( array( '' => __( '(Auto-detect)', 'content-views-pro' ) ), cvp_cft_supported_plugins() ),
									'std'		 => '',
									'desc'		 => __( 'Which plugin did you use to create above fields?', 'content-views-pro' ),
								),
							),
							) : null,
						// Hide empty field
						array(
							'label'	 => array(
								'text' => '',
							),
							'params' => array(
								array(
									'type'		 => 'checkbox',
									'name'		 => $prefix . '-hide-empty',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Hide field which has empty value', 'content-views-pro' ) ),
									'std'		 => '',
								),
							),
						),
						// Show field name
						array(
							'label'	 => array(
								'text' => '',
							),
							'params' => array(
								array(
									'type'		 => 'checkbox',
									'name'		 => $prefix . '-show-name',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show field name', 'content-views-pro' ) ),
									'std'		 => '',
								),
							),
						),
						// Display colon after name
						array(
							'label'		 => array(
								'text' => '',
							),
							'params'	 => array(
								array(
									'type'		 => 'checkbox',
									'name'		 => $prefix . '-show-colon',
									'options'	 => PT_CV_Values::yes_no( 'yes', sprintf( __( 'Show %s after field name', 'content-views-pro' ), '<code>:</code>' ) ),
									'std'		 => '',
								),
							),
							'dependence' => array( $prefix . '-show-name', 'yes' ),
						),
						// Enable customize field name
						array(
							'label'		 => array(
								'text' => '',
							),
							'params'	 => array(
								array(
									'type'		 => 'checkbox',
									'name'		 => $prefix . '-enable-custom-name',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Customize field name', 'content-views-pro' ) ),
									'std'		 => '',
								),
							),
							'dependence' => array( $prefix . '-show-name', 'yes' ),
						),
						// Customized names
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
											'label'		 => array(
												'text' => '',
											),
											'params'	 => array(
												array(
													'type'	 => 'text',
													'name'	 => $prefix . '-custom-name-list',
													'std'	 => '',
													'desc'	 => __( 'Separate names by comma. Don\'t type anything between commas for field not needed to change, for example: <code>Custom name 1,,Custom name 3</code>', 'content-views-pro' ),
												),
											),
											'dependence' => array( $prefix . '-enable-custom-name', 'yes' ),
										),
									),
								),
							),
							'dependence'	 => array( $prefix . '-show-name', 'yes' ),
						),
						array(
							'label'	 => array(
								'text' => __( 'Convert Value', 'content-views-pro' ),
							),
							'params' => array(
								array(
									'type'		 => 'checkbox',
									'name'		 => $prefix . '-run-shortcode',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Execute shortcode in field value', 'content-views-pro' ) ),
									'std'		 => '',
								),
							),
						),
						array(
							'label'	 => array(
								'text' => '',
							),
							'params' => array(
								array(
									'type'		 => 'checkbox',
									'name'		 => $prefix . '-enable-oembed',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Fetch the embedded HTML if field value is Youtube, Vimeo... url', 'content-views-pro' ) ),
									'std'		 => '',
									'desc'		 => sprintf( '<a href="%s" target="_blank">%s</a>', 'https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F', __( 'Click here to see all services which can be embedded', 'content-views-pro' ) ),
								),
							),
						),
						// Custom date format
						array(
							'label'	 => array(
								'text' => '',
							),
							'params' => array(
								array(
									'type'		 => 'checkbox',
									'name'		 => $prefix . '-date-custom-format',
									'options'	 => PT_CV_Values::yes_no( 'yes', sprintf( __( 'Convert Date field to a new format', 'content-views-pro' ) ) ),
									'std'		 => '',
								),
							),
						),
						array(
							'label'			 => array(
								'text' => '',
							),
							'extra_setting'	 => array(
								'params' => array(
									'wrap-class' => PT_CV_PREFIX . 'w200',
								),
							),
							'params'		 => array(
								array(
									'type'		 => 'html',
									'content'	 => sprintf( '<p class="cvp-notice">%s.</p>', __( 'To set correct format, please check', 'content-views-pro' ) . ' <a target="_blank" href="https://codex.wordpress.org/Formatting_Date_and_Time">' . __( 'this document', 'content-views-pro' ) . '</a>.<br>' . __( 'If the date value is stored in <a href="https://en.wikipedia.org/wiki/Unix_time" target="_blank">Unix time</a>, only date after 2010-01-01 is converted', 'content-views-pro' ) ),
								),
							),
							'dependence'	 => array( $prefix . '-date-custom-format', 'yes' ),
						),
						array(
							'label'			 => array(
								'text' => '',
							),
							'extra_setting'	 => array(
								'params' => array(
									'wrap-class' => PT_CV_PREFIX . 'w200',
								),
							),
							'params'		 => array(
								array(
									'type'	 => 'text',
									'name'	 => $prefix . '-date-format',
									'std'	 => get_option( 'date_format' ),
									'desc'	 => __( 'Set the new format here', 'content-views-pro' ),
								),
							),
							'dependence'	 => array( $prefix . '-date-custom-format', 'yes' ),
						),
						array(
							'label'			 => array(
								'text' => '',
							),
							'extra_setting'	 => array(
								'params' => array(
									'wrap-class' => PT_CV_PREFIX . 'w200',
								),
							),
							'params'		 => array(
								array(
									'type'	 => 'text',
									'name'	 => $prefix . '-date-format-from',
									'std'	 => '',
									'desc'	 => __( 'Set the current format here, if the converted result is wrong', 'content-views-pro' ),
								),
							),
							'dependence'	 => array( $prefix . '-date-custom-format', 'yes' ),
						),
						// Number of columns
						array(
							'label'	 => array(
								'text' => __( 'Fields per row', 'content-views-pro' ),
							),
							'params' => array(
								array(
									'type'			 => 'number',
									'name'			 => $prefix . '-number-columns',
									'std'			 => '1',
									'append_text'	 => '1 &rarr; 4',
								),
							),
						),
					),
				),
			),
			'dependence'	 => array( $prefix2 . $prefix, 'yes' ),
		);

		return $args;
	}

	/**
	 * Add Filter by Time
	 *
	 * @param type $args
	 */
	public function filter_advanced_settings( $args ) {
		$args[ 'date' ]			 = __( 'Published Date' );
		$args[ 'custom_field' ]	 = __( 'Custom Fields' );

		$membership_plugin = PT_CV_Functions_Pro::has_access_restriction_plugin();
		if ( $membership_plugin ) {
			$args[ 'check_access_restriction' ] = sprintf( __( 'Plugin %s: use access restriction for all posts in this View', 'content-views-pro' ), "<code>$membership_plugin</code>" );
		}

		return $args;
	}

	/**
	 * Add settings panel for Date
	 *
	 * @param array $args
	 */
	public function filter_advanced_settings_panel( $args ) {

		// Filter by Date
		$date = PT_CV_Settings_Pro::filter_date_settings();

		// Filter by Custom Fields
		$custom_field = PT_CV_Settings_Pro::filter_custom_field_settings();

		// Move settings of Date, Custom Fields to 2nd, 3rd position, right after Taxonomy settings
		$args = array_slice( $args, 0, 1, true ) + $date + $custom_field + array_slice( $args, 1, count( $args ) - 1, true );

		return $args;
	}

	/**
	 * Taxonomy custom settings
	 *
	 * @param array $args
	 * @return array
	 */
	public function filter_taxonomies_custom_settings( $args ) {
		$prefix = 'taxonomy-';

		$args = array(
			'label'			 => array(
				'text' => '',
			),
			'extra_setting'	 => array(
				'params' => array(
					'group-class'	 => PT_CV_PREFIX . 'taxonomy-extra',
					'width'			 => 12,
				),
			),
			'params'		 => array(
				array(
					'type'	 => 'group',
					'params' => array(
						// Taxonomy as output or as heading
						array(
							'label'	 => array(
								'text' => __( 'Output modification', 'content-views-pro' ),
							),
							'params' => array(
								array(
									'type'		 => 'select',
									'name'		 => $prefix . 'term-info',
									'options'	 => PT_CV_Values_Pro::term_filter_custom(),
									'std'		 => '',
								),
							),
						),
						array(
							'label'		 => array(
								'text' => __( 'Custom settings', 'content-views-pro' ),
							),
							'params'	 => array(
								array(
									'type'	 => 'group',
									'params' => array(
										// One post per category
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
													'type'		 => 'checkbox',
													'name'		 => $prefix . 'one-per-term',
													'options'	 => PT_CV_Values::yes_no( 'yes', __( 'For each term, show this number of posts', 'content-views-pro' ) ),
													'std'		 => '',
													'class'		 => 'ignore',
												),
											),
										),
										array(
											'label'			 => array(
												'text' => '',
											),
											'extra_setting'	 => array(
												'params' => array(
													'width'		 => 12,
													'wrap-class' => PT_CV_PREFIX . 'w200',
												),
											),
											'params'		 => array(
												array(
													'type'	 => 'number',
													'name'	 => $prefix . 'number-per-term',
													'std'	 => 1,
													'desc'	 => '<span class="cvp-notice">' . __( 'This feature will NOT support sorting by title, date, etc', 'content-views-pro' ) . '</span>',
												),
											),
											'dependence'	 => array( $prefix . 'one-per-term', 'yes' ),
										),
										// Include children categories
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
													'type'		 => 'checkbox',
													'name'		 => $prefix . 'exclude-children',
													'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Exclude children terms', 'content-views-pro' ) ),
													'std'		 => 'yes',
													'desc'		 => __( 'By default, children terms are included automatically (to get posts) when parent term is selected', 'content-views-pro' ),
													'class'		 => 'ignore',
												),
											),
										),
									),
								),
							),
							'dependence' => array( $prefix . 'term-info', 'as_output', '!=' ),
						),
						array(
							'label'		 => array(
								'text' => '',
							),
							'params'	 => array(
								array(
									'type'		 => 'checkbox',
									'name'		 => $prefix . 'child-terms-auto',
									'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Get child terms of current term automatically (when replacing layout)', 'content-views-pro' ) ),
									'std'		 => '',
									'class'		 => 'ignore',
									'desc'		 => '<span class="cvp-notice">' . __( 'This feature will NOT support sorting by title, date, etc', 'content-views-pro' ) . '</span>',
								),
							),
							'dependence' => array( $prefix . 'term-info', 'as_output' ),
						),
					),
				),
			),
			'dependence'	 => array( 'taxonomy[]', array_keys( PT_CV_Values::taxonomy_list() ) ),
		);

		return $args;
	}

	/**
	 * Filter Author settings
	 *
	 * @param array $args
	 */
	public function filter_author_settings( $args ) {
		$prefix = 'author-';

		$args[] = array(
			'label'	 => array(
				'text' => __( 'For logged in user', 'content-views-pro' ),
			),
			'params' => array(
				array(
					'type'		 => 'select',
					'name'		 => $prefix . 'current-user',
					'options'	 => array(
						''			 => __( '(Default)', 'content-views-pro' ),
						'include'	 => __( 'Show his/her posts', 'content-views-query-and-display-post-page' ),
						'exclude'	 => __( 'Hide his/her posts', 'content-views-query-and-display-post-page' ),
					),
					'std'		 => '',
				),
			),
		);

		return $args;
	}

	public function filter_viewtype_setting( $args ) {
		$args[ 'type' ] = 'select';

		return $args;
	}

	public function filter_format_settings( $args ) {
		$args[] = array(
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
					'type'		 => 'checkbox',
					'name'		 => 'lf-alternate',
					'options'	 => PT_CV_Values::yes_no( 'yes', __( "Alternate thumbnail position", 'content-views-pro' ) ),
					'std'		 => '',
				),
			),
			'dependence'	 => array( 'layout-format', '2-col' ),
		);

		return $args;
	}

	public function filter_contenttype_setting( $args ) {
		if ( count( PT_CV_Values::post_types() ) > 5 ) {
			$args[ 'type' ] = 'select';
		}

		return $args;
	}

	/** Remove unnecessary fields before saving
	 * @since 5.7.0
	 */
	public function filter_pre_save_view_data( $data ) {
		// Taxonomy live filter settings
		foreach ( array_keys( PT_CV_Values::taxonomy_list() ) as $taxonomy ) {
			if ( !isset( $data[ PT_CV_PREFIX . $taxonomy . '-' . 'live-filter-enable' ] ) ) {
				foreach ( array( 'live-filter-type', 'live-filter-operator', 'live-filter-heading', 'live-filter-default-text', 'live-filter-order-options' ) as $key ) {
					unset( $data[ PT_CV_PREFIX . $taxonomy . '-' . $key ] );
				}
			}
		}

		// Empty style settings but not color, bgcolor (their empty value is intention)
		foreach ( $data as $key => $value ) {
			if ( substr( $key, 0, 11 ) == PT_CV_PREFIX . 'font-' && strpos( substr( $key, 11, 7 ), 'color' ) === false && $value === '' ) {
				unset( $data[ $key ] );
			}
		}

		return $data;
	}

	/**
	 * Do action before delete/trash View
	 */
	public function action_before_delete_view( $post_id ) {
		global $post_type;

		if ( $post_type == PT_CV_POST_TYPE ) {
			$user_can = PT_CV_Functions_Pro::user_can_manage_view();
			if ( !$user_can ) {
				wp_die( __( 'You do not have sufficient permissions to access this page.', 'content-views-pro' ) );
			}
		}
	}

	/**
	 * Add settings tab header
	 */
	public function action_setting_tabs_header() {
		$tabs = array(
			array(
				'id'	 => 'animation-settings',
				'icon'	 => 'flash',
				'text'	 => __( 'Animation', PT_CV_DOMAIN_PRO ),
			),
			array(
				'id'	 => 'taxonomy-filter',
				'icon'	 => 'random',
				'text'	 => __( 'Shuffle Filter', PT_CV_DOMAIN_PRO ),
			),
			array(
				'id'	 => 'content-ads',
				'icon'	 => 'usd',
				'text'	 => __( 'Advertisement', PT_CV_DOMAIN_PRO ),
			),
			array(
				'id'	 => 'style-settings',
				'icon'	 => 'pencil',
				'text'	 => __( 'Style Settings', PT_CV_DOMAIN_PRO ),
			),
		);

		foreach ( $tabs as $tab ) {
			printf( '<li><a href="#%s" data-toggle="tab"><span class="glyphicon glyphicon-%s"></span>%s</a></li>', PT_CV_PREFIX . $tab[ 'id' ], $tab[ 'icon' ], $tab[ 'text' ] );
		}
	}

	/**
	 * Add settings tab content
	 *
	 * @param array $settings
	 */
	public function action_setting_tabs_content( $settings ) {
		echo self::_tab_style_settings( $settings );
		echo self::_tab_shuffle_filter( $settings );
		echo self::_tab_animation_settings( $settings );
		echo self::_tab_content_ads( $settings );
	}

	/**
	 * Add Report bug buttons
	 */
	public function action_admin_more_buttons() {
		?>
		<a href="http://www.contentviewspro.com/contact/" target="_blank" class="btn btn-default pull-right pt-cv-report-bug" style="margin-right: 10px; background-color: #ebebeb;">Report bug</a>
		<?php
	}

	/**
	 * Setting HTML of "Shuffle Filter" tab
	 *
	 * @return string
	 */
	static function _tab_shuffle_filter( $settings ) {
		ob_start();
		?>
		<div class="tab-pane" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>taxonomy-filter">
			<?php
			$prefix = 'taxonomy-filter';

			$options = array(
				array(
					'label'			 => array(
						'text' => '',
					),
					'extra_setting'	 => array(
						'params' => array(
							'width'		 => 12,
							'wrap-class' => 'has-popover',
						),
					),
					'params'		 => array(
						array(
							'type'			 => 'checkbox',
							'name'			 => 'enable-' . $prefix,
							'options'		 => PT_CV_Values::yes_no( 'yes', __( 'Show terms to shuffle posts with animation', 'content-views-pro' ) ),
							'std'			 => '',
							'popover'		 => sprintf( "<img src='%s'>", plugins_url( 'assets/images/popover/shuffle-filter-howto.png', __FILE__ ) ),
							'popover_place'	 => 'right',
						),
					),
				),
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
							'type'		 => 'html',
							'content'	 => sprintf( '<p class="text-muted" style="margin-top:-12px;">%s.</p>', sprintf( __( 'Support some layouts (%s)', 'content-views-pro' ), __( 'Grid', 'content-views-query-and-display-post-page' ) . ', ' . __( 'Pinterest', 'content-views-pro' ) . ', ' . __( 'Masonry', 'content-views-pro' ) . ', ' . __( 'Collapsible List', 'content-views-query-and-display-post-page' ) ) ),
					),
					),
				),
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
							'type'		 => 'html',
							'content'	 => sprintf( '<p class="cvp-notice">%s.</p>', sprintf( __( 'For a real front-end filter, please use %s Live Filter %s instead', 'content-views-pro' ), '<a href="https://docs.contentviewspro.com/live-filter-introduction/#taxonomy" target="_blank">', '</a>' ) ),
						),
					),
					'dependence'	 => array( 'enable-' . $prefix, 'yes' ),
				),
				array(
					'label'			 => array(
						'text' => __( 'Type' ),
					),
					'extra_setting'	 => array(
						'params' => array(
							'wrap-class' => PT_CV_PREFIX . 'shuffle-filter-type' . ' ' . PT_CV_PREFIX . 'w200',
						),
					),
					'params'		 => array(
						array(
							'type'		 => 'select',
							'name'		 => $prefix . '-type',
							'options'	 => array(
								'btn-group'			 => __( 'Button', 'content-views-pro' ),
								'vertical-dropdown'	 => __( 'Dropdown', 'content-views-pro' ),
								'breadcrumb'		 => __( 'Breadcrumb', 'content-views-pro' ),
								'group_by_taxonomy'	 => __( 'Checkbox (Group by Taxonomy)', 'content-views-pro' ),
							),
							'std'		 => 'btn-group',
						),
					),
					'dependence'	 => array( 'enable-' . $prefix, 'yes' ),
				),
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
									'label'		 => array(
										'text' => __( 'Operator inside taxonomy', 'content-views-pro' ),
									),
									'params'	 => array(
										array(
											'type'	 => 'group',
											'params' => array(
												array(
													'label'			 => array(
														'text' => '',
													),
													'extra_setting'	 => array(
														'params' => array(
															'wrap-class' => PT_CV_PREFIX . 'w200',
															'width'		 => 12,
														),
													),
													'params'		 => array(
														array(
															'type'	 => 'text',
															'name'	 => $prefix . '-operator',
															'std'	 => 'and',
															'desc'	 => sprintf( __( '%s show posts which match ALL selected terms %s show posts which match ANY selected terms', 'content-views-pro' ), '<code>and</code>:', ', <code>or</code>:' ) . '.<br>' . sprintf( __( 'Separate operator for each taxonomy by comma, for example: %s', 'content-views-pro' ), '<code>or, or</code>' ),
														),
													),
												),

											),
										),
									),
									'dependence' => array( $prefix . '-type', 'group_by_taxonomy' ),
								),
							),
						),
					),
					'dependence'	 => array( 'enable-' . $prefix, 'yes' ),
				),
				array(
					'label'			 => array(
						'text' => __( 'Hide filters of', 'content-views-pro' ),
					),
					'extra_setting'	 => array(
						'params' => array(
							'group-class'	 => PT_CV_PREFIX . 'for-multi-taxo',
							'wrap-class'	 => PT_CV_PREFIX . 'w50',
						),
					),
					'params'		 => array(
						array(
							'type'		 => 'select',
							'name'		 => $prefix . '-to-hide',
							'options'	 => PT_CV_Values::taxonomy_list(),
							'std'		 => '',
							'class'		 => 'select2',
							'multiple'	 => '1',
							'desc'		 => __( 'Select taxonomies to hide', 'content-views-pro' ),
						),
					),
					'dependence'	 => array( 'enable-' . $prefix, 'yes' ),
				),
				array(
					'label'			 => array(
						'text' => __( 'Display order', 'content-views-pro' ),
					),
					'extra_setting'	 => array(
						'params' => array(
							'group-class'	 => PT_CV_PREFIX . 'for-multi-taxo',
							'wrap-class'	 => PT_CV_PREFIX . 'w50',
						),
					),
					'params'		 => array(
						array(
							'type'		 => 'select',
							'name'		 => $prefix . '-display-order',
							'options'	 => apply_filters( PT_CV_PREFIX_ . 'settings_sort_single', PT_CV_Values::taxonomy_list(), $prefix . '-display-order' ),
							'std'		 => '',
							'class'		 => 'select2-sortable',
							'multiple'	 => '1',
							'desc'		 => __( 'Select taxonomies in the order you want to display', 'content-views-pro' ),
						),
					),
					'dependence'	 => array( 'enable-' . $prefix, 'yes' ),
				),
				array(
					'label'			 => array(
						'text' => __( 'Heading word', 'content-views-pro' ),
					),
					'extra_setting'	 => array(
						'params' => array(
							'wrap-class' => PT_CV_PREFIX . 'w50',
						),
					),
					'params'		 => array(
						array(
							'type'	 => 'text',
							'name'	 => $prefix . '-heading-word',
							'std'	 => '',
							'desc'	 => sprintf( __( 'Change the "All" word or the taxonomy text. Separate word for each taxonomy by comma, for example: %s', 'content-views-pro' ), '<code>Heading 1, Heading 2</code>' ),
						),
					),
					'dependence'	 => array( 'enable-' . $prefix, 'yes' ),
				),
				array(
					'label'		 => array(
						'text' => __( 'Others', 'content-views-query-and-display-post-page' ),
					),
					'params'	 => array(
						array(
							'type'	 => 'group',
							'params' => array(
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
											'type'		 => 'checkbox',
											'name'		 => 'taxonomy-hide-all',
											'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Hide the "ALL" option', 'content-views-pro' ) ),
											'std'		 => '',
										),
									),
									'dependence'	 => array( $prefix . '-type', array( 'btn-group', 'breadcrumb' ) ),
								),
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
											'type'		 => 'checkbox',
											'name'		 => $prefix . '-trigger-pagination',
											'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Load more posts automatically when click on term', 'content-views-pro' ) ),
											'std'		 => 'yes',
											'desc'		 => __( 'Recommended when using pagination', 'content-views-pro' ),
										),
									),
									'dependence'	 => array( 'enable-pagination', 'yes' ),
								),
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
											'type'		 => 'checkbox',
											'name'		 => $prefix . '-show-all',
											'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Get all remain posts of term on pagination', 'content-views-pro' ) ),
											'std'		 => '',
											'desc'		 => sprintf( __( 'By default, it only shows limit posts on pagination (configured at %s)', 'content-views-pro' ), __( 'Pagination', 'content-views-query-and-display-post-page' ) . ' >> ' . __( 'Items per page', 'content-views-query-and-display-post-page' ) ),
										),
									),
									'dependence'	 => array( 'enable-pagination', 'yes' ),
								),
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
											'type'			 => 'number',
											'name'			 => $prefix . '-space',
											'std'			 => '10',
											'append_text'	 => 'px',
											'desc'			 => __( 'Space between buttons', 'content-views-pro' ),
										),
									),
									'dependence'	 => array( $prefix . '-type', 'btn-group' ),
								),
								array(
									'label'			 => array(
										'text' => '',
									),
									'extra_setting'	 => array(
										'params' => array(
											'width'		 => 12,
											'wrap-class' => PT_CV_PREFIX . 'w200',
										),
									),
									'params'		 => array(
										array(
											'type'		 => 'select',
											'name'		 => $prefix . '-position',
											'options'	 => PT_CV_Values_Pro::taxonomy_filter_position(),
											'std'		 => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::taxonomy_filter_position() ),
											'desc'		 => __( 'Position of the filters', 'content-views-pro' ),
										),
									),
									'dependence'	 => array( $prefix . '-type', 'group_by_taxonomy', '!=' ),
								),
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
											'type'			 => 'number',
											'name'			 => $prefix . '-margin-bottom',
											'std'			 => '20',
											'append_text'	 => 'px',
											'min'			 => '-100',
											'desc'			 => __( 'Bottom margin of the filters', 'content-views-pro' ),
										),
									),
								),
							),
						),
					),
					'dependence' => array( 'enable-' . $prefix, 'yes' ),
				),
			);
			$options = apply_filters( PT_CV_PREFIX_ . 'taxonomy_filter_settings', $options );
			echo PT_Options_Framework::do_settings( $options, $settings );
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Setting HTML of "Style Setttings" tab
	 *
	 * @return string
	 */
	static function _tab_style_settings( $settings ) {
		ob_start();
		?>
		<div class="tab-pane" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>style-settings">
			<?php
			#$prefix = 'style-settings';
			$options = array();

			// Font settings
			$options[] = PT_CV_Settings_Pro::field_font_settings_group( 'show-field-' );

			// View, Item, Button style
			$options[]	 = PT_CV_Settings_Pro::view_style_settings( 'item' );
			$options[]	 = PT_CV_Settings_Pro::view_style_settings( 'view' );
			$options[]	 = PT_CV_Settings_Pro::view_style_settings( 'common' );

			$options = apply_filters( PT_CV_PREFIX_ . 'style_settings', $options );
			echo PT_Options_Framework::do_settings( $options, $settings );
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Setting HTML of "Animation & Effect" tab
	 *
	 * @return string
	 */
	static function _tab_animation_settings( $settings ) {
		ob_start();
		?>
		<div class="tab-pane" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>animation-settings">
			<?php
			#$prefix = 'animation-settings';
			$options = apply_filters( PT_CV_PREFIX_ . 'animation_settings', PT_CV_Settings_Pro::animation_settings() );
			echo PT_Options_Framework::do_settings( $options, $settings );
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Setting HTML of "Advertisement" tab
	 *
	 * @return string
	 */
	static function _tab_content_ads( $settings ) {
		ob_start();
		?>
		<div class="tab-pane" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>content-ads">
			<?php
			$prefix	 = 'ads-';
			$options = apply_filters( PT_CV_PREFIX_ . 'content_ads', PT_CV_Settings_Pro::content_ads_settings( $prefix ) );
			echo PT_Options_Framework::do_settings( $options, $settings );
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	static function sort_by_custom_fields() {
		$prefix			 = 'order-custom-field-';
		$setting_options = apply_filters( PT_CV_PREFIX_ . 'ctf_sort_settings', array(
			// Key
			'key'				 => array(
				'label'	 => array(
					'text' => __( 'Field key', 'content-views-pro' ),
				),
				'params' => array(
					array(
						'type'		 => 'select',
						'name'		 => $prefix . 'key[]',
						'options'	 => PT_CV_Values_Pro::custom_fields( 'default empty' ),
						'class'		 => 'select2 ' . PT_CV_PREFIX . 'ctf-sort-key', // need for admin js
					),
				),
			),
			// Type
			'type'				 => array(
				'label'	 => array(
					'text' => __( 'Value type', 'content-views-pro' ),
				),
				'params' => array(
					array(
						'type'		 => 'select',
						'name'		 => $prefix . 'type[]',
						'options'	 => PT_CV_Values_Pro::custom_field_type(),
					),
				),
			),
			'thousand-commas'	 => array(
				'label'			 => array(
					'text' => '',
				),
				'extra_setting'	 => array(
					'params' => array(
						'group-class' => PT_CV_PREFIX . 'thousand-commas',
					),
				),
				'params'		 => array(
					array(
						'type'		 => 'checkbox',
						'name'		 => $prefix . 'thousand-commas[]',
						'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Select this if you used commas "," as thousand separator in field value', 'content-views-pro' ) ),
						'std'		 => '',
					),
				),
			),
			// Order
			'order'				 => array(
				'label'	 => array(
					'text' => __( 'Order' ),
				),
				'params' => array(
					array(
						'type'		 => 'select', // don't use radio, it will cause issue: click option of this field will affect other fields
						'name'		 => $prefix . 'order[]',
						'options'	 => PT_CV_Values::orders(),
						'std'		 => 'asc',
					),
				),
			),
			'date-format'		 => array(
				'label'			 => array(
					'text' => __( 'MySQL Date format' ),
				),
				'extra_setting'	 => array(
					'params' => array(
						'group-class' => PT_CV_PREFIX . 'date-format',
					),
				),
				'params'		 => array(
					array(
						'type'	 => 'text',
						'name'	 => $prefix . 'date-format[]',
						'std'	 => '',
						'desc'	 => '<span class="cvp-notice">' . __( 'Set MySQL format of this field, if sorting result is incorrect' ) . ' (<a target="_blank" href="http://docs.contentviewspro.com/specify-date-format-for-sorting-custom-field/">read more</a>)' . '</span>',
					),
				),
			),
			), $prefix );

		// Get saved custom fields
		$saved_ctf = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . $prefix, true );

		$number_of_fields = isset( $saved_ctf[ 'key' ] ) && is_array( $saved_ctf[ 'key' ] ) ? count( $saved_ctf[ 'key' ] ) : 0;

		$result = array();

		// Start from -1 to show the template row
		for ( $idx = - 1; $idx < $number_of_fields; $idx ++ ) {
			$options = array();

			foreach ( $setting_options as $key => $settings ) {
				$value		 = isset( $saved_ctf[ $key ][ $idx ] ) ? $saved_ctf[ $key ][ $idx ] : '';
				$options[]	 = PT_Options_Framework::do_settings( array( $settings ), array( PT_CV_PREFIX . $prefix . $key => $value ) );
			}

			$options[]	 = sprintf( '<div><a class="%s"><span class="dashicons dashicons-no"></span> %s</a></div>', PT_CV_PREFIX . 'ctf-sort-delete', __( 'Delete', 'content-views-pro' ) );
			$result[]	 = sprintf( '<div class="%s">%s</div>', esc_attr( $idx == - 1 ? 'hidden ctf-sort-tpl' : 'ctf-sort-item'  ), implode( '', $options ) );
		}

		return sprintf( '<div id="%s">%s</div>', PT_CV_PREFIX . 'ctf-sort-list', implode( '', $result ) );
	}

	static function sort_by_custom_fields_footer() {
		ob_start();
		?>

		<a id="<?php echo PT_CV_PREFIX; ?>ctf-sort-add" class="btn btn-small btn-info"><?php _ex( 'Add New', 'post' ); ?></a>

		<div style='clear: both'></div>
		<?php
		return ob_get_clean();
	}

}

<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class CVP_Replace_Setting {

	private static $instance;
	protected $archives_list;
	protected $views_list;
	protected $field_archive;
	protected $saved_data;

	public static function get_instance() {
		if ( !CVP_Replace_Setting::$instance ) {
			CVP_Replace_Setting::$instance = new CVP_Replace_Setting();
		}

		return CVP_Replace_Setting::$instance;
	}

	public function __construct() {
		$this->field_archive = CVP_REPLAYOUT;

		$this->get_archives();
		$this->get_views_list();
		$this->show_form();
	}

	function get_archives() {
		$taxes	 = array();
		$arr	 = get_taxonomies( array( 'public' => true ), 'objects' );
		foreach ( $arr as $taxonomy ) {
			if ( $taxonomy->name === 'post_format' ) {
				continue;
			}

			$taxes[ $taxonomy->name ] = $taxonomy->label;
		}

		$post_types	 = array();
		$arr		 = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );
		foreach ( $arr as $post_type ) {
			$post_types[ $post_type->name ] = $post_type->labels->singular_name;
		}

		// Ignore attachment for now
		$post_types_builtin = array(
			'post'	 => __( 'Post' ),
			'page'	 => __( 'Page' ),
		);

		$this->archives_list = array(
			-1				 => array( __( 'Common Issues', 'content-views-pro' ), array(
					'show-heading'			 => __( 'Fix the missing page title (title of archives pages disappear when replacing layout)', 'content-views-pro' ),
					'full-width'			 => __( 'Fix the narrow width of layout', 'content-views-pro' ),
					'duplicating-content'	 => __( "Fix the duplicating content (posts layout of theme still appears). In this case, please <code>enable Pagination</code> in the selected Views below.", 'content-views-pro' ),
					'use-standard-pagination' => sprintf('%s <br> <em> %s </em>', __( "Replace custom pagination structure ?_page= by standard pagination structure (/page/ or /?paged=).", 'content-views-pro' ),__( "Uncheck this option if the View shows (unexpectedly) at top of page, above all other things.", 'content-views-pro' )),
				) ),
			0				 => array( __( 'Standard Archives', 'content-views-pro' ), array(
					'home'	 => __( 'Posts page (<em>Blog page</em>)' ),
					'search' => __( 'Search results', 'content-views-pro' ),
					'author' => __( 'Author' ),
					'time'	 => __( 'Date, Month, Year', 'content-views-pro' ),
				) ),
			'tax'			 => array( __( 'Taxonomy Archives', 'content-views-pro' ), $taxes ),
			'post_type'		 => array( __( 'Post Type Archives', 'content-views-pro' ), $post_types ),
			'is_singular'	 => array( __( 'Post Type Single', 'content-views-pro' ), array_merge( $post_types_builtin, $post_types ) ),
		);
	}

	function get_views_list() {
		$this->views_list = cvp_get_view_list();
	}

	function show_form() {
		$this->save_form();
		?>
		<style>
			.wrap h3{margin-top:0;margin-bottom:5px;font-size:1.2em;}
			input[type=checkbox]{opacity:.5}
			input:checked{opacity:1;border:1px solid #1e8cbe;}
			.cvp-rep-intro, .cvp-rep-intro *, .radio label, .checkbox label, select, p {font-size:14px}
			.cvp-rep-intro a{text-decoration: underline; font-weight: 600;}
			.form-control.select2-container, select {margin-top: 10px; margin-bottom: 10px;}
			.radio {margin-left: 10px;}
			hr {border-top: 1px solid #ff5a5f}
		</style>
		<script>
			( function ( $ ) {
				$( document ).ready( function () {
					$( 'select', '.cvp-admin' ).select2();
				} );
			} )( jQuery );
		</script>
		<div class="wrap">
			<h2><?php _e( 'Replace Theme Layout with Content Views Pro', 'content-views-pro' ) ?></h2>
			<br>
			<?php $this->show_notice(); ?>
			<br>
			<div class="pt-wrap cvp-admin">
				<form action="" method="POST">
					<input type="submit" class="btn btn-primary pull-right" value="<?php _e( 'Save' ); ?>" style="margin-top: -40px;">
					<div class="clearfix"></div>
					<?php
					wp_nonce_field( PT_CV_PREFIX_ . 'view_submit', PT_CV_PREFIX_ . 'form_nonce' );

					$sort_options	 = array( '' => __( 'No change', 'content-views-pro' ), 'use_view_order' => __( 'Change order only (use "Sort by" setting of the View)', 'content-views-pro' ), 'use_filter_settings' => __( 'Change completely (use all "Filter Settings" of the View)', 'content-views-pro' ) );
					$comment_options = array( '' => __( 'Hide comments', 'content-views-pro' ), 'show_comment' => __( 'Show comments', 'content-views-pro' ) );

					foreach ( $this->archives_list as $idx => $archive_type ) {
						$heading = $archive_type[ 0 ];
						$pages	 = $archive_type[ 1 ];

						if ( !$pages ) {
							continue;
						}

						if ( $idx !== -1 ) {
							$last_col	 = ($idx !== 'is_singular') ? __( 'The Way To Retrieve Posts', 'content-views-pro' ) : __( 'Other Changes', 'content-views-pro' );
							$heading	 = sprintf( '<div class="clear row"><div class="col-md-3"># %s</div><div class="col-md-4">%s</div><div class="col-md-5">%s</div></div>', $heading, __( "The Layout To Show Posts", 'content-views-pro' ), $last_col );
						} else {
							$heading = "# $heading";
						}

						printf( '%s<h3>%s</h3>', $idx === -1 ? '' : '<br class="clear"><hr class="clear">', $heading );

						// Show notice
						if ( $idx === 'is_singular' ) {
							printf( '<p class="cvp-notice" style="display:block;margin:10px 0;">%s</p>', __( 'Caution: Be careful when select below checkboxes. It will change each and every single post, page, ...', 'content-views-pro' ) );
						}

						foreach ( $pages as $page => $title ) {
							$name		 = ( $idx ? $idx . '-' : '') . $page;
							$field_name	 = esc_attr( $this->field_archive . "[$name]" );
							$page_data	 = !empty( $this->saved_data[ $name ] ) ? $this->saved_data[ $name ] : null;

							echo '<div class="clear">';


							$show_all_columns	 = $idx >= 0;
							$first_col_width	 = $show_all_columns ? 3 : 12;
							# Page name
							printf( '<div class="col-md-' . $first_col_width . '">
									<div class="checkbox">
										<label for="%1$s">
											<input type="checkbox" id="%1$s" name="%1$s" value="%2$s" %3$s>%4$s
										</label>
									</div>
								</div>', $field_name . '[rep_status]', 'enable', !empty( $page_data[ 'rep_status' ] ) ? 'checked' : '', $title );

							if ( $show_all_columns ) {
								# View
								$options		 = array();
								$selected_view	 = !empty( $page_data[ 'selected_view' ] ) ? $page_data[ 'selected_view' ] : '';
								foreach ( $this->views_list as $view_id => $title ) {
									$options[] = sprintf( '<option value="%s" %s>%s</option>', esc_attr( $view_id ), selected( $selected_view, $view_id, false ), esc_html( $title ) );
								}
								printf( '<div class="col-md-4">
									<select name="%s" class="form-control">%s</select>
								</div>', $field_name . '[selected_view]', implode( '', $options ) );

								# Sort by/Comments
								$attribute	 = ($idx !== 'is_singular') ? 'sort_by' : 'show_comment';
								$array		 = ($idx !== 'is_singular') ? $sort_options : $comment_options;

								if ( $page === 'search' ) {
									$array[ 'use_returned_posts' ] = __( 'Use default results and pagination of page (recommend when use another plugin to modify search results)', 'content-views-pro' );
								}

								$options	 = array();
								$selected	 = !empty( $page_data[ $attribute ] ) ? $page_data[ $attribute ] : '';
								foreach ( $array as $val => $_title ) {
									$options[] = sprintf( '<div class="radio"><label><input type="radio" name="%s" value="%s" %s>%s</label></div>', $field_name . "[$attribute]", esc_attr( $val ), checked( $selected, $val, false ), esc_html( $_title ) );
					}
								printf( '<div class="col-md-5">
									%s
								</div>', implode( '', $options ) );
							}

							echo '</div>';
						}
					}
					?>

					<div class="clearfix"></div>
					<hr>
					<input type="submit" class="btn btn-primary pull-right" value="<?php _e( 'Save' ); ?>">
				</form>
			</div>
		</div>
		<?php
	}

	function show_notice() {
		$msg	 = $more	 = array();
		$msg[]	 = __( 'To replace the posts layout of page, please <strong>select checkbox</strong> before the page name, select a View, then save.', 'content-views-pro' );
		$msg[]	 = __( 'You should create different Views for different types of archives.', 'content-views-pro' );
		$msg[]	 = __( '<a target="_blank" href="https://docs.contentviewspro.com/completely-replace-wordpress-layout-by-content-views-pro-layout/">Learn more about this feature.</a>', 'content-views-pro' );

		printf( '<blockquote class="cvp-rep-intro"><p>%s</p></blockquote>', implode( '</p><p>', $msg ) );
	}

	function save_form() {
		if ( !empty( $_POST[ $this->field_archive ] ) ) {
			$this->saved_data = $_POST[ $this->field_archive ];

			update_option( $this->field_archive, $this->saved_data, false );
		} else {
			$this->saved_data = get_option( $this->field_archive );
		}
	}

}

CVP_Replace_Setting::get_instance();

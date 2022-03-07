<?php
/*
 * Show taxonomies as Live Filter
 *
 * @since 5.0
 * @author ptguy
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

add_action( PT_CV_PREFIX_ . 'add_global_variables', 'cvp_livefilter_tax' );
function cvp_livefilter_tax() {
	$GLOBALS[ 'cvp_lf_empty_taxes' ] = array();
    new CVP_LIVE_FILTER_TAX( CVP_LF_PREFIX_TAX );
}

class CVP_LIVE_FILTER_TAX extends CVP_LIVE_FILTER {

	protected $selected_filter_ids = null;

	// Get terms to show as filters
	function get_selected_filters() {
		if ( !$this->is_this_enabled( 'taxonomy' ) ) {
			return;
		}

		// Get selected taxonomy
		$taxonomies_to_get = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy' );
		if ( !is_array( $taxonomies_to_get ) ) {
			return;
		}

		$count_enable = 0;
		foreach ( $taxonomies_to_get as $idx => $tax ) {
            $this->settings[ $tax ]	 = $tax_settings			 = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . $tax . '-' );

			if ( !empty( $tax_settings[ 'live-filter-enable' ] ) ) {
				$count_enable += 1;

				// No terms selected
				if ( !isset( $tax_settings[ 'terms' ] ) ) {
					if ( !empty( $tax_settings[ 'live-filter-require-exist' ] ) ) {
						$GLOBALS[ 'cvp_lf_empty_taxes' ][] = array(
							'taxonomy'	 => $tax,
							'operator'	 => 'EXISTS',
						);
					}
				}
			} else {
                unset( $taxonomies_to_get[ $idx ] );
            }
        }

		if ( !$count_enable ) {
			return;
		}

		// Get selected terms or all terms of selected taxonomies
		$selected_terms_of_taxonomies = (array) PT_CV_Functions_Pro::get_selected_terms( $taxonomies_to_get );
		if ( !$selected_terms_of_taxonomies ) {
			return;
		}

		$sanitized_terms = array();
		foreach ( $selected_terms_of_taxonomies as $taxonomy => $terms ) {
			$tax_terms = array();
			foreach ( $terms as $term ) {
				if ( empty( $term->name ) ) {
					continue;
				}

				$field				 = CVP_LF_TAX_SLUG ? $term->slug : $term->term_taxonomy_id;
				$tax_terms[ $field ] = apply_filters( PT_CV_PREFIX_ . 'lf_tax_text', $term->name, $term );
			}

			if ( $tax_terms ) {
				$sanitized_terms[ $taxonomy ] = $tax_terms;
			}
		}

		$this->selected_filters = apply_filters( PT_CV_PREFIX_ . 'tax_selected_filters', $sanitized_terms );


        // Store IDs of terms
		foreach ( $selected_terms_of_taxonomies as $taxonomy => $terms ) {
			$tax_term_ids = array();
			foreach ( $terms as $term ) {
				$tax_term_ids[ $term->term_id ] = $term->slug;
			}
			$this->selected_filter_ids[ $taxonomy ] = $tax_term_ids;
		}
	}

	/**
	 * Update tax_query before querying posts
	 *
	 * @param array $args
	 * @return array
	 */
	function modify_query( $args ) {

		CVP_LIVE_FILTER_QUERY::query_posts_by_filters( $args, 'tax_query', 'taxonomy', $this->settings );

		// Relation between multi taxonomies
		$this->set_relation( $args[ 'tax_query' ], PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-relation' ) );

		return parent::modify_query( $args );
	}

	// Show taxonomies as filters
	function show_as_filter( $args ) {
		foreach ( $this->selected_filters as $taxonomy => $terms ) {
			if ( empty( $this->settings[ $taxonomy ][ 'live-filter-enable' ] ) ) {
				continue;
			}

			$type	 = $this->settings[ $taxonomy ][ 'live-filter-type' ];
			$others	 = array(
				'label'					 => $this->get_label( $taxonomy, 'live-filter-heading', $taxonomy ),
				'show_count'			 => @$this->settings[ $taxonomy ][ 'live-filter-show-count' ],
				'hide_empty'			 => @$this->settings[ $taxonomy ][ 'live-filter-hide-empty' ],
				'default_text'			 => @$this->settings[ $taxonomy ][ 'live-filter-default-text' ],
				'order_options_by'		 => @$this->settings[ $taxonomy ][ 'live-filter-order-options' ],
				'selected_filter_ids'	 => $this->selected_filter_ids[ $taxonomy ],
			);

			if ( method_exists( 'CVP_LIVE_FILTER_OUTPUT', $type ) ) {
				$ctf = new CVP_LIVE_FILTER_OUTPUT( CVP_LF_PREFIX_TAX, $type, $taxonomy, $terms, $others );
				$args .= $ctf->html();
			}
		}

		return parent::show_as_filter( $args );
	}

}

/** Adjust tax_query in some cases of Live Filter */
add_filter( PT_CV_PREFIX_ . 'query_params', 'cvp_livefilter_tax_inject' );
function cvp_livefilter_tax_inject( $args ) {
	// Only process when live filter enabled
	$enabled_filters = PT_CV_Functions::get_global_variable( 'lf_enabled' );
	if ( !$enabled_filters ) {
		return $args;
	}

	// Replacing layout of taxonomy archive: in the View, show another taxonomy as filter (or show custom field as filter)
	$tax	 = cvp_replace_layout_get_tax( $args );
	$term	 = get_queried_object_id();
	if ( $tax && $term ) {
		if ( !isset( $args[ 'tax_query' ] ) ) {
			$args[ 'tax_query' ] = array();
		}

		$args[ 'tax_query' ][] = array(
			'taxonomy'			 => $tax,
			'field'				 => 'term_id',
			'terms'				 => $term,
			'operator'			 => 'IN',
			'include_children'	 => PT_CV_Functions::setting_value( PT_CV_PREFIX . 'taxonomy-exclude-children' ) ? false : true,
		);
	}

	// Show results which exists one/all (or/and relation) of selected taxes
	if ( !empty( $GLOBALS[ 'cvp_lf_empty_taxes' ] ) ) {
		$args[ 'tax_query' ] = array_merge( $args[ 'tax_query' ], $GLOBALS[ 'cvp_lf_empty_taxes' ] );
	}

	return $args;
}

add_filter( PT_CV_PREFIX_ . 'tax_selected_filters', 'cvp_livefilter_filters_for_replace' );
function cvp_livefilter_filters_for_replace( $args ) {
	$view_args = PT_CV_Functions::get_global_variable( 'args' );

	$tax = cvp_replace_layout_get_tax( $view_args );
	if ( $tax ) {
		if ( !isset( $args[ $tax ] ) ) {
			$args[ $tax ] = array();
		}
	}

	return $args;
}

function cvp_replace_layout_get_tax( $args ) {
	if ( isset( $args[ 'cvp_replace_layout_page' ] ) && substr( $args[ 'cvp_replace_layout_page' ], 0, 4 ) === 'tax-' ) {
		return substr( $args[ 'cvp_replace_layout_page' ], 4 );
	} else {
		return false;
	}
}

/**
 * Show hierarchy output for taxonomies
 * @param type $taxonomy
 * @param type $terms               Slugs of terms
 * @param type $selected_filter_ids IDs of terms
 * @return array
 */
function cvp_livefilter_taxonomy_hierarchy( $taxonomy, $terms, $selected_filter_ids ) {
	// Slugs to IDs
	$term_ids = array();
	foreach ( $terms as $term_slug ) {
		$tid = array_search( $term_slug, $selected_filter_ids );
		if ( $tid ) {
			$term_ids[] = $tid;
		}
	}

	$list_html	 = wp_dropdown_categories( array(
		'include'		 => $term_ids,
		'taxonomy'		 => $taxonomy,
		'hierarchical'	 => 1,
		'echo'			 => 0,
		'hide_empty'	 => 0,
		'orderby'		 => 'include',
		'value_field'	 => 'slug',
		) );
	$matches	 = array();
	preg_match_all( '/(<option[^>]+>)([^<]+)<\/option>/', $list_html, $matches );

	// array (slug => the indent text)
	$new_terms_list = array();
	foreach ( $matches[ 1 ] as $idx => $option ) {
		$mh = array();

		preg_match_all( '/value="([^"]+)"/', $option, $mh );
		$slug					 = isset( $mh[ 1 ][ 0 ] ) ? $mh[ 1 ][ 0 ] : '';
		$new_terms_list[ $slug ] = $matches[ 2 ][ $idx ];

		/** If 'value_field' => 'term_id'
		 *
		 *
		  preg_match_all( '/value="(\d+)"/', $option, $mh );
		  $tid = is_numeric( $mh[ 1 ][ 0 ] ) ? (int) $mh[ 1 ][ 0 ] : 0;
		  if ( $tid && isset( $matches[ 2 ][ $idx ] ) ) {
		  $term_slug						 = $selected_filter_ids[ $tid ];
		  $new_terms_list[ $term_slug ]	 = $matches[ 2 ][ $idx ];
		  }
		 */
	}

	return $new_terms_list;
}

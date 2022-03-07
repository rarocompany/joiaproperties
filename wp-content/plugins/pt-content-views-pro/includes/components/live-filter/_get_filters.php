<?php
/*
 * Get available filter values to show
 *
 * @since 5.0
 * @author ptguy
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

class CVP_LIVE_FILTER_MODEL {

	/**
	 * Get available terms list
	 *
	 * @param type $taxonomy           Taxonomy name
	 * @param array $terms_of_taxonomy All terms ID of this taxonomy
	 * @param array $posts_in          All posts which matched other vals
	 * @return array
	 */
	static function available_terms( $taxonomy, $terms_of_taxonomy, $posts_in = null ) {
		if ( CVP_LF_TAX_SLUG ) {
			return self::_available_terms_by_slug( $taxonomy, $terms_of_taxonomy, $posts_in );
		}

		global $wpdb;

		$table	 = "$wpdb->term_relationships";
		$selects = "$table.term_taxonomy_id AS cvp_filter, COUNT(*) AS counter";
		$extra	 = "GROUP BY cvp_filter ORDER BY counter DESC";

		$terms_of_taxonomy	 = implode( ',', array_map( 'intval', $terms_of_taxonomy ) );
		$where				 = "$table.term_taxonomy_id IN ($terms_of_taxonomy)";

		$join		 = '';
		$table_field = "$table.object_id";
		return self::_query( $table, $posts_in, $where, $table_field, $join, $selects, $extra );
	}

	static function _available_terms_by_slug( $taxonomy, $terms_of_taxonomy, $posts_in ) {
		global $wpdb;

		$from	 = "$wpdb->terms";
		$table	 = "$wpdb->term_relationships";
		$selects = "$from.slug AS cvp_filter, COUNT($table.object_id) AS counter";
		$extra	 = "GROUP BY cvp_filter ORDER BY counter DESC";

		$terms_of_taxonomy	 = implode( "','", array_map( 'cv_esc_sql', $terms_of_taxonomy ) );
		$where				 = "$from.slug IN ('$terms_of_taxonomy')";

		$join = '';

		$taxonomy = cv_esc_sql( $taxonomy );
		$join .= " INNER JOIN $wpdb->term_taxonomy as tt ON ( $from.term_id = tt.term_id AND tt.taxonomy = '$taxonomy' )";
		$join .= " INNER JOIN $table ON ( $table.term_taxonomy_id = tt.term_taxonomy_id )";

		$table_field = "$table.object_id";
		return self::_query( $from, $posts_in, $where, $table_field, $join, $selects, $extra );
	}

	/**
	 * Get available values of a custom field
	 *
	 * @param array $field_name Name of custom field
	 * @param array $posts_in   All posts which matched other vals
	 * @return type
	 */
	static function available_ctf_values( $field_name, $posts_in = null ) {
		global $wpdb;

		$table	 = "$wpdb->postmeta";
		$selects = "$table.meta_value AS cvp_filter, COUNT(*) AS counter";
		$extra	 = "GROUP BY cvp_filter ORDER BY counter DESC";

		$where = $wpdb->prepare( "$table.meta_key = %s", $field_name );

		$join		 = '';
		$table_field = "$table.post_id";
		return self::_query( $table, $posts_in, $where, $table_field, $join, $selects, $extra );
	}

	static function _post_in( $posts_in, &$where, $table_field ) {
		if ( !empty( $posts_in ) ) {
			$posts_in = implode( ',', array_map( 'intval', $posts_in ) );
			$where .=" AND $table_field IN ($posts_in)";
		}
	}

	static function _post_where( $table_field, &$join, &$where ) {
		global $wpdb, $cvp_posts_where;
		if ( $cvp_posts_where ) {
			$join .= " LEFT JOIN $wpdb->posts ON ( $wpdb->posts.ID = $table_field )";
			$where .= " $cvp_posts_where";
		}
	}

	static function _query( $table, $posts_in, $where, $table_field, $join, $selects, $extra ) {
		global $wpdb;

		self::_post_in( $posts_in, $where, $table_field );
		self::_post_where( $table_field, $join, $where );

		$query	 = "SELECT $selects FROM $table $join WHERE ($where) $extra";
		$results = $wpdb->get_results( $query );

		return $results;
	}

}

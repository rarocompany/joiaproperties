<?php
/**
 * @author PT Guy https://www.contentviewspro.com/
 * @since 4.2
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

add_filter( PT_CV_PREFIX_ . 'ctf_intersect', 'cvp_event_plugin_reserve_selected_keys' );
function cvp_event_plugin_reserve_selected_keys( $args ) {
	if ( class_exists( 'Tribe__Events__Main' ) || class_exists( 'EM_Event' ) ) {
		$args = false;
	}

	return $args;
}

add_filter( PT_CV_PREFIX_ . 'ctf_value', 'cvp_event_plugin_get_event_fields', 11, 3 );
function cvp_event_plugin_get_event_fields( $field_value, $key, $object ) {
	/**
	 * The Event Calendar
	 */
	if ( class_exists( 'Tribe__Events__Main' ) ) {
		$func = 0;
		if ( stripos( $key, '_venue' ) !== false ) {
			$func = 'tribe_get';
		} elseif ( stripos( $key, '_organizer' ) !== false ) {
			$func = 'tribe_get_organizer';
		}

		$field	 = str_ireplace( array( 'venue', 'organizer' ), '', $key );
		$field	 = strtolower( sanitize_key( $field ) );

		$ftc = "{$func}{$field}";
		switch ( $ftc ) {
			case 'tribe_get_':
				$ftc = 'tribe_get_venue';
				break;
			case 'tribe_get_organizer_':
				$ftc = 'tribe_get_organizer';
				break;
			case '0_eventcost':
				$ftc = 'tribe_get_formatted_cost';
				break;
			case 'tribe_get_organizer_website':
				$ftc = 'tribe_get_organizer_website_link';
				break;
		}

		if ( $field && function_exists( $ftc ) ) {
			$field_value = @call_user_func( $ftc, $object->ID );
		}
	}

	/**
	 * Events Manager
	 */
	if ( class_exists( 'EM_Event' ) ) {
		if ( stripos( $key, '_location' ) !== false ) {
			if ( !isset( $object->event_manager_object ) ) {
				$object->event_manager_object = new EM_Event( $object->_event_id );
			}
			$em_obj = $object->event_manager_object;
			$em_obj->get_location();

			$em_key		 = str_replace( '_location', 'location', $key );
			$field_value = isset( $em_obj->location->$em_key ) ? $em_obj->location->$em_key : '';
		}
	}

	return $field_value;
}

add_filter( PT_CV_PREFIX_ . 'custom_fields_list', 'cvp_event_plugin_include_fields', 10, 2 );
function cvp_event_plugin_include_fields( $fields, $context ) {
	/**
	 * Events Manager doesn't have location name field, so include it automatically
	 * @since 4.9.0
	 */
	if ( $context === 'show-ctf' && class_exists( 'EM_Event' ) ) {
		$fields[ '_location_name' ] = '_location_name';
	}


	/**
	 * The Event Calendar doesn't have venue name field, so include it automatically
	 * @since 5.4.0
	 */
	if ( $context === 'show-ctf' && class_exists( 'Tribe__Events__Main' ) ) {
		$fields[ '_VenueVenue' ] = '_VenueVenue';
	}

	return $fields;
}

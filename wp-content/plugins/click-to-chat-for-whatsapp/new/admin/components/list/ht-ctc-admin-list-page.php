<?php
/**
 * list .. 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_List_Page' ) ) :

class HT_CTC_Admin_List_Page {

    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function greetings_template() {

        /**
         * keys are like the file names (expect no)
         * Note: dont inclued 'pro' keyword in this list.
         */
        $values = array(
            'no' => '-- No Greetings Dialog --',
            'greetings-1' => 'Greetings-1 - Customizable Design',
            'greetings-2' => 'Greetings-2 - Content Specific'
        );

        $values = apply_filters( 'ht_ctc_fh_greetings_templates', $values );

        return $values;
    }






}

endif; // END class_exists check
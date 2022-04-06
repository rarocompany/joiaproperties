<?php
/**
 * default values: Greetings
 * @since 3.9
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Defaults_Greetings' ) ) :

class HT_CTC_Defaults_Greetings {

    public $greetings = '';
    public $g_1 = '';
    public $g_2 = '';

    public function __construct() {
        $this->defaults();
    }

    function defaults() {
        $this->greetings = $this->greetings();
        $this->g_1 = $this->g_1();
        $this->g_2 = $this->g_2();
    }


    function greetings() {

        $values = array(
            'greetings_template' => 'no',
            'header_content' => '<span style="color: #ffffff;">{site}</span>',
            'main_content' => 'Any questions related to {title}?',
            'bottom_content' => '<p style="text-align: center;"><span style="font-size: 12px;">🟢 we are online | privacy policy</span></p>',
            'call_to_action' => 'Whatsapp Us',
            'g_device' => 'all',
            'g_init' => 'open',
        );

        return $values;
    }

    function g_1() {

        $values = array(
            'header_bg_color' => '#075e54',
            'main_bg_color' => '#ece5dd',
            'message_box_bg_color' => '#dcf8c6',
            'cta_style' => '7_1',
        );

        return $values;
    }

    function g_2() {

        $values = array(
            'bg_color' => '#ffffff',
        );

        return $values;
    }

}

new HT_CTC_Defaults_Greetings();

endif; // END class_exists check
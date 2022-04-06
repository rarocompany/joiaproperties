<?php
/**
 * Start page
 * 
 * Admin 
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_Greetings' ) ) :

class HT_CTC_Admin_Greetings {

    public $values = '';

    public function __construct() {

        add_action('admin_menu', [$this, 'menu'] );



        // only if options.php or this settings page..
        // @admin_perfomance - if this method is not working then we can add at add_settings_section .. 

        // check for options.php, _GET page = click-to-chat-greetings
        $get_url = ( isset($_GET) && isset($_GET['page']) && 'click-to-chat-greetings' == $_GET['page'] ) ? true : false;

        $options_page = false;
        // if request url have options.php .. (or if requesturl is not set.. or empty ) then $options_page = true
        if ( isset($_SERVER['REQUEST_URI']) ) {
            if ( !empty($_SERVER['REQUEST_URI']) ) {
                if ( false !== strpos( $_SERVER['REQUEST_URI'], 'options.php' ) ) {
                    // if options.php page
                    $options_page = true;
                }
            } else {
                $options_page = true;
            }
        } else {
            $options_page = true;
        }

        if ( true == $options_page || true == $get_url ) {
            

            /**
             * 
             * fallback_values: 
             *  created this because 
             *   options_sanitize runs mulitiple times if settings field not exist
             *   https://core.trac.wordpress.org/ticket/21989
             *   due to this htmlentities calling twice at options_sanitize and changes values..  
             *   but untill user save the first settings, fallback values have to display at settings field.. for easy to understand
             *   so here we added option with key fallback_values - as need to load fallback values to display in input fileds as user not saved any values..
             */
            $ht_ctc_greetings_options = get_option('ht_ctc_greetings_options');
            if ( isset($ht_ctc_greetings_options['greetings_template']) || isset($ht_ctc_greetings_options['fallback_values']) ) {
            } else {
                $values = array(
                    'fallback_values' => 'yes',
                );
                add_option('ht_ctc_greetings_options', $values);
            }



            add_action('admin_init', [$this, 'settings'] );
        }

    }


    /**
     * 
     * Settings
     * 
     * 
     * 
     * 
     * class names
     *  pr_: parent element class name
     *  table class names - pr_ht_ctc_greetings_options, 
     *  parent_class
     *      pr_greetings_template (for template select)
     *      ctc_greetings_settings 
     *      greetings-1
     *
     */
    public function settings_values() {

        include_once HT_CTC_PLUGIN_DIR . 'new/admin/db/defaults/class-ht-ctc-defaults-greetings.php';
        $default_greetings = new HT_CTC_Defaults_Greetings();

        $greetings_fallback_values = $default_greetings->greetings;
        $g1_fallback_values = $default_greetings->g_1;
        $g2_fallback_values = $default_greetings->g_2;


        $start_values = [
            'main' => [
                // settings filed - add_settings_field
                'id' => 'ht_ctc_greetings',
                'title' => __( 'Add Greetings Dialog', 'click-to-chat-for-whatsapp'),
                'dbrow' => 'ht_ctc_greetings_options',
                'fallback_values' => $greetings_fallback_values,
                'class' => 'pr_ht_ctc_greetings_options',
                'inputs' => [
                    // with in single add_settings_field add single or multiple things..
                    [
                        'title' => 'Greetings Dialog',
                        'db' => 'greetings_template',
                        'template' => 'select',
                        'description' => "",
                        'list_cb' => 'greetings_template',
                        'parent_class' => 'pr_greetings_template',
                        'description' => "<a href='https://holithemes.com/plugins/click-to-chat/greetings/' target='_blank'>Greetings</a> | <a href='https://holithemes.com/plugins/click-to-chat/greetings-1/' target='_blank'>Greetings-1</a> | <a href='https://holithemes.com/plugins/click-to-chat/greetings-2/' target='_blank'>Greetings-2</a> | <a href='https://holithemes.com/plugins/click-to-chat/greetings-form/' target='_blank'>Greetings Form </a> ",
                    ],
                    [
                        'db' => 'empty',
                        'template' => 'empty',
                    ],
                    'header_content' => [
                        'title' => __( 'Header Content', 'click-to-chat-for-whatsapp'),
                        'db' => 'header_content',
                        'template' => 'editor',
                        'label' => 'Header Content',
                        'description' => '',
                        'link_url' => '',
                        'link_title' => 'more info',
                        'parent_class' => 'pr_header_content ctc_greetings_settings ctc_g_1',
                    ],
                    'main_content' => [
                        'title' => 'Main Content',
                        'db' => 'main_content',
                        'template' => 'editor',
                        'label' => 'Main Content',
                        'description' => '',
                        'parent_class' => 'pr_main_content ctc_greetings_settings ctc_g_1 ctc_g_2',
                    ],
                    'bottom_content' => [
                        'title' => 'Bottom Content',
                        'db' => 'bottom_content',
                        'template' => 'editor',
                        'label' => 'Bottom Content',
                        'description' => '',
                        'parent_style' => "margin-bottom: 20px;",
                        'parent_class' => 'pr_bottom_content ctc_greetings_settings ctc_g_1 ctc_g_2',
                    ],
                    [
                        'title' => 'Call to Action',
                        'db' => 'call_to_action',
                        'template' => 'text',
                        'label' => 'Call to Action',
                        'description' => 'Call to Action (Button/Link Text)',
                        'parent_class' => 'pr_call_to_action ctc_greetings_settings ctc_g_1 ctc_g_2',
                    ],
                ]
            ],
            'greetings_1' => [
                'id' => 'ht_ctc_greetings_1',
                'title' => 'Greetings Dialog - 1',
                'dbrow' => 'ht_ctc_greetings_1',
                'fallback_values' => $g1_fallback_values,
                'class' => 'pr_ht_ctc_greetings_1 ctc_greetings_settings',
                'inputs' => [
                    [
                        'template' => 'collapsible_start',
                        'title' => 'Greetings Dialog - 1 - Customizable',
                    ],
                    [
                        'db' => 'empty',
                        'template' => 'empty',
                    ],
                    [
                        'title' => 'Header - Background Color',
                        'db' => 'header_bg_color',
                        'template' => 'color',
                        'default_color' => '#075e54',
                        'description' => 'Header - Background Color',
                        'parent_class' => 'pr_g1_header_bg_color',
                    ],
                    [
                        'title' => 'Main Content - Background Color',
                        'db' => 'main_bg_color',
                        'template' => 'color',
                        'default_color' => '#ece5dd',
                        'description' => 'Main Content - Background Color',
                        'parent_class' => 'pr_g1_main_bg_color',
                    ],
                    [
                        'title' => 'Message Box - Background Color',
                        'db' => 'message_box_bg_color',
                        'template' => 'color',
                        'default_color' => '#dcf8c6',
                        'description' => 'Main Content as a Message Box with Background Color',
                        'parent_class' => 'pr_g1_message_box_bg_color',
                    ],
                    [
                        'title' => __( 'Call to Action - button type', 'click-to-chat-for-whatsapp'),
                        'db' => 'cta_style',
                        'template' => 'select',
                        'description' => "Call to Action - button type (Color settings at Click to Chat -> Customize)",
                        'list' => [
                            '1' => 'Themes Button (style-1)',
                            '7_1' => 'Button with WhatsApp Icon (style-7 Extend)',
                        ],
                        'parent_class' => 'pr_g1_cta_style',
                    ],
                    [
                        'template' => 'collapsible_end',
                        'description' => "<a href='https://holithemes.com/plugins/click-to-chat/greetings-1/' target='_blank'>Greetings-1</a>",
                    ],
                ]
            ],
            'greetings_2' => [
                'id' => 'ht_ctc_greetings_2',
                'title' => 'Greetings Dialog - 2',
                'dbrow' => 'ht_ctc_greetings_2',
                'fallback_values' => $g2_fallback_values,
                'class' => 'pr_ht_ctc_greetings_2 ctc_greetings_settings',
                'inputs' => [
                    [
                        'template' => 'collapsible_start',
                        'title' => 'Greetings Dialog - 2 - Content Specific',
                    ],
                    [
                        'db' => 'empty',
                        'template' => 'empty',
                    ],
                    [
                        'title' => 'Background Color',
                        'db' => 'bg_color',
                        'template' => 'color',
                        'default_color' => '#ffffff',
                        'description' => 'Greetings Dialog Background Color',
                        'parent_class' => 'pr_g2_bg_color greetings-2',
                    ],
                    [
                        'template' => 'collapsible_end',
                        'description' => "<a href='https://holithemes.com/plugins/click-to-chat/greetings-2/' target='_blank'>Greetings-2</a> <br> Customize 'Call to Action' button from 'Click to Chat' -> Customize - Style-1 ",
                    ],
                ]
            ],
            'greetings_settings' => [
                'id' => 'ht_ctc_greetings_settings',
                'title' => 'Additional Settings',
                'dbrow' => 'ht_ctc_greetings_settings',
                'class' => 'pr_ht_ctc_greetings_settings ctc_greetings_settings',
                'inputs' => [
                    [
                        'db' => 'empty',
                        'template' => 'empty',
                    ],
                    [
                        'title' => __( 'Display', 'click-to-chat-for-whatsapp'),
                        'db' => 'g_device',
                        'template' => 'select',
                        'description' => "Display Greetings Dialog based on device",
                        'list' => [
                            'all' => 'Desktop and Mobile',
                            'desktop' => 'Desktop Only',
                            'mobile' => 'Mobile Only'
                        ],
                        'parent_class' => 'pr_g_device',
                    ],
                    [
                        'title' => __( 'Initial stage', 'click-to-chat-for-whatsapp'),
                        'db' => 'g_init',
                        'template' => 'select',
                        'description' => "Open: Displays by default until user closes the first time <br>(Once user closes the Greetings Dialog on any page, greetings dialog won't display until user clicks to open again) <br> Close: Hidden by default and displays when user clicks <span class='g_user_closed_content'><span>",
                        'list' => [
                            'open' => 'Open',
                            'close' => 'Close',
                        ],
                        'parent_class' => 'pr_g_init',
                    ],
                ]
            ]

        ];

        $start_values = apply_filters( 'ht_ctc_fh_greetings_setting_values', $start_values );

        return $start_values;
    }


    function settings_cb($s) {

        $dbrow = $s['dbrow'];

        $fallback_values = '';
        if (isset($s['fallback_values'])) {
            $fallback_values = $s['fallback_values'];
        }

        $options = get_option($dbrow, $fallback_values);

        if (isset($options['fallback_values'])) {
            $options = $fallback_values;
        }

        $inputs = $s['inputs'];

        foreach ($inputs as $input) {

            if (isset($input['template'])) {

                $db_key = '';
                $db_value = '';
                if (isset($input['db'])) {
                    $db_key = $input['db'];
                    $db_value = ( isset( $options[$db_key]) ) ? esc_attr( $options[$db_key] ) : '';
                }

                $template = $input['template'];

                $components = (isset($input['path'])) ? $input['path'] : HT_CTC_PLUGIN_DIR ."new/admin/components";

                $path = "$components/$template.php";

                include $path;
            }


        }


    }


    public function menu() {

        add_submenu_page(
            'click-to-chat',
            'Greetings',
            'Greetings',
            'manage_options',
            'click-to-chat-greetings',
            array( $this, 'settings_page' )
        );
    }

    public function settings_page() {

        if ( ! current_user_can('manage_options') ) {
            return;
        }

        ?>

        <div class="wrap">

            <?php settings_errors(); ?>

            <!-- full row -->
            <div class="row">

                <div class="col s12 m12 xl7 options">
                    <form action="options.php" method="post" class="">
                        <?php settings_fields( 'ht_ctc_greetings_page_settings_fields' ); ?>
                        <?php do_settings_sections( 'ht_ctc_greetings_page_settings_section' ) ?>
                        <?php submit_button() ?>
                    </form>
                </div>

                <!-- sidebar content -->
                <div class="col s12 m9 l7 xl4 ht-ctc-admin-sidebar ht-ctc-greetings-admin-sidebar sticky-sidebar">

                    <div class="sidebar-content">
                        <div class="col s12 m8 l12 xl12">
                            <div class="row">
                                <ul class="collapsible popout ht_ctc_sidebar_contat">
                                    <li class="active">
                                        <div class="collapsible-header"><?php _e( 'Contact Us', 'click-to-chat-for-whatsapp' ); ?></div>	
                                        <div class="collapsible-body">
                                            <p class="description"><strong>New Feature</strong>: We are planning to improve this feature. <br> Contact us for any suggestions <br><br></p>	
                                            <p class="description"><a href="http://api.whatsapp.com/send?phone=919494429789&text=<?php echo get_bloginfo('url'); ?>%0AHi%20HoliThemes,%0AI%20have%20a%20Suggestion/Feedback:" target="_blank"><?php _e( 'WhatsApp', 'click-to-chat-for-whatsapp' ); ?></a></p>	
                                            <p class="description"><a href="mailto: ctc@holithemes.com"> ctc@holithemes.com</a></p>
                                            <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/support/">Support Page</a></p>	
                                        </div>	
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>

            <!-- new row - After settings page  -->
            <div class="row">
            </div>

        </div>

        <?php

    }


    public function settings() {


        // @uses for register_setting
        $greetings_list = [
            'ht_ctc_greetings_options',
            'ht_ctc_greetings_1',
            'ht_ctc_greetings_2',
            'ht_ctc_greetings_settings',
        ];

        $greetings_list = apply_filters( 'ht_ctc_fh_greetings_register', $greetings_list );

        // register_setting
        foreach ($greetings_list as $g) {

            register_setting( 
                'ht_ctc_greetings_page_settings_fields', 
                $g, 
                [$this, 'options_sanitize']
            );

        }

        // @admin_perfomance - if the above method is not working then add here..

        add_settings_section( 'ht_ctc_greetings_page_settings_sections_add', '', array( $this, 'ht_ctc_greetings_section_cb' ), 'ht_ctc_greetings_page_settings_section' );


        $settings = $this->settings_values();
        foreach ($settings as $s) {
            add_settings_field( 
                $s['id'], 
                $s['title'], 
                array( $this, 'settings_cb' ), 
                'ht_ctc_greetings_page_settings_section', 
                'ht_ctc_greetings_page_settings_sections_add',
                $s
            );
        }




    }


    public function ht_ctc_greetings_section_cb() {
        ?>
        <h1 id="greetings_settings">Greetings Dialog</h1>
        <p class="description"> <b style="color:#42a69a;">New feature: </b> We are planning to expand this feature. please <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/support">contact us</a> for any suggestions</p>
        <br>
        <?php
        do_action('ht_ctc_ah_admin' );

    }





    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function options_sanitize( $input ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'not allowed to modify - please contact admin ' );
        }

        $textarea = [];

        $editor = [
            'header_content',
            'main_content',
            'bottom_content'
        ];

        // formatting api - emoji ..
        include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/ht-ctc-admin-formatting.php';

        $editor = apply_filters( 'ht_ctc_fh_greetings_setting_editor_values', $editor );


        $new_input = array();

        foreach ($input as $key => $value) {
            if( isset( $input[$key] ) ) {

                if ( is_array( $input[$key] ) ) {
                    $new_input[$key] = map_deep( $input[$key], 'sanitize_text_field' );
                } else {

                    if ( in_array( $key, $editor ) ) {
                        // editor
                        if ( !empty( $input[$key]) && '' !== $input[$key] ) {

                            if ( function_exists('ht_ctc_wp_encode_emoji') ) {
                                $input[$key] = ht_ctc_wp_encode_emoji( $input[$key] );
                            }

                            $allowed_html = wp_kses_allowed_html( 'post' );

                            $new_input[$key] = wp_kses($input[$key], $allowed_html);
                            // htmlentities this $new_input[$key] (double security ..)
                            $new_input[$key] = htmlentities( $new_input[$key] );
                            
                            // (may not needed - but extra security)
                            $new_input[$key] = sanitize_textarea_field( $new_input[$key] );

                        } else {
                            // save field even if the value is empty..
                            $new_input[$key] = sanitize_text_field( $input[$key] );
                        }
                    } else if ( in_array( $key, $textarea ) ) {
                        // textarea
                        if ( function_exists('ht_ctc_wp_encode_emoji') ) {
                            $input[$key] = ht_ctc_wp_encode_emoji( $input[$key] );
                        }
                        $new_input[$key] = sanitize_textarea_field( $input[$key] );
                        
                    } else {
                        $new_input[$key] = sanitize_text_field( $input[$key] );
                    }
                }
            }
        }


        $local = [
            'header_content',
            'main_content',
            'bottom_content',
            'call_to_action'
        ];

        $local = apply_filters( 'ht_ctc_fh_greetings_setting_local_values', $local );

        // l10n
        foreach ($input as $key => $value) {
            if ( in_array( $key, $local ) ) {
                do_action( 'wpml_register_single_string', 'Click to Chat for WhatsApp', "greetings_$key", $input[$key] );
            }
        }

        do_action('ht_ctc_ah_admin_after_sanitize' );


        return $new_input;
    }


}


if ( current_user_can( 'manage_options' ) ) {
    new HT_CTC_Admin_Greetings();
}


endif; // END class_exists check
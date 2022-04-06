<?php
/**
 * WhatsApp Chat  - main page .. 
 * 
 * @uses ht-ctc-chat  if: 'no' !== $greetings['greetings_template']
 * 
 * @subpackage chat
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Chat_Greetings' ) ) :

class HT_CTC_Chat_Greetings {

    public function __construct() {
        $this->start();
	}

    public function start() {
        add_action( 'ht_ctc_ah_in_fixed_position', [$this, 'greetings_dialog'] );
    }


    function greetings_dialog() {
        
        $greetings = get_option('ht_ctc_greetings_options' );
        $chat = get_option('ht_ctc_chat_options');

        $ht_ctc_greetings = array();
        $ht_ctc_greetings['greetings_template'] = ( isset( $greetings['greetings_template']) ) ? esc_attr( $greetings['greetings_template'] ) : '';

        // return if template not set..
        if ( '' == $ht_ctc_greetings['greetings_template'] ) {
            return;
        }

        $page_id = get_the_ID();
        // $page_id = get_queried_object_id();

        // $object_id = get_queried_object_id();
        // if (0 == $object_id || '' == $object_id) {
        //     $page_id = get_the_ID();
        // } else {
        //     $page_id = $object_id;
        // }


        $page_url = get_permalink();
        $post_title = esc_html( get_the_title() );

        if ( is_home() || is_front_page() ) {
            // is home page
            $page_url = home_url('/');
            // if home page is a loop then return site name.. (instead of getting the last post title in that loop)
            $post_title = HT_CTC_BLOG_NAME;

            // if home page is a page then return page title.. (if not {site} and {title} will be same )
            if ( is_page() ) {
                $post_title = esc_html( get_the_title() );
            }
        } elseif ( is_singular() ) {
            // is singular
            $page_url = get_permalink();
            $post_title = esc_html( get_the_title() );
        } elseif ( is_archive() ) {

            if ( isset($_SERVER['HTTP_HOST']) && $_SERVER['REQUEST_URI'] ) {
                $protocol = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? 'https' : 'http';
                $page_url = $protocol . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            }

            if ( is_category() ) {
                $post_title = single_cat_title( '', false );
            } elseif ( is_tag() ) {
                $post_title = single_tag_title( '', false );
            } elseif ( is_author() ) {
                $post_title = get_the_author();
            } elseif ( is_post_type_archive() ) {
                $post_title = post_type_archive_title( '', false );
            } elseif ( function_exists( 'is_tax') && function_exists( 'single_term_title') && is_tax() ) {
                $post_title = single_term_title( '', false );
            } else {
                if ( function_exists('get_the_archive_title') ) {
                    $post_title = get_the_archive_title();
                }
            }

        }

        // is shop page
        if ( class_exists( 'WooCommerce' ) && function_exists( 'is_shop') && function_exists( 'wc_get_page_id') && is_shop() ) {
            $page_id = wc_get_page_id( 'shop' );
            $post_title = esc_html( get_the_title( $page_id ) );
        }


        // greetings dialog position based on chat icon/button position
        $g_position_r_l = ( isset( $chat['side_2']) ) ? esc_attr( $chat['side_2'] ) : 'right';

        // page level
        $ht_ctc_pagelevel = get_post_meta( $page_id, 'ht_ctc_pagelevel', true );

        $ht_ctc_greetings['header_content'] = (isset($ht_ctc_pagelevel['header_content'])) ? esc_attr($ht_ctc_pagelevel['header_content']) : '';
        if ( '' == $ht_ctc_greetings['header_content'] ) {
            $ht_ctc_greetings['header_content'] = ( isset( $greetings['header_content']) ) ? esc_attr($greetings['header_content']) : '';
        }
        $ht_ctc_greetings['header_content'] = apply_filters( 'wpml_translate_single_string', $ht_ctc_greetings['header_content'], 'Click to Chat for WhatsApp', 'greetings_header_content' );

        $ht_ctc_greetings['main_content'] = (isset($ht_ctc_pagelevel['main_content'])) ? esc_attr($ht_ctc_pagelevel['main_content']) : '';
        if ( '' == $ht_ctc_greetings['main_content'] ) {
            $ht_ctc_greetings['main_content'] = ( isset( $greetings['main_content']) ) ? esc_attr($greetings['main_content']) : '';
        }
        $ht_ctc_greetings['main_content'] = apply_filters( 'wpml_translate_single_string', $ht_ctc_greetings['main_content'], 'Click to Chat for WhatsApp', 'greetings_main_content' );
        
        $ht_ctc_greetings['bottom_content'] = (isset($ht_ctc_pagelevel['bottom_content'])) ? esc_attr($ht_ctc_pagelevel['bottom_content']) : '';
        if ( '' == $ht_ctc_greetings['bottom_content'] ) {
            $ht_ctc_greetings['bottom_content'] = ( isset( $greetings['bottom_content']) ) ? esc_attr($greetings['bottom_content']) : '';
        }
        $ht_ctc_greetings['bottom_content'] = apply_filters( 'wpml_translate_single_string', $ht_ctc_greetings['bottom_content'], 'Click to Chat for WhatsApp', 'greetings_bottom_content' );

        $allowed_html = wp_kses_allowed_html( 'post' );

        // $allowed_html['iframe'] = array(
        //     'src'             => true,
        //     'height'          => true,
        //     'width'           => true,
        //     'frameborder'     => true,
        //     'allowfullscreen' => true,
        //     'title' => true,
        //     'allow' => true,
        //     'autoplay' => true,
        //     'clipboard-write' => true,
        //     'encrypted-media' => true,
        //     'gyroscope' => true,
        //     'picture-in-picture' => true,
        // );
        
        if ( '' !== $ht_ctc_greetings['header_content'] ) {
            $ht_ctc_greetings['header_content'] = html_entity_decode(wp_kses($ht_ctc_greetings['header_content'], $allowed_html) );
            $ht_ctc_greetings['header_content'] = str_replace( array('{url}', '{title}', '{site}' ),  array( $page_url, $post_title, HT_CTC_BLOG_NAME ), $ht_ctc_greetings['header_content'] );
        }
        if ( '' !== $ht_ctc_greetings['main_content'] ) {
            $ht_ctc_greetings['main_content'] = html_entity_decode(wp_kses($ht_ctc_greetings['main_content'], $allowed_html) );
            $ht_ctc_greetings['main_content'] = str_replace( array('{url}', '{title}', '{site}' ),  array( $page_url, $post_title, HT_CTC_BLOG_NAME ), $ht_ctc_greetings['main_content'] );
        }
        if ( '' !== $ht_ctc_greetings['bottom_content'] ) {
            $ht_ctc_greetings['bottom_content'] = html_entity_decode(wp_kses($ht_ctc_greetings['bottom_content'], $allowed_html) );
            $ht_ctc_greetings['bottom_content'] = str_replace( array('{url}', '{title}', '{site}' ),  array( $page_url, $post_title, HT_CTC_BLOG_NAME ), $ht_ctc_greetings['bottom_content'] );
        }


        $ht_ctc_greetings['call_to_action'] = ( isset( $greetings['call_to_action']) ) ? esc_attr( $greetings['call_to_action'] ) : '';
        if ('' == $ht_ctc_greetings['call_to_action']) {
            $ht_ctc_greetings['call_to_action'] = 'WhatsApp';
        }

        $ht_ctc_greetings['path'] = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/greetings/' . $ht_ctc_greetings['greetings_template']. '.php';

        // filter hook to update values... 
        $ht_ctc_greetings = apply_filters( 'ht_ctc_fh_greetings', $ht_ctc_greetings );

        if ( is_file( $ht_ctc_greetings['path'] ) ) {
            
            // $script = 'dev';
            $script = '';
            if('dev' == $script) {
                ?>
                <style>
                .ctc_greetings_close_btn {
                    display: none;
                }
                .ht_ctc_chat_greetings_box:hover .ctc_greetings_close_btn {
                    display: block;
                }
                .ht_ctc_chat_greetings_box *:not(ul):not(ol) {
                    padding: 0px; margin: 0px;
                }
                .ht_ctc_chat_greetings_box ul, .ht_ctc_chat_greetings_box ol {
                    margin-top: 0px; margin-bottom: 0px;
                }
                @media only screen and (max-width: 1200px) {
                    .ctc_greetings_close_btn {
                        display: block;
                    }
                }
                </style>
                <?php
            } else {
                ?>
                <style>.ctc_greetings_close_btn{display:none}.ht_ctc_chat_greetings_box:hover .ctc_greetings_close_btn{display:block}.ht_ctc_chat_greetings_box :not(ul):not(ol){padding:0;margin:0}.ht_ctc_chat_greetings_box ul,.ht_ctc_chat_greetings_box ol{margin-top:0;margin-bottom:0}@media only screen and (max-width: 1200px){.ctc_greetings_close_btn{display:block}}</style>
                <?php
            }
            ?>
            
            <div style="position: relative; bottom: 18px; cursor: auto;" class="ht_ctc_greetings">

                <div class="ht_ctc_chat_greetings_box" style="display: none; position: absolute; bottom: 0px; <?= $g_position_r_l ?>: 0px; min-width: 300px; max-width: 400px; ">

                    <span style=" cursor:pointer; float:right;" class="ctc_greetings_close_btn">
                        <svg style="color:#ffffff; background-color:lightgray; border-radius:50%;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </span>
                    <br>
                    <div class="ht_ctc_chat_greetings_box_layout" style="max-height: 67vh; overflow-y:auto; background-color: #ffffff; box-shadow: 1px 1px 3px 1px rgba(0,0,0,.14); border-radius:8px;clear:both;">
                        <div class="ctc_greetings_template">
                            <?php include $ht_ctc_greetings['path']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

    }


}


new HT_CTC_Chat_Greetings();

endif; // END class_exists check
<?php
/**
 * Greetings - template - 1
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$g1_options = get_option( 'ht_ctc_greetings_1' );
$g1_options = apply_filters( 'ht_ctc_fh_g1_options', $g1_options );
$greetings = get_option('ht_ctc_greetings_options');


// $ht_ctc_greetings['main_content'] = apply_filters( 'the_content', $ht_ctc_greetings['main_content'] );
$ht_ctc_greetings['main_content'] = do_shortcode( $ht_ctc_greetings['main_content'] );

// css
$header_css = 'padding: 12px 25px 12px 25px; line-height:1.4;';
$main_css = '';
$message_box_css = '';
$send_css = 'text-align:center; padding: 11px 25px 9px 25px; cursor:pointer;';
$bottom_css = 'padding: 2px 25px 2px 25px; text-align:center; font-size:12px;';

$header_bg_color = ( isset($g1_options['header_bg_color']) ) ? esc_attr( $g1_options['header_bg_color'] ) : '';
$main_bg_color = ( isset($g1_options['main_bg_color']) ) ? esc_attr( $g1_options['main_bg_color'] ) : '';
$message_box_bg_color = ( isset($g1_options['message_box_bg_color']) ) ? esc_attr( $g1_options['message_box_bg_color'] ) : '';

if ('' !== $header_bg_color) {
    $header_css .= "background-color:$header_bg_color;";
}

if ('' !== $main_bg_color) {
    $main_css .= "background-color:$main_bg_color;";
}

$rtl_page = "";
if ( function_exists('is_rtl') && is_rtl() ) {
    $rtl_page = "yes";
}

if ('' !== $message_box_bg_color) {
    $message_box_css .= "padding:5px;background-color:$message_box_bg_color;";
    if ('yes' == $rtl_page) {
        $main_css .= 'padding: 18px 18px 40px 24px;';
    } else {
        $main_css .= 'padding: 18px 24px 40px 18px;';
    }
} else {
    $main_css .= 'padding: 18px 19px 30px 19px;';
}

// call to action - style
$cta_style = ( isset($g1_options['cta_style']) ) ? esc_attr( $g1_options['cta_style'] ) : '7_1';
$g_cta_path = plugin_dir_path( HT_CTC_PLUGIN_FILE ) . 'new/inc/greetings/greetings_styles/g-cta-' . $cta_style. '.php';

$g_header_image = '';

?>
<style>
<?php
if ('' !== $message_box_bg_color) {
if ('yes' == $rtl_page) {
?>
.ctc_g_message_box {
    position: relative;
    border-radius: 7px 0px 7px 7px;
    /* max-width: 70%; */
}
.ctc_g_message_box:before {
  content: "";
  position: absolute;
  left: 100%;
  top: 0px;
  height: 20px;
  width: 15px;
  background-color: <?= $message_box_bg_color ?>;
  clip-path: polygon(0% 0%, 0% 50%, 100% 0%);
}
<?php
} else {
?>
.ctc_g_message_box {
    position: relative;
    border-radius: 0px 7px 7px 7px;
    /* max-width: 70%; */
}
.ctc_g_message_box:before {
  content: "";
  position: absolute;
  right: 100%;
  top: 0px;
  height: 20px;
  width: 15px;
  background-color: <?= $message_box_bg_color ?>;
  clip-path: polygon(0% 0%, 100% 0%, 100% 50%);
}
<?php
}
}
?>
</style>
<?php

if ( '' !== $ht_ctc_greetings['header_content'] ) {
    if ('' !== $g_header_image) {
        // if header image is added
        ?>
        <div class="ctc_g_heading" style="<?= $header_css ?>">
            <div style="display: flex; align-items: center;">
                <img style="border-radius:50%; margin-right:9px;" src="" alt="">
                <div>
                    <?= wpautop($ht_ctc_greetings['header_content']) ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        // if header image is not added
        ?>
        <div class="ctc_g_heading" style="<?= $header_css ?>">
            <?= wpautop($ht_ctc_greetings['header_content']) ?>
        </div>
        <?php
    }
}
?>

<div class="ctc_g_content" style="<?= $main_css ?>">
    <div class="ctc_g_message_box" style="<?= $message_box_css ?>"><?= wpautop( $ht_ctc_greetings['main_content'] ) ?></div>
</div>

<div class="ctc_g_sentbutton" style="<?= $send_css ?>">
    <div class="ht_ctc_chat_greetings_box_link ctc-analytics">
    <?php
    if ( is_file( $g_cta_path ) ) {
        include $g_cta_path;
    }
    ?>
    </div>
</div>

<?php
if ( '' !== $ht_ctc_greetings['bottom_content'] ) {
?>
<div class="ctc_g_bottom" style="<?= $bottom_css ?>">
    <?= wpautop( $ht_ctc_greetings['bottom_content'] ) ?>
</div>
<?php
}
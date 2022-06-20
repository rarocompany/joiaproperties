<?php
/**
 * Greetings call to action - style - 1
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$opt_in = 'Privacy Policy';

if (isset( $ht_ctc_greetings) && isset( $ht_ctc_greetings['opt_in'])) {
  $opt_in = $ht_ctc_greetings['opt_in'];
}

?>
<div class="ctc_opt_in" style="display:none;">
    <div class="ctc_opt" style="display:inline-flex;justify-content:center;align-items:center;padding:0 4px;">
        <input type="checkbox" name="" id="ctc_opt" style="margin: 0 5px;">
        <label for="ctc_opt"><?= $opt_in ?></label>
    </div>
</div>
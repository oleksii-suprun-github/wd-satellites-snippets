<?php

// Async Google Tag Manager
if( get_option('wdss_gtm_id', '') !== '' ) {
  add_action('wp_enqueue_scripts', 'wdss_gtm_enqueue');
  function wdss_gtm_enqueue() {
    wp_enqueue_script('gtm-lazy', plugin_dir_url( __FILE__ ) . '../inc/gtm-lazy/index.js', array(), '1.0', true);
    $wdss_localize_gtm_script = [
      'id' => get_option('wdss_gtm_id'),
    ];
    wp_localize_script('gtm-lazy', 'wdss_gtm', $wdss_localize_gtm_script);
  }
}

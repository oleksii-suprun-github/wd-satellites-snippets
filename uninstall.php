<?php 
  if( ! defined('WP_UNINSTALL_PLUGIN') && ! defined('ABSPATH') ) exit;


  global $wpdb;

  flush_rewrite_rules();

  $sql = "DELETE FROM `wp_options` WHERE `option_name` LIKE ('%\wdss\_%')"; 
  $wpdb->query($sql);


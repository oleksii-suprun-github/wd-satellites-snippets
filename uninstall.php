<?php 
  if( ! defined('WP_UNINSTALL_PLUGIN') && ! defined('ABSPATH') ) exit;


  global $wpdb;
  
  $sql = "DELETE FROM `wp_options` WHERE `option_name` LIKE ('%\wdss\_%')"; 
  $wpdb->query($sql);


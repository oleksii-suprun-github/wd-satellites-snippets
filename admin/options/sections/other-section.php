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


// Remove posts from specific categories from Yoast Posts Sitemap
if( get_option('wdss_yoast_posts_exclude', '') !== '' ) {
  add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'wdss_remove_individual_category_posts_from_sitemap');
  function wdss_remove_individual_category_posts_from_sitemap() {
      $args = array(
        'posts_per_page' => -1, 
        'cat' => strval( get_option('wdss_yoast_posts_exclude') ), 
        'post_type' => 'post'
      );
      $the_query = new WP_Query( $args );
      if ( $the_query->have_posts() ) {
        $exclude_array = array(); 
        while ( $the_query->have_posts() ) {
          $the_query->the_post();
          $this_testimonial_array = get_the_ID(); 
          $exclude_array[] = $this_testimonial_array; 
        }
      }
      wp_reset_postdata();
      return $exclude_array;
  }
}


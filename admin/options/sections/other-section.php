<?php


// Lazt DMCA Script
if( get_option('wdss_lazy_dmca', '0') ) {
  add_action('wp_enqueue_scripts', 'wdss_dmca_enqueue');
  function wdss_dmca_enqueue() {
    wp_enqueue_script('dmca-lazy', plugin_dir_url( __FILE__ ) . '../inc/dmca-lazy/index.js', array(), WD_SATELLITES_SNIPPETS_VERSION, true);
  }
}

// Async Google Tag Manager
if( get_option('wdss_gtm_id', '') !== '' ) {
  add_action('wp_enqueue_scripts', 'wdss_gtm_enqueue');
  function wdss_gtm_enqueue() {
    wp_enqueue_script('gtm-lazy', plugin_dir_url( __FILE__ ) . '../inc/gtm-lazy/index.js', array(), WD_SATELLITES_SNIPPETS_VERSION, true);
    $wdss_localize_gtm_script = [
      'id' => get_option('wdss_gtm_id'),
    ];
    wp_localize_script('gtm-lazy', 'wdss_gtm', $wdss_localize_gtm_script);
  }
}

// Lazy Google Recaptcha
if( get_option('wdss_recaptcha_id', '') !== '' ) {
  add_action('wp_enqueue_scripts', 'wdss_recaptcha_enqueue');
  function wdss_recaptcha_enqueue() {
    if( is_single() ) {
      wp_enqueue_script('recaptcha-lazy', plugin_dir_url( __FILE__ ) . '../inc/recaptcha-lazy/index.js', array(), WD_SATELLITES_SNIPPETS_VERSION, true);
    }
  }

  add_filter( 'comment_form_default_fields', 'wdss_form_defaults', 99, 1 );
  function wdss_form_defaults( $fields ) {
    $key = get_option('wdss_recaptcha_id', '');
    $fields['g-recaptcha'] = "<div class='g-recaptcha' data-sitekey='$key'></div>";
    return $fields;
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


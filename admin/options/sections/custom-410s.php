<?php
// Custom 410 Category Rules
function wdss_custom_410() {
  $requestUri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $requestUri = urldecode($requestUri);
  $e410s_rules_list = get_option('wdss_410s_dictionary');

  foreach($e410s_rules_list as $rule) {
    $url = 'https://'.$_SERVER['HTTP_HOST'].$rule;

    if($requestUri ==  $url) {
      global $post, $wp_query;
      $wp_query->set_404();
      status_header(404);
      header("HTTP/1.0 410 Gone");
      include(get_query_template('404'));
      exit;   
    }
  }
}
add_action( 'wp', 'wdss_custom_410' );

<?php

function wdss_manual_validation_fix() {
  global $post;

  $filtered_content_stage1 = regex_post_content_filters($post->post_content);
  $filtered_content_stage2 = set_image_dimension($filtered_content_stage1);
  $filtered_content_stage3 = alt_singlepage_autocomplete($post->ID, $filtered_content_stage2);

  $args = array(
    'ID' => $post->ID,
    'post_content' => $filtered_content_stage3
  );
  wp_update_post($args);

}


add_action('publish_post', 'wdss_manual_validation_fix');
add_action('draft_to_publish', 'wdss_manual_validation_fix');
add_action('new_to_publish', 'wdss_manual_validation_fix');
add_action('pending_to_publish', 'wdss_manual_validation_fix');
add_action('future_to_publish', 'wdss_manual_validation_fix');
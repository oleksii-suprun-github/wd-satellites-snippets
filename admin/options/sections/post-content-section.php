<?php

function on_save_post_validation_fix($post_id) {
  remove_action('save_post', 'on_save_post_validation_fix', 25 );

  $filtered_content_stage1 = regex_post_content_filters(get_post_field('post_content', $post_id));
  $filtered_content_stage2 = set_image_dimension($filtered_content_stage1);
  $filtered_content_stage3 = alt_singlepage_autocomplete($post_id, $filtered_content_stage2);

  $args = array(
    'ID' => $post_id,
    'post_content' => $filtered_content_stage3,
    'meta_input' => [
      'wdss_validation_fixed' => true
    ]
  );
  wp_update_post($args);


  add_action('save_post', 'on_save_post_validation_fix', 25 );

}

add_action('save_post', 'on_save_post_validation_fix', 25);
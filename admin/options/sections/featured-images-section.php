<?php 

    // Random Featured Image from the list
    if( get_option('wdss_auto_featured_image','0') ) {
      function wdss_random_featured_image() {

        global $post;
        require_once ABSPATH . 'wp-admin/includes/file.php';
    
        if (!has_post_thumbnail($post->ID)) {
    
            $attached_image = get_children( "post_parent=$post->ID&amp;post_type=attachment&amp;post_mime_type=image&amp;numberposts=1" );
    
            if ($attached_image) {
                foreach ($attached_image as $attachment_id => $attachment) {
                    set_post_thumbnail($post->ID, $attachment_id);
                }
            }
            else {
              if( get_option('wdss_featured_images_list', '' )) {
                $images_ids_arr = explode(',', get_option('wdss_featured_images_list'));
                $rand_index = array_rand($images_ids_arr);
                $image_id = intval($images_ids_arr[$rand_index]);
                set_post_thumbnail($post->ID, $image_id);
              }
              return;
            }
        }
      }
      add_action('the_post', 'wdss_random_featured_image');
      
      add_action('publish_post', 'wdss_random_featured_image');
      add_action('save_post', 'wdss_random_featured_image');
      add_action('draft_to_publish', 'wdss_random_featured_image');
      add_action('new_to_publish', 'wdss_random_featured_image');
      add_action('pending_to_publish', 'wdss_random_featured_image');
      add_action('future_to_publish', 'wdss_random_featured_image');
    }


    if( get_option('wdss_featured_images_add_column', '0') ) {

      function wdss_add_images_size() {
        add_image_size( 'featured-column', 50, 50, true );
      }
      add_action('wp_loaded', 'wdss_add_images_size');


      add_action('wp_loaded', 'wdss_featured_image_column');
      function wdss_featured_image_column() {
  
        // Creates a new column
        add_filter('manage_post_posts_columns', 'add_image_column', 4);
        function add_image_column( $columns ){
          // unset($columns['author']); // deletes Author column
  
          $out = array();
          foreach($columns as $col=>$name){
            if(++$i==2) // where we want to place our column
              $out['featured'] = 'Featured';
            $out[$col] = $name;
          }
  
          return $out;
        }

        // Fill in our column with data -  wp-admin/includes/class-wp-posts-list-table.php
        add_filter('manage_post_posts_custom_column', 'fill_images_column', 5, 2);
        function fill_images_column( $colname, $post_id ){
          if( $colname === 'featured' ) {
            the_post_thumbnail('featured-column');
          }
        }
  
        // CSS Column width styling
        add_action('admin_head', 'add_images_column_css');
        function add_images_column_css(){
          if( get_current_screen()->base == 'edit')
            echo '<style type="text/css">.column-featured{width:5%;}</style>';
        }
      }
    }
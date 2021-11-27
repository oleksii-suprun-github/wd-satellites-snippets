<?php
		// Checks image dimensions
		function check_image_size($url) {
			list($width, $height) = getimagesize($url);

			if(isset($width) && isset($height) && $width > 100 ) {
				return true;
			}
			return false;
		}


    function attach_first_post_image( $post_id, $file, $desc = 'Image' ){
      global $debug; // by default: true
    
      if( ! function_exists('media_handle_sideload') ) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
      }
    
      // Download image by given url
      $tmp = download_url( $file );
    
      // Prepares data to be attach in WP Media
      $file_array = [
        'name'     => basename( $file ),
        'tmp_name' => $tmp
      ];
    
      // If error then removes tmp file
      if ( is_wp_error( $tmp ) ) {
        $file_array['tmp_name'] = '';
        if( $debug ) echo 'Error: there`s no tmp file! <br />';
      }
    
      // If Debug mode is enabled then shows details
      if( $debug ) {
        echo 'File array: <br />';
        var_dump( $file_array );
        echo '<br /> Post id: ' . $post_id . '<br />';
      }
    
      // Sets data as new media file in WP Media
      $id = media_handle_sideload( $file_array, $post_id, $desc );
    
      // Checks if there`s any errors
      if ( is_wp_error( $id ) ) {
        var_dump( $id->get_error_messages() );
      } else {
        update_post_meta( $post_id, '_thumbnail_id', $id );
      }
    
      // Removes tmp file
      @unlink( $tmp );
    }



    // URL Status Code Checker
    function check_url_status($url, $condition = null) {

      $meeting_conditions = true;

      if($condition) {
        switch ($condition) {
          case 'local-only':
            
            if(!preg_match('/'. $_SERVER['SERVER_NAME'] . '/', $url)) {
              $meeting_conditions = false;
            }
            break;
          
          default:
            break;
        }
      }

      // Checks the existence of URL
      if($meeting_conditions) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($httpcode == 200) {
          return true;
        }
        return false;
      }
      else {
        return false;
      }
    }

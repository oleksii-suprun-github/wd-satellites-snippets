<?php

		// Checks image dimensions
		function check_image_size($url) {
			list($width, $height) = getimagesize($url);
      
			if(isset($width) && isset($height) && $width > 100 ) {
				return true;
			}
			return false;
		}


    // URL Status Code Checker
    function check_url_status($url) {

      // Use get_headers() function
      $headers = @get_headers($url);

      // Checks the existence of URL
      if($headers && strpos( $headers[0], '200')) {
        return true;
      }
      else {
        return false;
      }
    }
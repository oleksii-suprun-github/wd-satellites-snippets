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
    function check_url_status($url, $condition = null) {

      $meeting_conditions = true;

      if($condition) {
        switch ($condition) {
          case 'local-only':
            
            if(!preg_match('/'. $_SERVER['SERVER_NAME'] . '/')) {
              $meeting_conditions = false;
            }
            break;
          
          default:
            break;
        }
      }

      // Checks the existence of URL
      if($meeting_conditions && @fopen($url,"r")) {
        return true;
      }
      else {
        return false;
      }
    }

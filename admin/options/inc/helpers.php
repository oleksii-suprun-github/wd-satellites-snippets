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

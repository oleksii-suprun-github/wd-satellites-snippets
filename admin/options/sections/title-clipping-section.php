<?php

    // Set title`s length of posts/pages
    if( function_exists('wpseo_init') && get_option('wdss_enable_title_clipping', '0') ) {
      add_filter('wpseo_title', 'yoast_trim_title');
      function yoast_trim_title($post_title) {
        global $post;
        $is_old_post = false;
        $post_date = strtotime($post->post_date);
          
        if( get_option('wdss_title_clipping_by_date', '') ) {
          $post_date_limiter = strtotime(get_option('wdss_title_clipping_by_date', ''));
          $is_old_post =  $post_date > $post_date_limiter ? false : true;           
        }

        $words_limit = get_option('wdss_title_words_limit', '6'); // max title`s words amount 
        $symbols_limit = get_option('wdss_word_chars_limit', '35'); // max title`s symbols amount 
        $ending = ' ' . get_option('wdss_title_ending') . ''; // adds title`s ending
        $ending_exists = boolval(strpos($post_title, $ending));
        $title_less_than_count = boolval(mb_strlen($post_title) < $symbols_limit);

        $is_already_exists = $title_less_than_count && $ending_exists;

        if( get_option('wdss_title_clipping_excluded', '') !== '' ) {
          $excluded_arr =  explode(',', get_option('wdss_title_clipping_excluded'));
          $is_excluded = in_array($post->ID, $excluded_arr);
        }

        
        if ( !is_single()  || $is_already_exists || $is_old_post ||  $is_excluded )   { // where`s title trimming shouldn`t be implemented
          return $post_title;
        }	
        
        $title_arr = explode(' ', $post_title);
        // small words counter; if there`is none of them then don't extend words limit
        $words_limit_ext = 0;

        foreach($title_arr as $word) {
          if(mb_strlen($word) < 2) {
            $words_limit_ext++;
          }
        }

        array_splice($title_arr, $words_limit + $words_limit_ext);
        $post_title = implode(' ', $title_arr);

        return $post_title . $ending;
      }
    }
<?php 



// Polylang Meta Descriptions Settings
if(get_option('wdss_polylang_meta_data', '0')) {
  function polylang_meta_description($meta_description) {
    if( function_exists('pll_the_languages') ) {

        $current_lang = pll_current_language();
        $author = get_the_author_meta('user_nicename');   

        if( is_home() || is_front_page() ) {
            switch ($current_lang) {
                case 'en'  :
                    $meta_description = get_option('wdss_polylang_home_desc_en', '');
                    break;
                case 'de'  :
                    $meta_description = get_option('wdss_polylang_home_desc_de', '');
                    break;
                case 'pl'  :
                    $meta_description = get_option('wdss_polylang_home_desc_pl', '');
                    break;
                case 'es'  :
                    $meta_description = get_option('wdss_polylang_home_desc_es', '');
                    break;
                default :
                    $meta_description;
            }
            return $meta_description;
        }
        elseif( is_author($author) ) {
      
            switch ($current_lang) {
                case 'en'  :
                    $meta_description = get_option('wdss_polylang_author_desc_' . $author . '_en', '');
                    var_dump($meta_description);
                    break;
                case 'de'  :
                    $meta_description = get_option('wdss_polylang_author_desc_' . $author . '_de', '');
                    break;
                case 'pl'  :
                    $meta_description = get_option('wdss_polylang_author_desc_' . $author . '_pl', '');
                    break;
                case 'es'  :
                    $meta_description = get_option('wdss_polylang_author_desc_' . $author . '_es', '');
                    break;
                default :
                  $meta_description;
            }     
            return $meta_description;
        }
    }
  }
  add_filter('wpseo_metadesc', 'polylang_meta_description', 99);
  add_filter('wpseo_opengraph_desc', 'polylang_meta_description', 99);
}
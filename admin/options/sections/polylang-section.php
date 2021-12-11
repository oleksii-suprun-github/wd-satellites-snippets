<?php 

// Polylang Meta Descriptions Settings
if( get_option('wdss_polylang_meta_data', '0') ) {

    function polylang_meta_title($meta_title) {
        if( function_exists('pll_the_languages') ) {
    
            $current_lang = pll_current_language();
            $author = get_the_author_meta('user_nicename');   
    
            if( is_home() || is_front_page() ) {
                switch ($current_lang) {
                    case 'en'  :
                        $meta_title = get_option('wdss_polylang_home_title_en', '');
                        break;
                    case 'de'  :
                        $meta_title = get_option('wdss_polylang_home_title_de', '');
                        break;
                    case 'pl'  :
                        $meta_title = get_option('wdss_polylang_home_title_pl', '');
                        break;
                    case 'es'  :
                        $meta_title = get_option('wdss_polylang_home_title_es', '');
                        break;
                    default :
                        $meta_title;
                }
                return $meta_title;
            }
            elseif( is_author($author) ) {
          
                switch ($current_lang) {
                    case 'en'  :
                        $meta_title = get_option('wdss_polylang_author_title_' . $author . '_en', '');
                        break;
                    case 'de'  :
                        $meta_title = get_option('wdss_polylang_author_title_' . $author . '_de', '');
                        break;
                    case 'pl'  :
                        $meta_title = get_option('wdss_polylang_author_title_' . $author . '_pl', '');
                        break;
                    case 'es'  :
                        $meta_title = get_option('wdss_polylang_author_title_' . $author . '_es', '');
                        break;
                    default :
                      $meta_title;
                }     
                return $meta_title;
            }
            return $meta_title;
        }
    }
    add_filter('wpseo_title', 'polylang_meta_title', 99);
    add_filter('wpseo_opengraph_title', 'polylang_meta_title', 99);

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
            return $meta_description;
        }
  }
  add_filter('wpseo_metadesc', 'polylang_meta_description', 99);
  add_filter('wpseo_opengraph_desc', 'polylang_meta_description', 99);
}


if( get_option('wdss_multilang_sitemap', '0') ) {
    function wdss_multilang_sitemap() {
        require_once dirname( __FILE__ ) . '/../inc/multilang_sitemap_generator.php';
    }
    add_action('wp_loaded', 'wdss_multilang_sitemap');
}
else if(get_option('wdss_multilang_sitemap', '0') === '0') {
    require_once ABSPATH . 'wp-admin/includes/file.php';

    $file = get_home_path(). 'sitemap_index.xml';
    if( file_exists($file) ) {
        wp_delete_file( $file);
    }
}
<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Mironezes
 *
 * @package    Wd_Satellites_Snippets
 * @subpackage Wd_Satellites_Snippets/admin
 */


// Includes Admin Panel UI Template
require('templates/wd-satellites-snippets-admin-display.php');


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wd_Satellites_Snippets
 * @subpackage Wd_Satellites_Snippets/admin
 * @author     Alexey Suprun <mironezes@gmail.com>
 */
class Wd_Satellites_Snippets_Admin {


	private $plugin_name;
	private $version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


	// Admin Functionality Init
	public function wdss_init() {

    add_action( 'admin_menu', array($this, 'wdss_admin_menu'));

		if ( is_admin_bar_showing() ) {
			add_action( 'admin_bar_menu', array($this, 'wdss_add_adminbar_link'), 100);
		}
		
		$this->wdss_snippets();
	}


	// Snippets List
  protected function wdss_snippets() {

		// Last-modifed Snippet
		if( get_option('wdss_last_modified_n_304', '0') ) {
			function wdss_last_modified() {

				function last_modified_default() {
					$LastModified_unix = getlastmod();
					$LastModified = gmdate( "D, d M Y H:i:s \G\M\T", $LastModified_unix );
					$IfModifiedSince = false;
					if ( isset($_ENV['HTTP_IF_MODIFIED_SINCE']) ) {
						$IfModifiedSince = strtotime( substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5) );
					}
					if ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ) {
						$IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
					}
					if ( $IfModifiedSince && $IfModifiedSince >= $LastModified_unix ) {
						header( $_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified' );
						exit;
					}
					header( 'Last-Modified: '. $LastModified );

					add_action('wbcr/factory/option_if_modified_since_headers', function($option_value){
						$server_headers = apache_response_headers();
						if (isset($server_headers['Last-Modified'])
							&& !empty($server_headers['Last-Modified'])
							&& $option_value){
							
							header_remove('Set-Cookie');
						}
							
						return $option_value;
					}, 1);
				}

				function last_modified_polylang() {
					if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( is_admin() ) ) {
						return;
					}
				
					$last_modified = '';
				
					if ( is_singular() ) {
						global $post;
				
						if ( post_password_required( $post ) )
							return;
				
						if ( !isset( $post -> post_modified_gmt ) ) {
							return;
						}
				
						$post_time = strtotime( $post -> post_modified_gmt );
						$modified_time = $post_time;
				
						if ( ( int ) $post -> comment_count > 0 ) {
							$comments = get_comments( array(
								'post_id' => $post -> ID,
								'number' => '1',
								'status' => 'approve',
								'orderby' => 'comment_date_gmt',
									) );
							if ( !empty( $comments ) && isset( $comments[0] ) ) {
								$comment_time = strtotime( $comments[0] -> comment_date_gmt );
								if ( $comment_time > $post_time ) {
									$modified_time = $comment_time;
								}
							}
						}
				
						$last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
					}
				
					if ( is_archive() || is_home() ) {
						global $posts;
				
						if ( empty( $posts ) ) {
							return;
						}
				
						$post = $posts[0];
				
						if ( !isset( $post -> post_modified_gmt ) ) {
							return;
						}
				
						$post_time = strtotime( $post -> post_modified_gmt );
						$modified_time = $post_time;
				
						$last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
					}
				
					if ( headers_sent() ) {
						return;
					}
				
					if ( !empty( $last_modified ) ) {
						header( 'Last-Modified: ' . $last_modified );
				
						if ( !is_user_logged_in() ) {
							if ( isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) && strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) >= $modified_time ) {
								$protocol = (isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1');
								header( $protocol . ' 304 Not Modified' );
							}
						}
					}
				}

				if( function_exists('pll_the_languages') ) {
					add_action( 'template_redirect', 'last_modified_polylang' );
				}
				else {
					last_modified_default();
				}
			}
		}


		// Force Lowercase URLs Snippet
		if( get_option('wdss_force_lowercase', '0') ) {
			function wdss_force_lowercase() {
					$url = $_SERVER['REQUEST_URI'];
					$params = (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '');
					
					// If URL contains a period, halt (likely contains a filename and filenames are case specific)
					if ( preg_match('/[\.]/', $url) ) {
						return;
					}
					
					// If URL contains a capital letter
					if ( preg_match('/[A-Z]/', $url) ) {
					
						// // If URL contains a '%' - skip, if url decoded
						if (strpos($url, '%') !== false) {
							return;
						}
					
						$lc_url = empty($params)
						? strtolower($url)
						: strtolower(substr($url, 0, strrpos($url, '?'))).'?'.$params;
						
						// if url was modified, re-direct
						if ($lc_url !== $url) {
							header('Location: '.$lc_url, TRUE, 301);
							exit();
						}
					}
			}
		}


    // Auto Generated Alts for images on attach action
    add_action('add_attachment', 'wd_auto_generated_image_alts');
    function wd_auto_generated_image_alts($postID)
    {
        if (wp_attachment_is_image($postID))
        {
            // Grab the Title auto-generated by WordPress
            $ehi_image_title = get_post($postID)->post_title;
    
            // Remove hyphens, underscores, and extra spaces
            $ehi_image_title = preg_replace('%\s*[-_\s]+\s*%', ' ',  $ehi_image_title);
    
            // Capitalize first letter of every word
            $ehi_image_title = ucwords(strtolower($ehi_image_title));
            
            $ehi_image_meta = array(
                'ID'        => $postID,
                'post_title'    => $ehi_image_title, // Image Title
                'post_content'  => $ehi_image_title, // Image Description (Content)
            );
    
            // Update the Alt Text
            update_post_meta($postID, '_wp_attachment_image_alt', $ehi_image_title);
    
            // Update the other fields
            wp_update_post($ehi_image_meta);
        } 
    }


    function gallery_template_to_posts() {
      $post_type_object = get_post_type_object( 'post' );
      $post_type_object->template = array(
          array( 'core/gallery', array(
              'linkTo' => 'media',
          ) ),
      );
    }
    add_action( 'init', 'gallery_template_to_posts' );


    // Auto Featured Image on post saving (from first attached image)
    if( get_option('wdss_auto_featured_image', '0') ) {
      add_action('future_to_publish', 'autoset_featured');
      add_action('draft_to_publish', 'autoset_featured');
      add_action('new_to_publish', 'autoset_featured');
      add_action('pending_to_publish', 'autoset_featured');
      add_action('save_post', 'autoset_featured');
  
      function autoset_featured() {
        global $post;
  
        if( has_post_thumbnail($post->ID) )
          return;
  
        $attached_image = get_children( array(
          'post_parent'=>$post->ID, 'post_type'=>'attachment', 'post_mime_type'=>'image', 'numberposts'=>1, 'order'=>'ASC'
        ) );
  
        if( $attached_image ){
          foreach ($attached_image as $attachment_id => $attachment)
            set_post_thumbnail($post->ID, $attachment_id);
        }
      }
    }


    // Auto Alt Attributes for images
    if( get_option('wdss_auto_alt_attribute', '0') ) {
      function wdss_alt_singlepage_autocomplete( $content ) {
        global $post;
    
        if ( empty( $post ) ) {
          return $content;
        }
    
        $old_content = $content;
    
        preg_match_all( '/<img[^>]+>/', $content, $images );
    
        if ( ! is_null( $images ) ) {
          foreach ( $images[0] as $index => $value ) {
            if ( ! preg_match( '/alt=/', $value ) ) {
              $new_img = str_replace( '<img', '<img alt="' . esc_attr( $post->post_title ) . '"', $images[0][ $index ] );
              $content = str_replace( $images[0][ $index ], $new_img, $content );
            } else if ( preg_match( '/alt=["\']\s?["\']/', $value ) ) {
              $new_img = preg_replace( '/alt=["\']\s?["\']/', 'alt="' . esc_attr( $post->post_title ) . '"', $images[0][ $index ] );
              $content = str_replace( $images[0][ $index ], $new_img, $content );
            }
          }
        }
    
        if ( empty( $content ) ) {
          return $old_content;
        }
    
        return $content;
      }
      add_filter('the_content', 'wdss_alt_singlepage_autocomplete');

      function wdss_alt_attachment_autocomplete($html, $post_id, $post_thumbnail_id, $size, $attr) {
        
        if(!isset($attr['alt'])) {
          $id = get_post_thumbnail_id();
          $alt_text = get_the_title($post_id);
       
          $html = str_replace( 'alt=""', 'alt="' . esc_attr( $alt_text ) . '"', $html );
        }

        return $html;
      }
      add_filter('post_thumbnail_html', 'wdss_alt_attachment_autocomplete', 10, 5);      
    }


    // AMP Template Fix
    if( function_exists('amp_bootstrap_plugin') && get_option('wdss_amp_fix', '0') ) {
      add_filter( 'amp_post_template_data', function( $data, $post ) {
        if ( has_post_thumbnail( $post ) ) {
            $data['featured_image']['amp_html'] = '<amp-img
            src="'.wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium')[0].'"
            width="'.wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium')[1].'"
            height="'.wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium')[2].'"
            class="img-responsive amp-wp-enforced-sizes i-amphtml-element i-amphtml-layout-intrinsic i-amphtml-layout-size-defined i-amphtml-layout"
            alt="featured image"
            layout="responsive"></amp-img>'; 
        }
        return $data;
      }, 10, 2 );

      add_action( 'amp_post_template_css', function() {
        ?>
        @media screen and (max-width: 360px) {
            .amp-wp-article img { display: none;}
        }
        .wp-block-image { width: fit-content; margin: 0 auto; margin-bottom: 1rem; }
        .amp-wp-article-featured-image amp-img { width: 300px; }
        <?php
      } );
    }


    // Disable Automatic Plugins and Theme Updates Snippet
    if( get_option('wdss_disable_autoupdates', '0') ) {
      add_filter( 'auto_update_plugin', '__return_false' );
      add_filter( 'auto_update_theme', '__return_false' );
    }


    // Disable Admin Notices
    if( get_option('wdss_disable_admin_notices', '0') ) {

      function wdss_disable_admin_notices() {   
        // Hide Update notifications
        echo 
        '<style>
            body.wp-admin .update-plugins, 
            body.wp-admin  .plugin-update-tr,
            body.wp-admin #wp-admin-bar-updates,
            body.wp-admin .update-nag,
            .jitm-banner {display: none !important;} 
        </style>';
                      

        // Hide notices from the wordpress backend
        echo 
        '<style> 
          body.wp-admin .error:not(.is-dismissible),
          #yoast-indexation-warning, #akismet_setup_prompt, .jp-wpcom-connect__container {display: none !important;}
          body.wp-admin #loco-content .notice,
          body.wp-admin #loco-notices .notice{display:block !important;}
        </style>';

        // Hide PHP Updates from the wordpress backend
        echo 
        '<style>
          #dashboard_php_nag {display:none;}
        </style>';
                        
      }
      add_action('admin_enqueue_scripts', 'wdss_disable_admin_notices');
      add_action('login_enqueue_scripts', 'wdss_disable_admin_notices');
    }

    
    // Remove redundant links Snippet
    if( get_option( 'wdss_redundant_links', '0' ) ) {
      remove_action( 'wp_head', 'wlwmanifest_link' );
      remove_action( 'wp_head', 'index_rel_link' ); 
      remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 
      remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); 
      remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); 
      remove_action( 'wp_head', 'wp_generator' );
    
      remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
      remove_action( 'wp_head', 'wp_oembed_add_host_js' );
      remove_action( 'rest_api_init', 'wp_oembed_register_route' );
      remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
      remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

      remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
  
      add_filter( 'embed_oembed_discover', '__return_false' );

      add_filter( 'json_enabled', '__return_false' );
      add_filter( 'json_jsonp_enabled', '__return_false' );
    
      add_filter( 'rest_enabled', '__return_false' );
      add_filter( 'rest_jsonp_enabled', '__return_false' );
    }
  
    
    // Remove Yoast Schema Snippet
    if( function_exists('wpseo_init') && get_option('wdss_yoast_schema', '0') ) {
      add_filter( 'wpseo_json_ld_output', '__return_false' );
    }


    // Set title`s length of posts/pages
    if( function_exists('wpseo_init') && get_option('wdss_enable_title_clipping', '0') ) {
      add_filter('wpseo_title', 'yoast_trim_title');
      function yoast_trim_title($post_title) {
        global $post;
        $is_old_post = false;
        
        if( get_option('wdss_title_clipping_condition', '0') ) {
          $post_date = strtotime($post->post_date);
          
          if( get_option('wdss_title_clipping_by_date', '0') ) {
            $post_date_limiter = strtotime(get_option('wdss_title_clipping_by_date', '0'));
            $is_old_post =  $post_date > $post_date_limiter ? false : true;           
          }
        }

        $words_limit = get_option('wdss_title_words_limit', '6'); // max title`s words amount 
        $symbols_limit = get_option('wdss_word_chars_limit', '35'); // max title`s symbols amount 
        $ending = ' ' . get_option('wdss_title_ending') . ''; // adds title`s ending
        $ending_exists = boolval(strpos($post_title, $ending));
        $title_less_than_count = boolval(mb_strlen($post_title) < $symbols_limit);

        $is_already_exists = $title_less_than_count && $ending_exists;

        if( get_option('wdss_title_clipping_excluded', '') !== '' ) {
          $excludedArr =  explode(',', get_option('wdss_title_clipping_excluded'));
          $is_excluded = in_array($post->ID, $excludedArr);
        }
        
        if ( !is_single()  || $is_already_exists || $is_old_post ||  $is_excluded )   { // where`s title trimming shouldn`t be implemented
          return $post_title;
        }	
        
        $words = explode(' ', $post_title);
        array_splice($words, $words_limit);
        $post_title = implode(' ', $words);

        return $post_title . $ending;
      }
    }


    // Autoptimize Lazyload Fix Snippet
    if( function_exists('autoptimize') && get_option('wdss_autoptimize_lazy_fix', '0') ) {
      add_filter( 'autoptimize_filter_imgopt_lazyload_cssoutput', '__return_false' );
      add_action( 'wp_head', function() { echo '<style>.lazyload,.lazyloading{opacity:0;}.lazyloaded{opacity:1;transition:opacity 300ms;}</style>'; }, 999 );
    }


    // Remove Gutenberg-related stylesheets Snippet
    if( get_option('wdss_gutenberg_styles', '0') ) {
      add_action('wp_enqueue_scripts', 'remove_gutenbers_css', 100);
      function remove_gutenbers_css() {
        wp_dequeue_style('wp-block-library'); 
        wp_dequeue_style('wp-block-library-theme');
      }
    }


    // Redirects Rules Snippet
    if( get_option('wdss_amp_rules', '0') ) {
      function wdss_amp_plugin_change_behavior($url, $status) {
        if ( !is_admin() ) {
  
            if ($_SERVER['SCRIPT_NAME'] === '/wp-login.php'
                || $_SERVER['SCRIPT_NAME'] === '/wp-admin/index.php'
                || $_SERVER['SCRIPT_NAME'] === '/wp-comments-post.php') {
                return $url;
            }
  
            if ($status === 302) {
                wp_redirect(site_url() . $_SERVER['REDIRECT_URL'], 301);
                exit();
            }
  
            if ($status === 301) {
                $regex = '/\/{0,5}([_\?\/])amp[_]*\/?/';
                preg_match($regex, $url, $matches);
                if (!empty($matches)) {
  
                    if (is_front_page() or is_home()) {
                        wp_redirect(site_url(), 301);
                        exit();
                    }
  
                    if (is_category() or is_archive()) {
                        $newUri = preg_replace($regex, '', $_SERVER['REQUEST_URI']);
                        wp_redirect(site_url() . trailingslashit($newUri), 301);
                        exit();
                    }
  
                }
            }
        }
        return $url;
      }
      add_filter('wp_redirect', 'wdss_amp_plugin_change_behavior', 10, 2);
  
      function wdss_generate_rewrite_rules() {
          if ( !is_admin() ) {
              $url = $_SERVER['REQUEST_URI'];
              $regex = '/\/{0,5}([_\?\/])amp[_]*\/?/';
              preg_match($regex, $url, $matches);
              if (!empty($matches)) {
                  if (!is_singular()) {
                      $newUri = preg_replace($regex, '', $_SERVER['REQUEST_URI']);
                      $newUri = trailingslashit($newUri);
                      if (substr($newUri, 0, 1) !== '/') {
                          $newUri = '/' . $newUri;
                      }
                      wp_redirect(site_url() . trailingslashit($newUri), 301);
                      exit();
                  }
  
                  if (is_singular() && !is_category() && !is_archive() && !is_page()) {
                      if (substr($url, -5) !== '/amp/') {
                          $current_url = preg_replace($regex, '/', $url);
                          $current_url .= 'amp/';
                          wp_redirect(site_url($current_url), 301);
                          exit();
                      }
                  }
              }
          }
      }
      add_action('wp', 'wdss_generate_rewrite_rules', -1);
  

      if( !is_admin() ) {
        $url = $_SERVER['REQUEST_URI'];

        if (
          $url == "/index.html"  || 
          $url == "/index.php"   || 
          $url == "/feed"        || 
          $url == "/feed/"       || 
          $url == "/amp"         || 
          $url == "/?amp"        || 
          $url == "/?amp/"       || 
          $url == "//?amp/"
        ) {
          wp_redirect(site_url('/'), 301);
          exit();
        }
      }
    }


    // Force tralling slash
    if( get_option('wdss_forced_trail_slash', '0') ) {

      function wdss_forced_trail_slash($rules) {
          $rule  = "\n";
          $rule .= "# Force Tralling Slash.\n";
          $rule .= "<IfModule mod_rewrite.c>\n";
          $rule .= "RewriteEngine On\n";
          $rule .= "RewriteCond %{REQUEST_URI} !(/$|\.)\n";
          $rule .= "RewriteRule (.*) %{REQUEST_URI}/ [R=301,L]\n";
          $rule .= "</IfModule>\n";
          $rule .= "\n";
        
          return $rule . $rules;
        }

        add_filter('mod_rewrite_rules', 'wdss_forced_trail_slash'); 
    }


    // Disable Feeds
    if( get_option('wdss_disable_rss', '0') )  {

      function remove_feed_links()
      {
        remove_action( 'wp_head', 'feed_links', 2 ); 
        remove_action( 'wp_head', 'feed_links_extra', 3 );       
        remove_action( 'wp_head', 'rsd_link', 4 ); 
      }

      function disabled_feed_behaviour()
      {
        global $wp_rewrite, $wp_query;

          if( isset($_GET['feed']) ) {
            wp_redirect(esc_url_raw(remove_query_arg('feed')), 301);
            exit;
          }

          if( 'old' !== get_query_var('feed') ) {    // WP redirects these anyway, and removing the query var will confuse it thoroughly
            set_query_var('feed', '');
          }

          redirect_canonical();    // Let WP figure out the appropriate redirect URL.

          // Still here? redirect_canonical failed to redirect, probably because of a filter. Try the hard way.
          $struct = (!is_singular() && is_comment_feed()) ? $wp_rewrite->get_comment_feed_permastruct() : $wp_rewrite->get_feed_permastruct();

          $struct = preg_quote($struct, '#');
          $struct = str_replace('%feed%', '(\w+)?', $struct);
          $struct = preg_replace('#/+#', '/', $struct);
          $requested_url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

          $new_url = preg_replace('#' . $struct . '/?$#', '', $requested_url);

          if( $new_url !== $requested_url ) {
            wp_redirect($new_url, 301);
            exit;
          }
      }    
      
      function filter_feeds()
      {
        if( !is_feed() || is_404() ) {
          return;
        }

        disabled_feed_behaviour();
      }

      add_action('wp_loaded', 'remove_feed_links');
      add_action('template_redirect', 'filter_feeds', 1);

    }


    // Yoast Canonical Pagination Fix Snippet
    if( get_option('wdss_yoast_canonical_fix', '0') ) {
      add_filter('wpseo_canonical', 'wdss_fix_canon_pagination');
      function wdss_fix_canon_pagination($link) {
        $link = preg_replace('#\??/page[\/=]\d+#', '', $link);
        return $link;
      }
    }

    
    // 410 Category Rules
    if( get_option('wdss_410_rules', '0') ) {
      function wdss_force_410()
      {
          $requestUri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
          $requestUri = urldecode($requestUri);
          switch ($requestUri) {
              case 'https://'.$_SERVER['HTTP_HOST'].'/uncategorized/':
              case 'https://'.$_SERVER['HTTP_HOST'].'/uncategorized':
              case 'https://'.$_SERVER['HTTP_HOST'].'/bez-kategorii/':
              case 'https://'.$_SERVER['HTTP_HOST'].'/bez-kategorii':
              case 'https://'.$_SERVER['HTTP_HOST'].'/без-категории/':
              case 'https://'.$_SERVER['HTTP_HOST'].'/без-категории':
                  global $post, $wp_query;
                  $wp_query->set_404();
                  status_header(404);
                  header("HTTP/1.0 410 Gone");
                  include(get_query_template('404'));
                  exit;
          }
      }
      add_action( 'wp', 'wdss_force_410' );
    }
  }

	// Add Admin Menu
	public function wdss_admin_menu() {
		add_menu_page('WD Sattelites Snippets', 'WD Sattelites Snippets', 'manage_options', 'wd-sattelites-snippets', 'wdss_settings_template', 'dashicons-admin-tools', 100 );
	}

	// Add Adminbar Quick Link
	public function wdss_add_adminbar_link($admin_bar) {
		$admin_bar->add_menu([
			'id'    => 'wdss',
			'title' => 'Satellites Snippets',
			'href'  =>  admin_url('admin.php?page=wd-sattelites-snippets'),
			'meta'  => array(
					'title' => 'WD Satellites Snippets'
			),
		]);
	}

	// Register the stylesheets for the admin area
	public function wdss_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wd-satellites-snippets-admin.css', array(), $this->version, 'all' );

	}

	//Register the JavaScript for the admin area
	public function wdss_enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wd-satellites-snippets-admin.js', array(), $this->version, true );
	}
}


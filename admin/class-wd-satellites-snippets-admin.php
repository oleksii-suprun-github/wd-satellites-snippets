<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Mironezes
 *
 * @package    Wd_Satellites
 * @subpackage Wd_Satellites/admin
 */


// Includes Admin Panel UI Template
require('templates/wd-satellites-snippets-admin-display.php');

// Includes Admin Panel Options List
require_once('options/wd-satellites-snippets-admin-options.php');


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wd_Satellites
 * @subpackage Wd_Satellites/admin
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
		add_filter( 'auto_update_plugin', array($this, 'wdss_auto_update'), 100, 2 );

		if ( is_admin_bar_showing() ) {
			add_action( 'admin_bar_menu', array($this, 'wdss_add_adminbar_link'), 100);
		}

    $options = new Wd_Satellites_Snippets_Admin_Options();
		$options->wdss_snippets();
    if( get_option('wdss_last_modified_n_304', '0') ) {
      $options->wdss_last_modified();
    }

		if( wp_doing_ajax() ) {

			add_action( 'wp_ajax_remove_posts_attachments',  array($this, 'wdss_remove_posts_attachments_handler') );

			add_action( 'wp_ajax_fetch_broken_featured',  array($this, 'wdss_get_broken_featured') );
			add_action( 'wp_ajax_remove_broken_featured',  array($this, 'wdss_remove_broken_featured') );

			add_action( 'wp_ajax_fetch_all_posts',  array($this, 'wdss_get_all_empty_posts') );
			add_action( 'wp_ajax_fix_posts_validation_errors', array($this, 'wdss_fix_validation_errors') );
			
			add_action( 'wp_ajax_e410_dictionary_update', array($this, 'wdss_e410_dictionary_handler') );
			add_action( 'wp_ajax_excluded_hosts_dictionary_update', array($this, 'wdss_excluded_hosts_dictionary_handler') );		
		}
	}

	
  // Removes WP Security captcha validation error
  public function wdss_wp_security_captcha_buffer_start() {
      ob_start(array($this, 'wdss_wp_security_captcha_validation_fix'));
  }
  
  public function wdss_wp_security_captcha_buffer_end() {
      ob_end_clean();
  }
  
  public function wdss_wp_security_captcha_validation_fix( $output ) {
      if ( comments_open() ) {
        $pattern = '/<p (class="aiowps-captcha")>(.*)<\/p>/';
        preg_match_all( $pattern, $output, $matches );
        if ( ! empty( $matches[0] ) ) {
          foreach ( $matches[0] as $match ) {
            $output = preg_replace($pattern, '<div $1>$2</div>', $output);
          }
        }
      }
      return $output;
  }



	// Add Admin Menu
	public function wdss_admin_menu() {
		add_options_page( 'WD Satellite Settings', 'WD Satellite', 'manage_options', 'wd-sattelites-snippets', 'wdss_settings_template', null, 100 );
	}


	// Add Adminbar Quick Link
	public function wdss_add_adminbar_link($admin_bar) {
		$admin_bar->add_menu([
			'id'    => 'wdss',
			'title' => 'WD Satellite',
			'href'  =>  admin_url('options-general.php?page=wd-sattelites-snippets'),
			'meta'  => array(
					'title' => 'WD Satellite Settings'
			),
		]);
	}

	// Enables Auto Update for this plugin
	public function wdss_auto_update( $update, $item ){
		$plugins = array (
			'wd-satellites-snippets',
			'wd-bulk-validation-fixer',
		);
	
		if( in_array($item->slug, $plugins) )
			return true; 
		else
			return $update; 
	}


	// Register the stylesheets for the admin area
	public function wdss_admin_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/css/main.css', array(), $this->version, 'all' );
	}


	// Remove all Posts Attached Images Handler
	public function wdss_remove_posts_attachments_handler() {
		check_ajax_referer( 'remove-posts-attachments-nonce', 'security', false );

		$args = array(
      'fields'          => 'ids', 
      'posts_per_page'  => -1,
      'post_status' => 'any'
    );
    $posts = get_posts($args);
    
    foreach($posts as $id) {
      delete_post_thumbnail($id);
    
      $attachments = get_attached_media('image', $id);
      foreach($attachments as $attachment) {
        wp_delete_attachment($attachment->ID, true);
        usleep(500);
      }
      usleep(500);
    }
	}


	// Errors 410 Dictionary Handler
	public function wdss_e410_dictionary_handler() {
		check_ajax_referer( 'e410-dictionary-nonce', 'security', false );

    $e410_dictionary = $_POST["e410_dictionary"];
    update_option('wdss_410s_dictionary', $e410_dictionary);
	}


	// Excluded Images Hosts Dictionary Handler
	public function wdss_excluded_hosts_dictionary_handler() {
		check_ajax_referer( 'excluded-hosts-dictionary-nonce', 'security', false );

    $excluded_hosts_dictionary = $_POST["excluded_hosts_dictionary"];
    update_option('wdss_excluded_hosts_dictionary', $excluded_hosts_dictionary);
	}



	// Removes broken Featured with Ajax Call
	public function wdss_remove_broken_featured() {
		check_ajax_referer( 'remove-broken-featured-nonce', 'broken_featured_nonce2', false );
		$selected_ids_arr = json_decode(stripslashes($_POST['selected_list']));

		var_dump($selected_ids_arr);

		if( !empty(explode(',', $selected_ids_arr)) ) {
			$selected_ids_arr = explode(',', $selected_ids_arr);
			foreach($selected_ids_arr as $id) {
				delete_post_thumbnail($id);
			}
		}
		else {
			delete_post_thumbnail(intval($selected_ids_arr));
		}

		die();
	}



	// Fixes Posts Empty Content with Ajax Call
	public function wdss_fix_validation_errors() {

		check_ajax_referer( 'fix-posts-validation-errors-nonce', 'fix_posts_validation_errors_nonce', false );
		$selected_ids = json_decode(stripslashes($_POST['selected_list']));
		$selected_ids_arr = [];

		if(strpos($selected_ids, ',') !== false) {
			$selected_ids_arr = explode(',', $selected_ids);
		}
		else {
			 array_push($selected_ids_arr, $selected_ids);
		}

		var_dump($selected_ids_arr);

		foreach ($selected_ids_arr as $id)
		{

				$revisions_arr = wp_get_post_revisions($id, ['offset' => 1, // Start from the previous change
				'posts_per_page' => 1, // Only a single revision
				'post_name__in' => ["{$id}-revision-v1"], 'check_enabled' => false, ]);
	

				if (!empty($revisions_arr))
				{
						$revision = array_pop(array_reverse($revisions_arr));
						$revision_parent_id = $revision->post_parent;

						if ($id == $revision_parent_id)
						{
		
								$revision_content = $revision->post_content;
								var_dump($revision_content);

								$updated_post_args = array(
										'ID' => $revision_parent_id,
										'post_status' => 'publish',
										'post_content' => $revision_content,
										'tags_input' => ''  
								);
								wp_update_post($updated_post_args);
								
								if(get_option('wdss_410s_dictionary')) {
									$post = get_post($revision_parent_id);
									$url = '/'.$post->post_name.'/';

									$values_arr = get_option('wdss_410s_dictionary');
									$pos = array_search($url, $values_arr);
									unset($values_arr[$pos]);
									$values_arr = array_unique($values_arr);
									update_option('wdss_410s_dictionary', $values_arr);
								}
						}
				}
				else
				{
						echo 'no revisions for id: # ' . $id . ';<br>';
				}
				usleep(150);
		}

		die();
	}
	
	

	// Posts with broken Featured modal
	public function wdss_get_broken_featured() {
		check_ajax_referer( 'broken-featured-list-nonce', 'broken_featured_nonce1', false );
		$posts = json_decode(stripslashes($_POST['fetched_list']));

		foreach($posts as $post) {
			$thumbnail_url = get_the_post_thumbnail_url($post->id);
			$is_broken = !check_url_status($thumbnail_url);
				
			if( $is_broken) {
		?>
			<tr class="wdss-table-row post">
				<td class="wdss-table-post__select"><input type="checkbox" value="<?= $post->id; ?>"></td>
				<td><?= $post->id;?></td>
				<td><?= $post->title->rendered;?></td>
				<td><?= $post->status;?></td>
				<td><?= $post->date;?></td>		
				<td><a href="<?= $post->link;?>" target="_blank">Open</a></td>				
			</tr>
		<?php
			}
		}
		die();
	}



	// Empty content posts modal
	public function wdss_get_all_empty_posts() {
		check_ajax_referer( 'empty-posts-list-nonce', 'empty_posts_list_nonce', false );

		$lang_list = [];

		if (function_exists('pll_the_languages'))
		{
				$lang_list = implode(',', pll_languages_list('locale'));
		}
		
		$args = array(
				'post_type' => 'post',
				'post_status' => array(
						'publish',
						'pending',
						'draft',
						'future',
						'private',
						'inherit'
				) ,
				'posts_per_page' => - 1,
				'orderby' => 'ID',
				'lang' => $lang_list,
				'order' => 'desc'
		);


		$blank_posts = array();
		
		$posts = new WP_Query($args);

		if ($posts->have_posts()):
				while ($posts->have_posts()):
						$posts->the_post();
						global $post;
						$content = get_the_content();
						if (empty($content))
						{
							array_push($blank_posts, $post);
							
						}
				endwhile;
		endif;

		if (!empty($blank_posts)) :
    	foreach ($blank_posts as $post) :?>

				<tr class="wdss-table-row post">
					<td class="wdss-table-post__select"><input type="checkbox" value="<?= $post->ID; ?>"></td>
					<td><?= $post->ID;?></td>
					<td><?= $post->post_title?></td>
					<td><?= $post->post_status;?></td>
					<td><?= $post->post_date;?></td>		
					<td><a href="<?= $post->link;?>" target="_blank">Open</a></td>	
				</tr>
   <?php 
				sleep(1); 
			endforeach;
		endif;	

		die();
	}


	//Register the JavaScript for the admin area
	public function wdss_admin_enqueue_scripts($page) {

		wp_enqueue_script( 'global', plugin_dir_url( __FILE__ ) . '../assets/js/global.js', array(), $this->version, true );

		if( get_current_screen()->id == 'settings_page_wd-sattelites-snippets' ) {
			wp_enqueue_media();
		
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/js/main.js', array(), wp_rand(), true );
			
			$get_title_separator = '';
			if( function_exists( 'YoastSEO' ) && YoastSEO()->helpers->options->get_title_separator() !== null ) {
				$get_title_separator = YoastSEO()->helpers->options->get_title_separator();
			}

			$wdss_localize_script = [
				'site_yoast_ending' => $get_title_separator . ' ' . get_bloginfo( 'name' ),
				'site_name' => get_bloginfo( 'name' ),
				'site_email' => 'info@' . $_SERVER['SERVER_NAME'],

				'total_post_count' => wp_count_posts( 'post' )->publish,

				'is_polylang_exists' => function_exists( 'pll_languages_list' ),
				'is_polylang_setup' => function_exists( 'pll_languages_list' ) && count(pll_languages_list()) > 0,

				'wp_rand' => wp_rand(),
				'url' => admin_url( 'admin-ajax.php' ),

				'empty_posts_list_nonce' => wp_create_nonce('empty-posts-list-nonce'),
				'fix_posts_validation_errors_nonce' => wp_create_nonce('fix-posts-validation-errors-nonce'),
				'reset_posts_validation_status_nonce' => wp_create_nonce('reset-posts-validation-status-nonce'),

				'broken_featured_list_nonce' => wp_create_nonce( 'broken-featured-list-nonce' ),
				'remove_broken_featured_nonce' => wp_create_nonce( 'remove-broken-featured-nonce' ),

				'e410_dictionary_nonce' => wp_create_nonce( 'e410-dictionary-nonce' ),
				'excluded_hosts_dictionary_nonce' => wp_create_nonce( 'excluded-hosts-dictionary-nonce' ),
				
				'remove_posts_attachments_nonce' => wp_create_nonce( 'remove-posts-attachments-nonce' ),
			];
			wp_localize_script( $this->plugin_name, 'wdss_localize', $wdss_localize_script );
		}
	}
}

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

		if ( is_admin_bar_showing() ) {
			add_action( 'admin_bar_menu', array($this, 'wdss_add_adminbar_link'), 100);
		}

    $options = new Wd_Satellites_Snippets_Admin_Options();
		$options->wdss_snippets();
    if( get_option('wdss_last_modified_n_304', '0') ) {
      $options->wdss_last_modified();
    }

		if( wp_doing_ajax() ) {
			add_action( 'wp_ajax_fetch_broken_featured',  array($this, 'wdss_get_broken_featured') );
			add_action( 'wp_ajax_remove_broken_featured',  array($this, 'wdss_remove_broken_featured') );

			add_action( 'wp_ajax_fetch_all_posts',  array($this, 'wdss_get_all_unvalidated_posts') );
			add_action( 'wp_ajax_fix_posts_validation_errors', array($this, 'wdss_fix_validation_errors') );
			add_action( 'wp_ajax_reset_posts_validation_status', array($this, 'wdss_reset_posts_validation_status') );
			
			add_action( 'wp_ajax_e410_dictionary_update', array($this, 'wdss_e410_dictionary_handler') );
			add_action( 'wp_ajax_excluded_hosts_dictionary_update', array($this, 'wdss_excluded_hosts_dictionary_handler') );		
		}
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


	// Register the stylesheets for the admin area
	public function wdss_admin_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/css/main.css', array(), $this->version, 'all' );
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



	// Fixes Posts Validation Errors with Ajax Call
	public function wdss_fix_validation_errors() {
		check_ajax_referer( 'fix-posts-validation-errors-nonce', 'fix_posts_validation_errors_nonce', false );
		$selected_ids_arr = json_decode(stripslashes($_POST['selected_list']));

		include_once( dirname(__DIR__) . 'options/inc/helpers.php');

		if( !empty(explode(',', $selected_ids_arr)) ) {
			$selected_ids_arr = explode(',', $selected_ids_arr);

			foreach($selected_ids_arr as $id) {
				$post = get_post($id);
				$filtered_content_stage1 = regex_post_content_filters($post->post_content);
				$filtered_content_stage2 = set_image_dimension($filtered_content_stage1);
				$filtered_content_stage3 = alt_singlepage_autocomplete($id, $filtered_content_stage2);

				$args = array(
					'ID' => $id,
					'post_content' => $filtered_content_stage3,
					'meta_input' => [
						'wdss_validation_fixed' => true
					]
				);

				wp_update_post($args);
			}
		}
		die();
	}
	

	public function wdss_reset_posts_validation_status() {
		check_ajax_referer( 'reset-posts-validation-status-nonce', 'reset_posts_validation_status_nonce', false );
		$response = json_decode(stripslashes($_POST['data']));

		if($response == true) {
			delete_metadata( 'post', 0, 'wdss_validation_fixed', false, true );
		}

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



	// Unvalidated posts modal
	public function wdss_get_all_unvalidated_posts() {
		check_ajax_referer( 'unvalidated-posts-list-nonce', 'unvalidated_posts_list_nonce', false );
		$posts = json_decode(stripslashes($_POST['fetched_list']));


		foreach($posts as $post) {
			if(!metadata_exists('post', $post->id, 'wdss_validation_fixed')) {
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

				'unvalidated_posts_list_nonce' => wp_create_nonce('unvalidated-posts-list-nonce'),
				'fix_posts_validation_errors_nonce' => wp_create_nonce('fix-posts-validation-errors-nonce'),
				'reset_posts_validation_status_nonce' => wp_create_nonce('reset-posts-validation-status-nonce'),

				'broken_featured_list_nonce' => wp_create_nonce( 'broken-featured-list-nonce' ),
				'remove_broken_featured_nonce' => wp_create_nonce( 'remove-broken-featured-nonce' ),

				'e410_dictionary_nonce' => wp_create_nonce( 'e410-dictionary-nonce' ),
				'excluded_hosts_dictionary_nonce' => wp_create_nonce( 'excluded-hosts-dictionary-nonce' ),				
			];
			wp_localize_script( $this->plugin_name, 'wdss_localize', $wdss_localize_script );
		}
	}
}

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
			add_action( 'wp_ajax_fetch_broken_featured_images',  array($this, 'wdss_get_posts_modal') );
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



	// 		// Subject to improve (currently is Hight Server Latency)
	// 		if(check_url_status($url) && check_image_size($url) ) {
	// 			return $url;
	// 		}
	// 		else {
	// 			global $post;
	// 			$category = get_the_category(); 

	// 			if( !empty($category) ) {
	// 				$option_postfix = preg_replace('/\-+/', '_', strtolower($category[0]->slug));
	// 				$option = get_option('wdss_featured_images_list_' . $option_postfix, '');

	// 				if( $option ) {
	// 						$images_ids_arr = explode(',', $option);
	// 						$rand_index = array_rand($images_ids_arr);
	// 						$image_id = intval($images_ids_arr[$rand_index]);
	// 						set_post_thumbnail($post->ID, $image_id);
	// 				}
	// 			}



	// Get Posts Modal window
	public function wdss_get_posts_modal() {
		check_ajax_referer( 'broken-featured-images-nonce', 'security', false );
		$args = array(
			'post_type' => 'post',
			'post_status' => 'any',
			'posts_per_page' => -1,
			'orderby' => 'date', 
			'cat' => 1, // temp
			'order' => 'DESC', 
		);
		$loop = new WP_Query( $args );
	?>
		<div id="exclude-posts-modal" class="wdss-modal">
			<div class="wdss-modal-header">
				<i class="fas fa-times"></i>
			</div>
			<div class="wdss-modal-body">
				<div class="wdss-table-wrapper">
					<table id="wdss-exclude-posts-table" class="wdss-table">
						<tr class="wdss-table-row header">
							<th class="wdss-table-post__select"></th>
							<th class="wdss-table-post__id">ID</th>
							<th class="wdss-table-post__title">Title</th>
							<th class="wdss-table-post__status">Status</th>
							<th class="wdss-table-post__date">Date</th>
						</tr>
			<?php
				if ( $loop->have_posts() ) :
				while ( $loop->have_posts() ) : $loop->the_post();

				if( has_post_thumbnail() ) {
					$thumbnail_url = get_the_post_thumbnail_url();
					$is_broken = !check_url_status($thumbnail_url);

					if( !$is_broken ) {
			?>
						<tr class="wdss-table-row post">
							<td class="wdss-table-post__select"><input type="checkbox" value="<?= get_the_id();?>"></td>
							<td><?= get_the_id();?></td>
							<td><?= get_the_title();?></td>
							<td><?= get_post_status();?></td>
							<td><?= get_the_date();?></td>				
						</tr>
			<?php
					}
				}
				endwhile;
				endif;
				wp_reset_postdata();
			?> 
		</table>
				</div>
			</div>
			<div class="wdss-modal-footer">
				<button type="button" class="wdss-button toggle-all">Toggle All</button>
				<button type="button" class="wdss-button submit">Execute</button>
			</div>
		</div>
		<?php
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
				'broken-featured-images-nonce' => wp_create_nonce( 'broken_featured_images_nonce' ),
				'e410_dictionary_nonce' => wp_create_nonce( 'e410-dictionary-nonce' ),
				'excluded_hosts_dictionary_nonce' => wp_create_nonce( 'excluded-hosts-dictionary-nonce' ),				
			];
			wp_localize_script( $this->plugin_name, 'wdss_localize', $wdss_localize_script );
		}
	}
}

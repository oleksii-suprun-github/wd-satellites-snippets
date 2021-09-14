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

// Includes Admin Panel Options List
require_once('options/wd-satellites-snippets-admin-options.php');


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

    $options = new Wd_Satellites_Snippets_Admin_Options();
		$options->wdss_snippets();
    if( get_option('wdss_last_modified_n_304', '0') ) {
      $options->wdss_last_modified();
    }

		add_action( 'wp_ajax_fetch_modal_content',  array($this, 'wdss_get_posts_modal') );
		add_action( 'wp_ajax_nopriv_fetch_modal_content',  array($this, 'wdss_get_posts_modal') );
	}


	// Add Admin Menu
	public function wdss_admin_menu() {
		add_options_page('WD Satellite Settings', 'WD Satellite', 'manage_options', 'wd-sattelites-snippets', 'wdss_settings_template', null, 100 );
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
	public function wdss_enqueue_styles() {
    wp_enqueue_style('font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome/css/all.min.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wd-satellites-snippets-admin.css', array(), $this->version, 'all' );
	}


	// Get Posts Modal window
	public function wdss_get_posts_modal() {
		// verifies the AJAX request
		check_ajax_referer( 'ajax-nonce', 'security' );
		// Get post id from script
		$post_id = $_POST['post_id'];
		// Arguments for query
		$args = array(
			'post_type' => 'post',
			'post_status' => 'any',
			'numberposts' => -1,
			'orderby' => 'date', 
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
				?>
				<tr class="wdss-table-row post">
					<td class="wdss-table-post__select"><input type="checkbox" value="<?= get_the_id();?>"></td>
					<td><?= get_the_id();?></td>
					<td><?= get_the_title();?></td>
					<td><?= get_post_status();?></td>
					<td><?= get_the_date();?></td>				
				</tr>
				<?php
			endwhile;
		endif;
		wp_reset_postdata();
	?> 
		</table>
				</div>
			</div>
			<div class="wdss-modal-footer">
				<button type="button" class="wdss-button submit">Save</button>
			</div>
		</div>
	<?php
	die();
	}


	//Register the JavaScript for the admin area
	public function wdss_enqueue_scripts($page) {
		if( get_current_screen()->id == 'settings_page_wd-sattelites-snippets' ) {
			wp_enqueue_media();
		
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/main.js', array(), $this->version, true );
			
			$get_title_separator = '';
			if(function_exists('YoastSEO') && YoastSEO()->helpers->options->get_title_separator() !== null) {
				$get_title_separator = YoastSEO()->helpers->options->get_title_separator();
			}

			$wdss_localize_script = [
				'site_title' => $get_title_separator . ' ' . get_bloginfo('name'),
				'total_post_count' => wp_count_posts('post')->publish,
				'is_polylang_exists' => function_exists('pll_languages_list'),
				'url' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'ajax-nonce' )
			];
			wp_localize_script($this->plugin_name, 'wdss_localize', $wdss_localize_script);
		}
	}
}

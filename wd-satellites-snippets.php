<?php
/**
 * Plugin Name: WD Satellite 
 * Plugin URI: https://github.com/Mironezes/wd-satellites-snippets
 * Description: Bulk of usefull snippets & tweaks for satellites.
 * Version: 1.3.5
 * GitHub Plugin URI: https://github.com/Mironezes/wd-satellites-snippets
 * Primary Branch: realise
 * Author: Alexey Suprun
 * Author URI: https://github.com/Mironezes
 * Requires at least: 5.5
 * Requires PHP: 7.0
 * Tested up to: 5.8.2
 * License: GPL-2.0+
 * Text Domain: wd-satellites-snippets
 * Domain Path: /languages
 * 
 * @link https://github.com/Mironezes
 * @package Wd_Satellites
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WD_SATELLITES_SNIPPETS_VERSION', '1.3.5' );
define( 'PREFIX', 'wdss' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wd-satellites-snippets-activator.php
 */
function activate_wd_satellites_snippets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wd-satellites-snippets-activator.php';
	Wd_Satellites_Snippets_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wd-satellites-snippets-deactivator.php
 */
function deactivate_wd_satellites_snippets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wd-satellites-snippets-deactivator.php';
	Wd_Satellites_Snippets_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wd_satellites_snippets' );
register_deactivation_hook( __FILE__, 'deactivate_wd_satellites_snippets' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wd-satellites-snippets.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 *
 */
function run_wd_satellites() {

	$plugin = new Wd_Satellites();
	$plugin->run();

}
run_wd_satellites();

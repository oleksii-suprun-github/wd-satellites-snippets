<?php
/**
 * Plugin Name: WD Sattelites Snippets
 * Description: Bulk of usefull snippets for our sattelites.
 * Version: 0.5.1
 * Author: Alexey Suprun
 * Author URI: https://github.com/Mironezes
 * License: GPL3
 * Text Domain: wdss
 * Domain Path: /languages
 *
 * @package wd-satellites-snippets
*/

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WD_SATELLITES_SNIPPETS_VERSION', '0.5.1' );

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
function run_wd_satellites_snippets() {

	$plugin = new Wd_Satellites_Snippets();
	$plugin->run();

}
run_wd_satellites_snippets();

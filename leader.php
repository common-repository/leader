<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.leader.codes
 * @since             1.0.0
 * @package           Leader
 *
 * @wordpress-plugin
 * Plugin Name:       Leader
 * Plugin URI:        https://www.leader.codes/
 * Description:       Leader - lead capture tool that work for you.
 * Version:           2.6.1
 * Author:            Ram Segev
 * Author URI:        https://www.leader.codes
 * License:           GPLv3+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       leader
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-leader-activator.php
 */
function activate_leader() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-leader-activator.php';
	Leader_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-leader-deactivator.php
 */
function deactivate_leader() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-leader-deactivator.php';
	Leader_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_leader' );
register_deactivation_hook( __FILE__, 'deactivate_leader' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-leader.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_leader() {

	$plugin = new Leader();
	$plugin->run();

}
run_leader();

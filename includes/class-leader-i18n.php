<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://leader.codes
 * @since      1.0.0
 *
 * @package    Leader
 * @subpackage Leader/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Leader
 * @subpackage Leader/includes
 * @author     Ram Segev<ramsegeb@gmail.com>
 */
class Leader_i18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function lr_load_plugin_textdomain() {
		delete_option( 'lr_fields' );
		$path = dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/';
		load_plugin_textdomain(
			'leader',
			false,
			$path
		);
	}
}
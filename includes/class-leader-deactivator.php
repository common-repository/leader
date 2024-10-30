<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://leader.codes
 * @since      1.0.0
 *
 * @package    Leader
 * @subpackage Leader/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Leader
 * @subpackage Leader/includes
 * @author     Ram Segev<ramsegeb@gmail.com>
 */
class Leader_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option( 'lr_fields' );		
	}

}

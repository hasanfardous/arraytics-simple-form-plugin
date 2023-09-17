<?php

/**
 * Plugin Name:       Arraytics Simple Form Plugin
 * Plugin URI:        https://github.com/hasanfardous/arraytics-simple-form-plugin
 * Description:       A simple form plugin to collect data through the form also showing data in a table. The plugin provides two different shortcodes for displaying a submission form and report table. All submissions data are available for logged in users.
 * Version:           1.0.0
 * Requires at least: 5.5
 * Requires PHP:      7.2
 * Author:            Hasan Fardous
 * Author URI:        https://me.hasanfardous.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       arraytics-simple-form-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Defining Plugin Constants
define( 'ARRAYTICS_SIMPLE_FORM_PLUGIN_VERSION', '1.0.0' );
define( 'ARRAYTICS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ARRAYTICS_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'ARRAYTICS_PLUGIN_INC_DIR', ARRAYTICS_PLUGIN_DIR . 'includes/' );
define( 'ARRAYTICS_PLUGIN_ASSETS_URL', ARRAYTICS_PLUGIN_DIR_URL . 'assets/' );

// Load Plugin Text Domain
function asfp_load_textdomain() {
	load_plugin_textdomain( 'arraytics-simple-form-plugin', false, dirname( __FILE__ ) . "/languages" );
}

add_action( "plugins_loaded", "asfp_load_textdomain" );

// Including plugin files
require ARRAYTICS_PLUGIN_INC_DIR . 'enqueue-assets.php';
require ARRAYTICS_PLUGIN_INC_DIR . 'form-shortcode.php';
require ARRAYTICS_PLUGIN_INC_DIR . 'form-handling.php';
require ARRAYTICS_PLUGIN_INC_DIR . 'class-all-reports.php';
require ARRAYTICS_PLUGIN_INC_DIR . 'report-page.php';

// Load Admin page
require ARRAYTICS_PLUGIN_INC_DIR . 'admin/admin-menu-page.php';

// The code that runs during plugin activation
register_activation_hook( __FILE__, 'asfp_create_db_table_func' );
if ( ! function_exists( 'asfp_create_db_table_func' ) ) {
	function asfp_create_db_table_func() {
		// Saving our plugin current version
		add_option( "asfp_current_version", ARRAYTICS_SIMPLE_FORM_PLUGIN_VERSION );
		
		// Create the table
		require ARRAYTICS_PLUGIN_INC_DIR . 'create-submission-table.php';

		// Making the DB table
		asfp_create_db_table();
	}
}

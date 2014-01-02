<?php
/*
Plugin Name: SO Multisite Dashboard Feed Widget
Plugin URI: https://github.com/so-wp/so-multisite-dashboard-feed-widget
Description: This dashboard widget shows the latest Posts from the main site of a multisite install in the top of the Dashboard of the sites hanging under the multisite install.
Version: 2014.01.02
Author: Piet Bos
Author URI: http://senlinonline.com
Text Domain: multisite-dashboard-feed-widget
Domain Path: /languages
Network: true
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*  Copyright 2013  Piet Bos  (email: piet@senlinonline.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// For debugging purposes
//error_reporting(E_ALL);
//ini_set("display_errors", 1); 
//define('WP-DEBUG', true);

/* Prevent direct access to files */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Version check; any WP version under 3.6 is not supported (if only to "force" users to stay up to date)
 * 
 * adapted from example by Thomas Scholz (@toscho) http://wordpress.stackexchange.com/a/95183/2015, Version: 2013.03.31, Licence: MIT (http://opensource.org/licenses/MIT)
 *
 * @since 1.4.0
 */

//Only do this when on the Plugins page.
if ( ! empty ( $GLOBALS['pagenow'] ) &&  network_admin_url( 'plugins.php' ) === $GLOBALS['pagenow'] )
	add_action( 'admin_notices', 'so_msdbfeed_check_admin_notices', 0 );

function so_msdbfeed_min_wp_version() {
	global $wp_version;
	$require_wp = '3.6';
	$update_url = network_admin_url( 'update-core.php' );

	$errors = array();

	if ( version_compare( $wp_version, $require_wp, '<' ) ) 

		$errors[] = "You have WordPress version $wp_version installed, but <b>this plugin requires at least WordPress $require_wp</b>. Please <a href='$update_url'>update your WordPress version</a>.";

	return $errors;
}

function so_msdbfeed_check_admin_notices() {
	
	$errors = so_msdbfeed_min_wp_version();

	if ( empty ( $errors ) )
		return;

	// Suppress "Plugin activated" notice.
	unset( $_GET['activate'] );

	// this plugin's name
	$name = get_file_data( __FILE__, array ( 'Plugin Name' ), 'plugin' );

	printf( __( '<div class="error"><p>%1$s</p><p><i>%2$s</i> has been deactivated.</p></div>', 'multisite-dashboard-feed-widget' ),
		join( '</p><p>', $errors ),
		$name[0]
	);
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

/**
 * Rewrite of the plugin
 *
 * @since 2014.01.02
 */
class SO_MSDBFEED_Load {
	
	function __construct() {

		global $so_msdbfeed;

		/* Set up an empty class for the global $so_msdbfeed object. */
		$so_msdbfeed = new stdClass;

		/* Set the init. */
		add_action( 'admin_init', array( &$this, 'init' ), 1 );

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 2 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( &$this, 'i18n' ), 3 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 4 );

		/* Load the admin files. */
		add_action( 'plugins_loaded', array( &$this, 'admin' ), 5 );

	}
	
	/**
	 * Init plugin options to white list our options
	 *
	 * @since 2014.01.02
	 */
	function init() {
		
		register_setting( 'so_msdbfeed_plugin_options', 'so_msdbfeed_options', 'so_msdbfeed_validate_options' );
		
	}


	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 2014.01.02
	 */
	function constants() {

		/* Set the version number of the plugin. */
		define( 'SO_MSDBFEED_VERSION', '2014.01.02' );

		/* Set constant path to the plugin directory. */
		define( 'SO_MSDBFEED_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Set constant path to the plugin URL. */
		define( 'SO_MSDBFEED_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		/* Set the constant path to the inc directory. */
		define( 'SO_MSDBFEED_INCLUDES', SO_MSDBFEED_DIR . trailingslashit( 'inc' ) );

		/* Set the constant path to the admin directory. */
		define( 'SO_MSDBFEED_ADMIN', SO_MSDBFEED_DIR . trailingslashit( 'admin' ) );

	}

	/**
	 * Loads the translation file.
	 *
	 * @since 2014.01.02
	 */
	function i18n() {

		/* Load the translation of the plugin. */
		load_plugin_textdomain( 'multisite-dashboard-feed-widget', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since 2014.01.02
	 */
	function includes() {

		/* Load the plugin functions file. */
		require_once( SO_MSDBFEED_INCLUDES . 'functions.php' );
	}

	/**
	 * Loads the admin functions and files.
	 *
	 * @since 2014.01.02
	 */
	function admin() {

		/* Only load files if in the WordPress admin. */
		if ( is_admin() ) {

			/* Load the main admin file. */
			require_once( SO_MSDBFEED_ADMIN . 'settings.php' );

		}
	}

}

$so_msdbfeed_load = new SO_MSDBFEED_Load();

/**
 * Register activation/deactivation hooks
 * @since 2014.01.02
 */
register_activation_hook( __FILE__, 'so_msdbfeed_add_defaults' ); 
register_deactivation_hook( __FILE__, 'so_msdbfeed_delete_plugin_options' );

add_action( 'admin_menu', 'so_msdbfeed_add_options_page' );

function so_msdbfeed_add_options_page() {
	// Add the new admin menu and page and save the returned hook suffix
	$hook = add_options_page( 'SO Multisite Dashboard Feed Widget Settings', 'SO Multisite Dashboard Feed Widget', 'manage_options', __FILE__, 'so_msdbfeed_render_form' );
	// Use the hook suffix to compose the hook and register an action executed when plugin's options page is loaded
	add_action( 'admin_print_styles-' . $hook , 'so_msdbfeed_load_settings_style' );
}


/**
 * Define default option settings
 * @since 2014.01.02
 */
function so_msdbfeed_add_defaults() {
	
	$tmp = get_option( 'so_msdbfeed_options' );
	
	if ( ( $tmp['chk_default_options_db'] == '1' ) || ( ! is_array( $tmp ) ) ) {
		
		delete_option( 'so_msdbfeed_options' ); // so we don't have to reset all the 'off' checkboxes too! (don't think this is needed but leave for now)
		
		$arr = array(
			'widget_title' => __( 'Recent Updates', 'multisite-dashboard-feed-widget' ),
			'feed_url' => 'http://wpti.ps/feed/',
			'drp_select_box' => '3',
			'widget_bkgr' => 'FF9',
			'chk_default_options_db' => ''
		);
		
		update_option( 'so_msdbfeed_options', $arr );
	}
}

/**
 * Delete options table entries ONLY when plugin deactivated AND deleted 
 * @since 2014.01.02
 */
function so_msdbfeed_delete_plugin_options() {
	
	delete_option( 'so_msdbfeed_options' );

}

/**
 * Register and enqueue the settings stylesheet
 * @since 2014.01.02
 */
function so_msdbfeed_load_settings_style() {

	wp_register_style( 'custom_so_msdbfeed_settings_css', SO_MSDBFEED_URI . 'css/settings.css', false, SO_MSDBFEED_VERSION );

	wp_enqueue_style( 'custom_so_msdbfeed_settings_css' );

}

/**
 * Set-up Action and Filter Hooks
 * @since 2014.01.02
 */
add_filter( 'plugin_action_links', 'so_msdbfeed_plugin_action_links', 10, 2 );

add_action( 'wp_dashboard_setup', 'so_msdbfeed_setup_function' ); // Register the new dashboard widget into the 'wp_dashboard_setup' action

add_action( 'admin_enqueue_scripts', 'so_msdbfeed_load_custom_admin_style' );


/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 * @since 2014.01.02
 */
function so_msdbfeed_validate_options($input) {
	// strip html from textboxes
	$input['widget_title'] =  wp_filter_nohtml_kses( $input['widget_title'] ); // Sanitize input (strip html tags, and escape characters)
	$input['feed_url'] =  wp_filter_nohtml_kses( $input['feed_url'] ); // Sanitize input (strip html tags, and escape characters)
	$input['widget_bkgr'] =  wp_filter_nohtml_kses( $input['widget_bkgr'] ); // Sanitize input (strip html tags, and escape characters)
	return $input;
}

/**
 * Display a Settings link on the main Plugins page
 */
function so_msdbfeed_plugin_action_links( $links, $file ) {

	if ( $file == plugin_basename( __FILE__ ) ) {
		$so_msdbfeed_links = '<a href="' . get_network_admin_url( 'settings.php?page=multisite-dashboard-feed-widget/msdbfeed.php' ) . '">' . __( 'Settings', 'multisite-dashboard-feed-widget' ) . '</a>';
		// make the 'Settings' link appear first
		array_unshift( $links, $so_msdbfeed_links );
	}

	return $links;
}


/**
 * Register and enqueue the admin stylesheet
 * @since 2014.01.02
 */
function so_msdbfeed_load_custom_admin_style( $hook ) {
    if( 'index.php' != $hook )
    	return;
	wp_register_style( 'custom_so_msdbfeed_admin_css', SO_MSDBFEED_URI . 'css/style.css', false, SO_MSDBFEED_VERSION );
	wp_enqueue_style( 'custom_so_msdbfeed_admin_css' );
}

/** The End **/
?>
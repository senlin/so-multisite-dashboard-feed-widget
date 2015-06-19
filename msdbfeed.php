<?php
/*
Plugin Name: Multisite Dashboard Feed Widget
Plugin URI: http://so-wp.com/?p=14
Description: This dashboard widget shows the latest Posts from the main site of a multisite install in the top of the Dashboard of the sites hanging under the multisite install.
Version: 1.5.3
Author: Piet Bos
Author URI: http://senlinonline.com
License: GPLv2 or later
*/

/*  Copyright 2012-2015  Piet Bos  (email : piet@so-wp.com)

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
 * Version check; any WP version under $require_wp is not supported (if only to "force" users to stay up to date)
 * 
 * adapted from example by Thomas Scholz (@toscho) http://wordpress.stackexchange.com/a/95183/2015, Version: 2013.03.31, Licence: MIT (http://opensource.org/licenses/MIT)
 *
 * @since 1.4.0
 */

//Only do this when on the Plugins page.
if ( ! empty ( $GLOBALS['pagenow'] ) && 'plugins.php' === $GLOBALS['pagenow'] )
	add_action( 'admin_notices', 'msdbfeed_check_admin_notices', 0 );

function msdbfeed_min_wp_version() {
	global $wp_version;
	$require_wp = '4.0';
	$update_url = get_admin_url( null, 'update-core.php' );

	$errors = array();

	if ( version_compare( $wp_version, $require_wp, '<' ) ) 

		$errors[] = "You have WordPress version $wp_version installed, but <b>this plugin requires at least WordPress $require_wp</b>. Please <a href='$update_url'>update your WordPress version</a>.";

	return $errors;
}

function msdbfeed_check_admin_notices()
{
	$errors = msdbfeed_min_wp_version();

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
 * Set-up Action and Filter Hooks
 * 
 * @since 1.4.0
 */
add_action( 'plugins_loaded', 'msdbfeed_i18n' );

// Register the new dashboard widget into the 'wp_dashboard_setup' action 
add_action( 'wp_dashboard_setup', 'msdbfeed_setup_function' );

// Adds admin stylesheet
add_action( 'admin_print_styles', 'msdbfeed_load_custom_admin_css' );

/**
 * Loads the translation files.
 *
 * @since 1.0
 */
function msdbfeed_i18n() {

	/* Load the translation of the plugin. */
	load_plugin_textdomain( 'msdbfeed', false, basename( dirname( __FILE__ ) ) . '/languages' );

}

/**
 * Loads the dashboard widget.
 *
 * @since 1.0
 */
function msdbfeed_setup_function() {
	
	add_meta_box( 'msdbfeed_widget', __( 'Recent Updates', 'multisite-dashboard-feed-widget' ), 'msdbfeed_widget_function', 'dashboard', 'normal', 'high' );
}

function msdbfeed_widget_function() {
    include ('msrss.php');
}

// The load CSS function
function msdbfeed_load_custom_admin_css() {
	wp_enqueue_style( 'msdbfeed_custom_admin_css', plugins_url( '/style.css', __FILE__ ) );
}

/*** THE END ***/
?>
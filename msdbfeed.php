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

function so_msdbfeed_check_admin_notices()
{
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

		/* Set up an empty class for the global $so_dbfw object. */
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
		define( 'SO_MSDBFEED_VERSION', '2013.12.28' );

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
 * Set-up Action and Filter Hooks
 * 
 * @since 1.4.0
 */
register_activation_hook( __FILE__, 'msdbfeed_add_defaults' );

register_uninstall_hook( __FILE__, 'msdbfeed_delete_plugin_options' );

add_action( 'admin_init', 'msdbfeed_init' );

add_action( 'plugins_loaded', 'msdbfeed_i18n' );

add_action( 'admin_menu', 'msdbfeed_add_options_page' );

add_filter( 'plugin_action_links', 'msdbfeed_plugin_action_links', 10, 2 );

/**
 * Delete options table entries ONLY when plugin deactivated AND deleted
 * 
 * @since 1.4.0
 */
function msdbfeed_delete_plugin_options() {
	
	delete_option( 'msdbfeed_options' );

}

/**
 * Define default option settings
 * 
 * @since 1.4.0
 */
function msdbfeed_add_defaults() {
	
	$tmp = get_option( 'msdbfeed_options' );
	
	if ( ( ! is_array( $tmp ) ) ) {
		
		$arr = array(
			'widget_title' => __( 'Recent Updates', 'multisite-dashboard-feed-widget' ),
			'drp_select_box' => '3',
		);
		
		update_option( 'msdbfeed_options', $arr );
	}
}

/**
 * Init plugin options to white list our options
 * 
 * @since 1.4.0
 */
function msdbfeed_init() {
	
	register_setting( 'msdbfeed_plugin_options', 'msdbfeed_options', 'msdbfeed_validate_options' );
	
}

/**
 * Loads the translation files.
 *
 * @since 1.0
 */
function msdbfeed_i18n() {

	/* Load the translation of the plugin. */
	load_plugin_textdomain( 'multisite-dashboard-feed-widget', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}


/**
 * Add menu page
 * 
 * @since 1.4.0
 */
function msdbfeed_add_options_page() {
	
	add_options_page( 'SO Multisite Dashboard Feed Widget Settings', 'SO Multisite Dashboard Feed Widget Settings', 'manage_options', __FILE__, 'msdbfeed_render_form' );

}

/**
 * Render the Plugin options form
 * 
 * @since 1.4.0
 */
function msdbfeed_render_form() { ?>

	<div class="wrap">
		
		<!-- Display Plugin Icon, Header, and Description -->
		<div class="icon32" id="icon-options-general"></div>
		
		<h2><?php _e( 'SO Multisite Dashboard Feed Widget Settings', 'multisite-dashboard-feed-widget' ); ?></h2>
		
		<p><?php _e( 'Below you can adjust the output of the SO Multisite Dashboard Feed Widget Settings. You can change the title of the widget and the amount of feed items to show.', 'multisite-dashboard-feed-widget' ); ?></p>

		<!-- Beginning of the Plugin Options Form -->
		<form method="post" action="options.php">
			
			<?php settings_fields( 'msdbfeed_plugin_options' ); ?>
			
			<?php $options = get_option( 'msdbfeed_options' ); ?>

			<!-- Table Structure Containing Form Controls -->
			<!-- Each Plugin Option Defined on a New Table Row -->
			
			<table class="form-table">

				<!-- Textbox Control -->
				<tr>
					<th scope="row"><?php _e( 'Widget Title', 'multisite-dashboard-feed-widget' ); ?></th>
					<td>
						<input type="text" size="57" name="msdbfeed_options[widget_title]" value="<?php echo $options['widget_title']; ?>" /><br />
						<span style="color: #666; margin-left: 2px;">
							<?php _e( 'Change the title of the SO Multisite Dashboard Feed Widget into something of your liking', 'multisite-dashboard-feed-widget' ); ?>
						</span>
					</td>
				</tr>

				<!-- Select Drop-Down Control -->
				<tr>
					<th scope="row"><?php _e( 'How many Feed Items to show in the SO Multisite Dashboard Feed Widget', 'multisite-dashboard-feed-widget' ); ?></th>
					<td>
						<select name='msdbfeed_options[drp_select_box]'>
							<option value='1' <?php selected( '1', $options['drp_select_box'] ); ?>>1</option>
							<option value='2' <?php selected( '2', $options['drp_select_box'] ); ?>>2</option>
							<option value='3' <?php selected( '3', $options['drp_select_box'] ); ?>>3</option>
							<option value='4' <?php selected( '4', $options['drp_select_box'] ); ?>>4</option>
							<option value='5' <?php selected( '5', $options['drp_select_box'] ); ?>>5</option>
							<option value='6' <?php selected( '6', $options['drp_select_box'] ); ?>>6</option>
							<option value='7' <?php selected( '7', $options['drp_select_box'] ); ?>>7</option>
							<option value='8' <?php selected( '8', $options['drp_select_box'] ); ?>>8</option>
							<option value='9' <?php selected( '9', $options['drp_select_box'] ); ?>>9</option>
							<option value='10' <?php selected( '10', $options['drp_select_box'] ); ?>>10</option>
						</select>
						<span style="color: #666; margin-left: 2px;">
							<?php _e( 'How many feed items to show in the widget?', 'multisite-dashboard-feed-widget' ); ?>
						</span>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<div style="margin-top: 10px;"></div>
					</td>
				</tr>
			
			</table>
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'multisite-dashboard-feed-widget' ) ?>" />
			</p>
		
		</form>

		<p style="font-style: italic; font-weight: bold; color: #26779A;">
			
			<?php
			/* Translators: 1 is link to WP Repo */
			printf( __( 'If you have found this plugin at all useful, please give it a favourable rating in the <a href="%s" title="Rate this plugin!">WordPress Plugin Repository</a>.', 'multisite-dashboard-feed-widget' ), 
				esc_url( 'http://wordpress.org/plugins/multisite-dashboard-feed-widget/' )
			);
			?>
			
		</p>
		
		<div class="postbox" style="display: block; float: left; width: 500px; margin: 30px 10px 10px 0;">
			
			<h3 class="hndle" style="padding: 5px;">
				<span><?php _e( 'About the Author', 'multisite-dashboard-feed-widget' ); ?></span>
			</h3>
			
			<div class="inside">
				<img src="http://www.gravatar.com/avatar/<?php echo md5( 'info@senlinonline.com' ); ?>" style="float: left; margin-right: 10px; padding: 3px; border: 1px solid #DFDFDF;"/>
				<p style="height: 60px; padding-top: 20px">
					<?php printf( __( 'Hi, my name is Piet Bos, I hope you like this plugin! Please check out any of my other plugins on <a href="%s" title="SO WP Plugins">SO WP Plugins</a>. You can find out more information about me via the following links:', 'multisite-dashboard-feed-widget' ),
					esc_url( 'http://so-wp.github.io/' )
					); ?>
				</p>
				
				<ul style="clear: both; margin-top: 20px;">
					<li><a href="http://senlinonline.com/" target="_blank" title="Senlin Online"><?php _e('Senlin Online', 'multisite-dashboard-feed-widget'); ?></a></li>
					<li><a href="http://wpti.ps/" target="_blank" title="WP TIPS"><?php _e('WP Tips', 'multisite-dashboard-feed-widget'); ?></a></li>
					<li><a href="https://plus.google.com/+PietBos" target="_blank" title="Piet on Google+"><?php _e( 'Google+', 'multisite-dashboard-feed-widget' ); ?></a></li>
					<li><a href="http://cn.linkedin.com/in/pietbos" target="_blank" title="LinkedIn profile"><?php _e( 'LinkedIn', 'multisite-dashboard-feed-widget' ); ?></a></li>
					<li><a href="http://twitter.com/SenlinOnline" target="_blank" title="Twitter"><?php _e( 'Twitter: @piethfbos', 'multisite-dashboard-feed-widget' ); ?></a></li>
					<li><a href="http://github.com/senlin" title="on Github"><?php _e( 'Github', 'multisite-dashboard-feed-widget' ); ?></a></li>
					<li><a href="http://profiles.wordpress.org/senlin/" title="on WordPress.org"><?php _e( 'WordPress.org Profile', 'multisite-dashboard-feed-widget' ); ?></a></li>
				</ul>
			
			</div> <!-- end .inside -->
		
		</div> <!-- end .postbox -->

	</div> <!-- end .wrap -->

<?php }

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 * 
 * @since 1.4.0
 */
function msdbfeed_validate_options($input) {
	// strip html from textboxes
	$input['widget_title'] =  wp_filter_nohtml_kses( $input['widget_title'] ); // Sanitize input (strip html tags, and escape characters)
	return $input;
}

/**
 * Display a Settings link on the main Plugins page
 * 
 * @since 1.4.0
 */
function msdbfeed_plugin_action_links( $links, $file ) {

	if ( $file == plugin_basename( __FILE__ ) ) {
		$msdbfeed_links = '<a href="' . get_admin_url() . 'options-general.php?page=multisite-dashboard-feed-widget/msdbfeed.php">' . __( 'Settings', 'multisite-dashboard-feed-widget' ) . '</a>';
		// make the 'Settings' link appear first
		array_unshift( $links, $msdbfeed_links );
	}

	return $links;
}

/**
 * Add Feed Dashboard Widget, finally the actual code that grabs the feed and loops through it to output it
 * 
 * @since 1.4.0
 */
function msdbfeed_setup_function() {
	$options = get_option( 'msdbfeed_options' );
	$widgettitle = $options['widget_title'];
	add_meta_box( 'msdbfeed_widget',  $widgettitle, 'msdbfeed_widget_function', 'dashboard', 'normal', 'high' );
}

function msdbfeed_widget_function() {
	$options = get_option( 'msdbfeed_options' );
	$feedurl = network_site_url('/feed/');
	$select = $options['drp_select_box'];

	/**
	 * Fetch Network Feed
	 * 
	 * @since 1.0
	 */
	$rss = fetch_feed($feedurl);
	if (!is_wp_error($rss)) { // Checks that the object is created correctly
	    // Figure out how many total items there are, but limit it to 3.
	    $maxitems = $select;
	    // Build an array of all the items, starting with element 0 (first element).
	    $rss_items = $rss->get_items(0, $maxitems);
	}
	if (!empty($maxitems)) {
	?>
		<div class="rss-widget">
	    	
	    	<ul>
	
	<?php
	    // Loop through each feed item and display each item as a hyperlink.
	    foreach ($rss_items as $item) {
	
	?>
	
				<li><a class="rsswidget" href='<?php echo $item->get_permalink(); ?>'><?php echo $item->get_title(); ?></a> <span class="rss-date"><?php echo $item->get_date('j F Y'); ?></span></li>
	
	<?php } ?>
			
			</ul>
		
		</div> <!-- end .rss-widget -->
	
	<?php
	}

	// This makes sure that the positioning is also correct for right-to-left languages
	$x = is_rtl() ? 'left' : 'right'; 
	echo '<style type="text/css">#msdbfeed_widget { float: $x; }</style>';
}


/**
 * Register the new dashboard widget into the 'wp_dashboard_setup' action
 * 
 * @since 1.0
 */
add_action( 'wp_dashboard_setup', 'msdbfeed_setup_function' );

/**
 * Adds stylesheet
 * 
 * @since 1.0
 */
add_action( 'admin_print_styles', 'msdbfeed_load_custom_admin_css' );


/**
 * And now enqueue the stylesheet
 * 
 * @since 1.0
 */
function msdbfeed_load_custom_admin_css() {
	
	wp_enqueue_style( 'msdbfeed_custom_admin_css', plugins_url( '/style.css', __FILE__ ) );

}

/** The End **/
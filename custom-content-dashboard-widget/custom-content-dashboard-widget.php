<?php
/*
Plugin Name: Custom Content Dashboard Widget
Plugin URI: http://premium.wpmudev.org/project/custom-content-dashboard-widget
Description: Easily add a widget full of custom content to user dashboards, great for help and support... or sales messages!
Author: S H Mohanjith (Incsub), Andrew Billits (Incsub)
Version: 1.6.3.1
Author URI: http://premium.wpmudev.org
WDP ID: 17
Network: true
Text Domain: custom_content_dashboard
*/

/*
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

add_action('init', 'custom_content_dashboard_init');

if (is_multisite()) {
	add_action( 'network_admin_menu', 'custom_content_dashboard_network_admin_menu' );
} else {
	add_action( 'admin_menu', 'custom_content_dashboard_admin_menu' );
}

function custom_content_dashboard_init() {
	global $contents_file;
	$contents_file = WP_PLUGIN_DIR.'/'.dirname(plugin_basename(__FILE__)).'/contents.php';

	load_plugin_textdomain('custom_content_dashboard', false, dirname(plugin_basename(__FILE__)).'/languages');

	global $custom_content_widget_title, $current_user;

        if ( !$widget_options = get_site_option( 'cc_dashboard_widget_options' ) )
		$widget_options = array();

	if ( !isset($widget_options['custom_content_dashboard']) )
                $widget_options['custom_content_dashboard'] = array();

	if ( !isset($widget_options['custom_content_dashboard']['title']) )
		$widget_options['custom_content_dashboard']['title'] = $custom_content_widget_title;

	if ( !isset($widget_options['custom_content_dashboard']['content']) )
		$widget_options['custom_content_dashboard']['content'] = custom_content_widget_content();

	if ( !isset($widget_options['custom_content_dashboard']['eval']) )
		$widget_options['custom_content_dashboard']['eval'] = 'no';

	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['custom_content_dashboard']) ) {
                $custom_content_dashboard_content = $_POST['custom_content_dashboard']['content'];
		$custom_content_dashboard_allow_override = $_POST['custom_content_dashboard']['allow_override'];
                $custom_content_dashboard_eval = $_POST['custom_content_dashboard']['eval'];
                $custom_content_dashboard_title = $_POST['custom_content_dashboard']['title'];
                $new_widget_options['custom_content_dashboard']['content'] = $custom_content_dashboard_content;
                $new_widget_options['custom_content_dashboard']['allow_override'] = $custom_content_dashboard_allow_override;
		$new_widget_options['custom_content_dashboard']['eval'] = $custom_content_dashboard_eval;
		$new_widget_options['custom_content_dashboard']['title'] = strip_tags($custom_content_dashboard_title);
		if (is_multisite()) {
			update_site_option( 'cc_dashboard_widget_options', $new_widget_options );
			wp_redirect('settings.php?page=custom_content_dashboard&updated=true');
		} else {
			update_option( 'cc_dashboard_widget_options', $new_widget_options );
			wp_redirect('options-general.php?page=custom_content_dashboard&updated=true');
		}

        }
}

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//
$custom_content_widget_title = __('Custom Content', 'custom_content_dashboard');
function custom_content_widget_content() {
	global $contents_file;

	if ( (!$widget_options = get_site_option( 'cc_dashboard_widget_options', false ))) {
		$widget_options = array();
	}
	if ( isset($widget_options['custom_content_dashboard']['allow_override']) &&
	     $widget_options['custom_content_dashboard']['allow_override'] == 'yes') {
		$my_widget_options = get_option( 'my_dashboard_widget_options', false );
		if ( $my_widget_options ) {
			$widget_options = $my_widget_options;
		}
	}

	if ( !isset($widget_options['custom_content_dashboard']) )
                $widget_options['custom_content_dashboard'] = array();

	if ( !isset($widget_options['custom_content_dashboard']['content']) )
		$widget_options['custom_content_dashboard']['content'] = '<!--- custom content goes here ---> Test';

	if ( !isset($widget_options['custom_content_dashboard']['eval']) )
		$widget_options['custom_content_dashboard']['eval'] = 'no';

	if (file_exists($contents_file)) {
                return file_get_contents($contents_file);
        }

	if (isset($widget_options['custom_content_dashboard']) && isset($widget_options['custom_content_dashboard']['content']) &&
		!empty($widget_options['custom_content_dashboard']['content'])) {
		if ($widget_options['custom_content_dashboard']['eval'] == 'yes') {
			eval(stripcslashes($widget_options['custom_content_dashboard']['content']));
		} else {
			return stripcslashes($widget_options['custom_content_dashboard']['content']);
		}
	}
}
//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action( 'wp_dashboard_setup', 'custom_content_dashboard_widget' );
add_action( 'wp_user_dashboard_setup', 'custom_content_dashboard_widget' );
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function custom_content_dashboard_network_admin_menu() {
	global $contents_file;
	if (file_exists($contents_file))
		return;
	add_submenu_page( 'settings.php', __('Custom Dashboard Widget', 'custom_content_dashboard'),  __('Dashboard Widget', 'custom_content_dashboard'), 'manage_site_options', 'custom_content_dashboard', 'custom_content_dashboard_settings');	     	 	   		  		
}

function custom_content_dashboard_admin_menu() {
	global $contents_file;
	if (file_exists($contents_file))
		return;
	add_options_page( __('Custom Dashboard Widget', 'custom_content_dashboard'),  __('Dashboard Widget', 'custom_content_dashboard'), 'manage_options', 'custom_content_dashboard', 'custom_content_dashboard_settings');
}

function custom_content_dashboard_widget() {
	global $custom_content_widget_title, $contents_file;

	if ( (!$widget_options = get_site_option( 'cc_dashboard_widget_options', false ))) {
		$widget_options = array();
	}
	if ( isset($widget_options['custom_content_dashboard']['allow_override']) &&
	    $widget_options['custom_content_dashboard']['allow_override'] == 'yes') {
		$my_widget_options = get_option( 'my_dashboard_widget_options', false );
		if ( $my_widget_options ) {
			$widget_options = $my_widget_options;
		}
	}

	if ( !isset($widget_options['custom_content_dashboard']) )
                $widget_options['custom_content_dashboard'] = array();

	if ( !isset($widget_options['custom_content_dashboard']['title']) )
		$widget_options['custom_content_dashboard']['title'] = $custom_content_widget_title;

	if ( !isset($widget_options['custom_content_dashboard']['allow_override']) )
		$widget_options['custom_content_dashboard']['eval'] = 'yes';

	if (file_exists($contents_file) || $widget_options['custom_content_dashboard']['allow_override'] == 'no') {
		wp_add_dashboard_widget( 'custom_content_dashboard_widget', __( $widget_options['custom_content_dashboard']['title'] , 'custom_content_dashboard'), 'wp_dashboard_custom_content' );
	} else {
		wp_add_dashboard_widget( 'custom_content_dashboard_widget', __( $widget_options['custom_content_dashboard']['title'] , 'custom_content_dashboard'), 'wp_dashboard_custom_content', 'wp_dashboard_custom_control' );
	}
}
//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function wp_dashboard_custom_content( ) {
	echo custom_content_widget_content();
}

function custom_content_dashboard_settings() {
	global $custom_content_widget_title, $current_user;

        if ( !$widget_options = get_site_option( 'cc_dashboard_widget_options' ) )
		$widget_options = array();

	if ( !isset($widget_options['custom_content_dashboard']) )
                $widget_options['custom_content_dashboard'] = array();

	if ( !isset($widget_options['custom_content_dashboard']['allow_override']) )
		$widget_options['custom_content_dashboard']['allow_override'] = 'yes';

	if ( !isset($widget_options['custom_content_dashboard']['title']) )
		$widget_options['custom_content_dashboard']['title'] = $custom_content_widget_title;

	if ( !isset($widget_options['custom_content_dashboard']['content']) )
		$widget_options['custom_content_dashboard']['content'] = custom_content_widget_content();

	if ( !isset($widget_options['custom_content_dashboard']['eval']) )
		$widget_options['custom_content_dashboard']['eval'] = 'no';

	$current_user = wp_get_current_user();

	$custom_content_dashboard_content = stripcslashes($widget_options['custom_content_dashboard']['content']);

	if (!is_multisite() || $current_user->has_cap('manage_site_options')) {
		echo '<div class="wrap">';
		echo '<h2>'.__('Custom Dashboard Widget Settings', 'custom_content_dashboard').'</h2>';
		if (is_multisite() && isset($_REQUEST['updated'])) {
			echo '<div id="message" class="updated fade" ><p>'.__('Settings saved', 'custom_content_dashboard').'</p></div>';
		}
		echo '<form method="post" action="" > ';
		echo '<p><label for="custom_content_dashboard_allow_override">' . __('Allow Site Admins to customize for their blog:', 'custom_content_dashboard') . '</label> ';
		echo '<select id="custom_content_dashboard_eval" name="custom_content_dashboard[allow_override]" rows="10" cols="62">'.
			'<option '.(($widget_options['custom_content_dashboard']['allow_override'] == 'yes')?'selected="selected"':'').' value="yes" >'.__('Yes', 'custom_content_dashboard').'</option>'.
			'<option '.(($widget_options['custom_content_dashboard']['allow_override'] == 'no')?'selected="selected"':'').' value="no" >'.__('No', 'custom_content_dashboard').'</option>'.
		      '</select></p>';
		echo '<p><label for="custom_content_dashboard_title">' . __('Title:', 'custom_content_dashboard') . '</label><br/>';
		echo '<input type="text" id="custom_content_dashboard_title" name="custom_content_dashboard[title]" size="62" value="'.$widget_options['custom_content_dashboard']['title'].'" /></p>';
		echo '<p><label for="custom_content_dashboard_content">' . __('Content:', 'custom_content_dashboard') . '</label><br/>';
		echo '<textarea id="custom_content_dashboard_content" name="custom_content_dashboard[content]" rows="10" cols="62">'.$custom_content_dashboard_content.'</textarea></p>';
		echo '<p><label for="custom_content_dashboard_eval">' . __('Execute content:', 'custom_content_dashboard') . '</label> ';
		echo '<select id="custom_content_dashboard_eval" name="custom_content_dashboard[eval]" rows="10" cols="62">'.
			'<option '.(($widget_options['custom_content_dashboard']['eval'] == 'yes')?'selected="selected"':'').' value="yes" >'.__('Yes', 'custom_content_dashboard').'</option>'.
			'<option '.(($widget_options['custom_content_dashboard']['eval'] == 'no')?'selected="selected"':'').' value="no" >'.__('No', 'custom_content_dashboard').'</option>'.
		      '</select></p>';
		echo '<p class="submit"><input class="button button-primary" type="submit" class="button default" value="'.__('Save', 'custom_content_dashboard').'" /></p>';
		echo '</form>';
		echo '</div>';
	} else {
		_e('You are not allowed to edit this widget', 'custom_content_dashboard');
	}
}

function wp_dashboard_custom_control() {
	global $custom_content_widget_title, $current_user;

	if ( !$widget_options = get_option( 'my_dashboard_widget_options', false ) )
                if ( !$widget_options = get_site_option( 'cc_dashboard_widget_options' ) )
			$widget_options = array();

	if ( !isset($widget_options['custom_content_dashboard']) )
                $widget_options['custom_content_dashboard'] = array();

	if ( !isset($widget_options['custom_content_dashboard']['title']) )
		$widget_options['custom_content_dashboard']['title'] = $custom_content_widget_title;

	if ( !isset($widget_options['custom_content_dashboard']['content']) )
		$widget_options['custom_content_dashboard']['content'] = custom_content_widget_content();

	if ( !isset($widget_options['custom_content_dashboard']['eval']) )
		$widget_options['custom_content_dashboard']['eval'] = 'no';

	$current_user = wp_get_current_user();

	$custom_content_dashboard_content = stripcslashes($widget_options['custom_content_dashboard']['content']);

	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['widget-custom_content_dashboard']) ) {
                $custom_content_dashboard_content = $_POST['widget-custom_content_dashboard']['content'];
                $custom_content_dashboard_eval = $_POST['widget-custom_content_dashboard']['eval'];
                $custom_content_dashboard_title = $_POST['widget-custom_content_dashboard']['title'];
                $my_widget_options['custom_content_dashboard']['content'] = wp_kses($custom_content_dashboard_content, wp_allowed_protocols());
		// $widget_options['custom_content_dashboard']['eval'] = $custom_content_dashboard_eval;
		$my_widget_options['custom_content_dashboard']['title'] = strip_tags($custom_content_dashboard_title);
                update_option( 'my_dashboard_widget_options', $my_widget_options );
        }

	if ($current_user->has_cap('manage_options')) {
		echo '<p><label for="widget-custom_content_dashboard_title">' . __('Custom Content Widget Title:', 'custom_content_dashboard') . '</label><br/>';
		echo '<input type="text" id="widget-custom_content_dashboard_title" name="widget-custom_content_dashboard[title]" size="62" value="'.$widget_options['custom_content_dashboard']['title'].'" /></p>';
		echo '<p><label for="widget-custom_content_dashboard_content">' . __('Custom content:', 'custom_content_dashboard') . '</label><br/>';
		echo '<textarea id="widget-custom_content_dashboard_content" name="widget-custom_content_dashboard[content]" rows="10" cols="62">'.$custom_content_dashboard_content.'</textarea></p>';
	} else {
		_e('You are not allowed to edit this widget', 'custom_content_dashboard');
	}
}

/*
 * Update Notifications Notice
 */
global $wpmudev_notices;
$wpmudev_notices[] = array( 'id'=> 17, 'name'=> 'Custom Content Dashboard Widget', 'screens' => array( 'settings_page_custom_content_dashboard-network' ) );
include_once(plugin_dir_path( __FILE__ ).'external/dash-notice/wpmudev-dash-notification.php');
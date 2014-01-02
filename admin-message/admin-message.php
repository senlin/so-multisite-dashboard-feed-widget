<?php
/*
Plugin Name: Admin Message
Plugin URI: http://premium.wpmudev.org/project/admin-message
Description: Display a message in admin dashboard
Author: S H Mohanjith (Incsub), Andrew Billits (Incsub)
Version: 1.1.1.2
Tested up to: 3.2.0
Network: true
Author URI: http://premium.wpmudev.org
WDP ID: 5
Text Domain: admin_message
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

global $admin_message_settings_page, $admin_message_settings_page_long;

if ( version_compare($wp_version, '3.0.9', '>') ) {
	$admin_message_settings_page = 'settings.php';
	$admin_message_settings_page_long = 'network/settings.php';
} else {
	$admin_message_settings_page = 'ms-admin.php';
	$admin_message_settings_page_long = 'ms-admin.php';
}

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('init', 'admin_message_init');
add_action('admin_menu', 'admin_message_plug_pages');
add_action('network_admin_menu', 'admin_message_plug_pages');
add_action('admin_notices', 'admin_message_output');
add_action('network_admin_notices', 'admin_message_output');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function admin_message_init() {
	if ( !is_multisite() )
		exit( 'The Admin Message plugin is only compatible with WordPress Multisite.' );

	load_plugin_textdomain('admin_message', false, dirname(plugin_basename(__FILE__)).'/languages');
}

function admin_message_output() {
	$admin_message = get_site_option('admin_message');
	if ( !empty( $admin_message ) && $admin_message != 'empty' ){
		?>
		<div id="message" class="updated"><p><?php echo stripslashes( $admin_message ); ?></p></div>
		<?php
	}
}

function admin_message_plug_pages() {
	global $wpdb, $wp_roles, $current_user, $wp_version, $admin_message_settings_page, $admin_message_settings_page_long;
	if ( version_compare($wp_version, '3.0.9', '>') ) {
		if ( is_network_admin() ) {
			add_submenu_page($admin_message_settings_page, __('Admin Message', 'admin_message'), __('Admin Message', 'admin_message'), 'manage_network_options', 'admin-message', 'admin_message_page_output');
		}
	} else {
		if ( is_super_admin() ) {
			add_submenu_page($admin_message_settings_page, __('Admin Message', 'admin_message'), __('Admin Message', 'admin_message'), 'manage_network_options', 'admin-message', 'admin_message_page_output');
		}
	}
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function admin_message_page_output() {
	global $wpdb, $wp_roles, $current_user, $admin_message_settings_page, $admin_message_settings_page_long;

	if(!current_user_can('manage_options')) {
		echo "<p>" . __('Nice Try...', 'admin_message') . "</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e(urldecode($_GET['updatedmsg']), 'admin_message') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$admin_message = get_site_option('admin_message');
			if ( $admin_message == 'empty' ) {
				$admin_message = '';
			}
			?>
			<h2><?php _e('Admin Message', 'admin_message') ?></h2>
            <form method="post" action="<?php print $admin_message_settings_page; ?>?page=admin-message&action=process">
            <table class="form-table">
            <tr valign="top">
            <th scope="row"><?php _e('Message', 'admin_message') ?></th>
            <td>
            <textarea name="admin_message" type="text" rows="5" wrap="soft" id="admin_message" style="width: 95%"/><?php echo $admin_message ?></textarea>
            <br /><?php _e('HTML allowed', 'admin_message') ?></td>
            </tr>
            </table>

            <p class="submit">
            <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes', 'admin_message') ?>" />
			<input class="button button-secondary" type="submit" name="Reset" value="<?php _e('Reset', 'admin_message') ?>" />
            </p>
            </form>
			<?php
		break;
		//---------------------------------------------------//
		case "process":
			if ( isset( $_POST[ 'Reset' ] ) ) {
				update_site_option( "admin_message", "empty" );
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='{$admin_message_settings_page}?page=admin-message&updated=true&updatedmsg=" . urlencode(__('Settings cleared.', 'admin_message')) . "';
				</script>
				";
			} else {
				$admin_message = $_POST[ 'admin_message' ];
				if ( $admin_message == '' ) {
					$admin_message = 'empty';
				}
				update_site_option( "admin_message", stripslashes($admin_message) );
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='{$admin_message_settings_page}?page=admin-message&updated=true&updatedmsg=" . urlencode(__('Settings saved.', 'admin_message')) . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

global $wpmudev_notices;
$wpmudev_notices[] = array( 'id'=> 5, 'name'=> 'Admin Message', 'screens' => array( 'settings_page_admin-message-network' ) );
include_once(plugin_dir_path( __FILE__ ).'external/dash-notice/wpmudev-dash-notification.php');

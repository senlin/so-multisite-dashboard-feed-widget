<?php
/**
 * Render the Plugin options form
 * @since 2014.01.02
 */
function so_msdbfeed_render_form() { ?>

	<div class="wrap">
		
		<!-- Display Plugin Header, and Description -->
		<h2><?php _e( 'SO Multisite Dashboard Feed Widget Settings', 'multisite-dashboard-feed-widget' ); ?></h2>
		
		<p><?php _e( 'Below you can adjust the output of the SO Multisite Dashboard Feed Widget. You can change the title of the widget, the feed URL and the amount of feed items to show.', 'multisite-dashboard-feed-widget' ); ?></p>
			
		<div id="msdbfeed-settings">
	
			<!-- Beginning of the Plugin Options Form -->
			<form method="post" action="options.php">
			
				<?php settings_fields( 'so_msdbfeed_plugin_options' ); ?>
		
				<?php $options = get_option( 'so_msdbfeed_options' ); ?>
			
				<div class="msdbfeed-section msdbfeed-section-title">

					<label for="msdbfeed-title"><?php _e( 'Widget Title', 'dashboard-feed-widget' ); ?></label>
					
					<input name="so_msdbfeed_options[widget_title]" type="text" id="msdbfeed-title" value="<?php echo $options['widget_title']; ?>" />
							
					<span class="hint">
						<?php _e( 'Change the title of the SO Multisite Dashboard Feed Widget into something of your liking', 'multisite-dashboard-feed-widget' ); ?>
					</span>
			
					<input type="hidden" name="action" value="update" />
			
					<input type="hidden" name="page_options" value="<?php echo $options['widget_title']; ?>" />

				</div>
				
				<div class="msdbfeed-section msdbfeed-section-feed">
				
					<label for="msdbfeed-feed-url"><?php _e( 'Feed URL', 'multisite-dashboard-feed-widget' ); ?></label>
				
					<input name="so_msdbfeed_options[feed_url]" type="text" id="msdbfeed-feed-url" value="<?php echo $options['feed_url']; ?>" />
								
					<span class="hint">
						<?php _e( 'By default the Feed URL is that of the main site in the network. If you would like to change it into something else, you can do that here.', 'multisite-dashboard-feed-widget' ); ?>
					</span>
				
					<input type="hidden" name="action" value="update" />
				
					<input type="hidden" name="page_options" value="<?php echo $options['feed_url']; ?>" />
				
				</div>
	
				<div class="msdbfeed-section msdbfeed-section-select">
									
					<label for="msdbfeed-select"><?php _e( 'How many Feed Items to show in the SO Multisite Dashboard Feed Widget', 'multisite-dashboard-feed-widget' ); ?></label>
	
					<select name='so_msdbfeed_options[drp_select_box]'>
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
	
					<span class="hint">
						<?php _e( 'How many feed items to show in the widget?', 'multisite-dashboard-feed-widget' ); ?>
					</span>
	
					<input type="hidden" name="action" value="update" />
				
					<input type="hidden" name="page_options" value="<?php echo $options['drp_select_box']; ?>" />
				
				</div>

				<div class="msdbfeed-section msdbfeed-section-bkgr">
				
					<label for="msdbfeed-bkgr-color"><?php _e( 'Widget Background Color', 'multisite-dashboard-feed-widget' ); ?></label>
				
					<input name="so_msdbfeed_options[widget_bkgr]" type="text" id="msdbfeed-bkgr-color" value="<?php echo $options['widget_bkgr']; ?>" />
								
					<span class="hint">
						<?php _e( 'By default the background color is #FFFF99. If you would like to use a different background color, you can change it here. You can use the 3 or 6 digit HEX code <strong>without the #</strong>.', 'multisite-dashboard-feed-widget' ); ?>
					</span>
				
					<input type="hidden" name="action" value="update" />
				
					<input type="hidden" name="page_options" value="<?php echo $options['widget_bkgr']; ?>" />
				
				</div>
	

				
				<hr />
				
				<div class="msdbfeed-section msdbfeed-section-dbchk">				
					
					<label for="msdbfeed-db-chk"><?php _e( 'Database Options', 'multisite-dashboard-feed-widget' ); ?></label>
					
					<input name="so_msdbfeed_options[chk_default_options_db]" type="checkbox" id="msdbfeed-db-chk" value="1" <?php if ( isset($options['chk_default_options_db'] ) ) { checked( '1', $options['chk_default_options_db'] ); } ?> />
								<?php _e( 'Restore defaults upon plugin deactivation/reactivation', 'multisite-dashboard-feed-widget' ); ?>
					<span class="hint">
						<?php _e( 'Only check this if you want to reset plugin settings upon Plugin reactivation', 'multisite-dashboard-feed-widget' ); ?>
					</span>
				
				</div>
						
				<div class="msdbfeed-section msdbfeed-section-submit">
				
					<p class="submit">
						
						<input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'multisite-dashboard-feed-widget' ) ?>" />
					
					</p>
				
				</div>
			
			</form>
		
		</div><!-- #msdbfeed-settings -->

		<p class="rate-this-plugin">
			
			<?php
			/* Translators: 1 is link to WP Repo */
			printf( __( 'If you have found this plugin at all useful, please give it a favourable rating in the <a href="%s" title="Rate this plugin!">WordPress Plugin Repository</a>.', 'multisite-dashboard-feed-widget' ), 
				esc_url( 'http://wordpress.org/plugins/multisite-dashboard-feed-widget/' )
			);
			?>
			
		</p>
		
		<div class="author postbox">
			
			<h3 class="hndle">
				<span><?php _e( 'About the Author', 'multisite-dashboard-feed-widget' ); ?></span>
			</h3>
			
			<div class="inside">
				<img src="http://www.gravatar.com/avatar/<?php echo md5( 'info@senlinonline.com' ); ?>" style="float: left; margin-right: 10px; padding: 3px; border: 1px solid #DFDFDF;"/>
				<p>
					<?php printf( __( 'Hi, my name is Piet Bos, I hope you like this plugin! Please check out any of my other plugins on <a href="%s" title="SO WP Plugins">SO WP Plugins</a>. You can find out more information about me via the following links:', 'multisite-dashboard-feed-widget' ),
					esc_url( 'http://so-wp.com' )
					); ?>
				</p>
				
				<ul>
					<li><a href="http://senlinonline.com/" target="_blank" title="Senlin Online"><?php _e('Senlin Online', 'multisite-dashboard-feed-widget'); ?></a></li>
					<li><a href="http://wpti.ps/" target="_blank" title="WP TIPS"><?php _e('WP Tips', 'dbfw'); ?></a></li>
					<li><a href="https://plus.google.com/+PietBos" target="_blank" title="Piet on Google+"><?php _e( 'Google+', 'multisite-dashboard-feed-widget' ); ?></a></li>
					<li><a href="http://cn.linkedin.com/in/pietbos" target="_blank" title="LinkedIn profile"><?php _e( 'LinkedIn', 'multisite-dashboard-feed-widget' ); ?></a></li>
					<li><a href="http://twitter.com/piethfbos" target="_blank" title="Twitter"><?php _e( 'Twitter: @piethfbos', 'multisite-dashboard-feed-widget' ); ?></a></li>
					<li><a href="http://github.com/senlin" title="on Github"><?php _e( 'Github', 'multisite-dashboard-feed-widget' ); ?></a></li>
					<li><a href="http://profiles.wordpress.org/senlin/" title="on WordPress.org"><?php _e( 'WordPress.org Profile', 'multisite-dashboard-feed-widget' ); ?></a></li>
				</ul>
			
			</div> <!-- end .inside -->
		
		</div> <!-- end .postbox -->

	</div> <!-- end .wrap -->

<?php }


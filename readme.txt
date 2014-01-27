=== Multisite Dashboard Feed Widget ===
Contributors: senlin
Donate link: http://so-wp.com/donations
Tags: multisite, dashboard, feed, widget, admin, rss
Requires at least: 3.1.2
Tested up to: 3.8.1
Stable tag: 2014.01.27
License: GPLv2 or later

Shows the latest Posts from the main site of a multisite install in the top of the Dashboard of the sites hanging under the multisite install.

== Description ==

With the arrival of WordPress version 3.1.2 all of a sudden the Dashboard Feed on Multisite had disappeared. A few others noticed this too, but nobody had any solutions. That is the reason why I made this plugin. 
By default it shows the titles (and links to) the 3 latest Posts of the Main Site (blog_id=1) in a box with a yellow background which shows as the first available widget in the dashboard of all sites hanging under the Multisite.

As this is my first plugin, I have not yet included an options page. Actually there are not that many variables anyway. But making options available is on the TO-DO list.

The default settings are:<br />
- the plugin automatically takes the RSS Feed of the main site in the WordPress Multisite install (`blog_id=1`)
- the default number of RSS items is 3<br />
- the standard title of the widget box is "Recent Updates"

The plugin comes localized for use on sites other than the English language and/or on bi/multilingual websites. In the languages folder you will find the .po, .pot and .mo files. For now there is only one line, but when I get around to do the options page, that will of course become more.

== Installation ==

If you can live with the default settings, then follow step 1-3 below. If you want to change the default settings, skip step 1-3 and read further below them.

1. Upload `multisite-dashboard-feed-widget.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Network activate the plugin in your Network Admin (`yoursite.com/wp-admin/network/`)

If you would like to change the RSS Feed address, open `msrss.php` and delete line 2. Then change line 3 into:
`$rss = fetch_feed('http://yourdomain.com/feed/');`

If you would like to change the number of RSS items, open `msrss.php` and edit the number in line 6.

If you would like to change the title from "Recent Updates" to something else, open `msdbfeed.php` and change the name in line 44.

After editing the file(s), you can follow step 1-3 above to install the plugin.

== Frequently Asked Questions ==

= Can I use this plugin also on a single WordPress install? =

You could, but you'd probably be better off by installing the [SO Dashboard Feed Widget](http://wordpress.org/extend/plugins/dashboard-feed-widget/) plugin that I released in August 2012. That plugin actually comes with its own Settings page too.

== Screenshots ==

1. Siteadmin Dashboard after installation.

== Changelog ==

= 2014.01.27 =

* Revert entire plugin to last working version (1.3)
* compatible up to WP 3.8.1

= 1.4.1 =

* change text domain to prepare for language packs (via Otto - http://otto42.com/el)

= 1.4.0 =
* Recode the plugin and add Options page (at last)
* Update readme file
* Compatible up to WP 3.7.1
* Add version check
* Update minimum required version (WP 3.6)

= 1.3.1 =
* Changed compatibility to WP 3.6
* prevent direct access to file

= 1.3 =
* Adjusted FAQ

= 1.2.3 =
* Changed compatibility to WP 3.4.1

= 1.2.2 =
* Resave to get last updated right

= 1.2.1 =
* Tested on WordPress version 3.3, works

= 1.2 =
* Messed up uploading and versioning
* Added Screenshot

= 1.0 =
* First version (stable)

== Upgrade Notice ==

= 2014.01.27 =

* Due to several bugs and plain wrong way of coding the settings page I have for now reverted the entire plugin back to the last working version (1.3) until I find a properly working solution. Apologies for any inconvenience this may cause.

= 1.4.0 =
* Added Options page. Please keep in mind that options will ONLY work on new sites; for existing sites you will need to save the settings manually for this release. That unfortunately is the "price we pay" for having an options page.

= 1.2.1 =
* Tested on WordPress version 3.3, works

= 1.0 =
First release

=== SO Multisite Dashboard Feed Widget ===
Contributors: senlin
Donate link: http://senl.in/PPd0na
Tags: multisite, dashboard, feed, widget, admin, rss
Requires at least: 3.6
Tested up to: 3.7.1
Stable tag: 1.4.1
License: GPLv2 or later

Shows the latest Posts from the main site of a multisite install in the top of the Dashboard of the sites hanging under the multisite install.

== Description ==

With the arrival of WordPress version 3.1.2 all of a sudden the Dashboard Feed on Multisite had disappeared. A few others noticed this too, but nobody had any solutions. That is the reason why I made this plugin. 
By default it shows the titles (and links to) the 3 latest Posts of the Main Site (blog_id=1) in a box with a yellow background which shows as the first available widget in the dashboard of all sites hanging under the Multisite.

Since version 1.4.0 this plugin finally has an options page (phew). One thing to keep in mind though is that the options will <strong>ONLY</strong> be shown automatically on newly added sites, <strong>NOT</strong> on the existing sites in the network. For these, you will actually need to go into the SO Multisite Dashboard Feed Widget Settings of each site and save the it once.

The default settings are:
- the plugin automatically takes the RSS Feed of the main site in the WordPress Multisite install (blog_id=1)
- the default number of RSS items is 3
- the standard title of the widget box is "Recent Updates"

The plugin comes localized for use on sites other than the English language and/or on bi/multilingual websites. In the languages folder you will find the .po, .pot and .mo files.

== Installation ==

= Wordpress =

Quick installation: [Install now](http://coveredwebservices.com/wp-plugin-install/?plugin=multisite-dashboard-feed-widget) !

 &hellip; OR &hellip;

Search for "SO Multisite Dashboard Feed Widget" and install with the **Plugins > Add New** back-end page.

 &hellip; OR &hellip;

Follow these steps:

1. Download zip file.
2. Upload the zip file via the Plugins > Add New > Upload page &hellip; OR &hellip; unpack and upload with your favorite FTP client to the /plugins/ folder.
3. Network activate the plugin on the Plugins page of your Network Admin (`yoursite.com/wp-admin/network/`).

Done!

On the Settings page of each individual site in your network you can change the widget title and the number of feed items. 

After saving the settings, you can see the results in the main WordPress Dashboard of each individual site.

== Frequently Asked Questions ==

= Can I use this plugin also on a single WordPress install? =

You could, but you'd probably be better off by installing the [Dashboard Feed Widget](http://wordpress.org/extend/plugins/dashboard-feed-widget/) plugin that I released in August 2012. That plugin actually comes with its own Settings page too.

= I have an issue with this plugin, where can I get support? =

Please open an issue over at [Github](https://github.com/so-wp/so-multisite-dashboard-feed-widget/issues/new), as **I will not use the support forums** here on WordPress.org

== Screenshots ==

1. Siteadmin Dashboard after installation.

== Changelog ==

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

= 1.4.0 =
* Added Options page. Please keep in mind that options will ONLY work on new sites; for existing sites you will need to save the settings manually for this release. That unfortunately is the "price we pay" for having an options page.

= 1.2.1 =
* Tested on WordPress version 3.3, works

= 1.0 =
First release

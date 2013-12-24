SO Multisite Dashboard Feed Widget
=====================

###### Last updated 2013.12.24
###### requires at least WordPress 3.6
###### tested up to WordPress 3.9-alpha
###### Author: [Piet Bos](https://github.com/senlin)
###### [Stable Version](http://wordpress.org/plugins/multisite-dashboard-feed-widget/) (via WordPress Plugins Repository)
###### [Plugin homepage](http://so-wp.com/plugin/so-multisite-dashboard-feed-widget)

Shows the latest Posts from the main site of a multisite install in the top of the Dashboard of the sites hanging under the multisite install.

## Description

With the arrival of WordPress version 3.1.2 all of a sudden the Dashboard Feed on Multisite had disappeared. A few others noticed this too, but nobody had any solutions. That is the reason why I made this plugin. 
By default it shows the titles (and links to) the 3 latest Posts of the Main Site (blog_id=1) in a box with a yellow background which shows as the first available widget in the dashboard of all sites hanging under the Multisite.

Since version 1.4.0 this plugin finally has an options page (phew). One thing to keep in mind though is that the options will <strong>ONLY</strong> be shown automatically on newly added sites, <strong>NOT</strong> on the existing sites in the network. For these, you will actually need to go into the SO Multisite Dashboard Feed Widget Settings of each site and save the it once.

The default settings are:
- the plugin automatically takes the RSS Feed of the main site in the WordPress Multisite install (blog_id=1)
- the default number of RSS items is 3
- the standard title of the widget box is "Recent Updates"

The plugin comes localized for use on sites other than the English language and/or on bi/multilingual websites. In the languages folder you will find the .po, .pot and .mo files.

I have decided to only support this plugin through <a href="https://github.com/senlin/so-multisite-dashboard-feed-widget/issues">Github</a>. Therefore, if you have any questions, need help and/or want to make a feature request, please open an issue here. You can also browse through open and closed issues to find what you are looking for and perhaps even help others.
 
<strong>PLEASE DO NOT POST YOUR ISSUES VIA THE WORDPRESS FORUMS BUT ON GITHUB INSTEAD</strong>
 
Thanks for your understanding and cooperation.

## Frequently Asked Questions

### Can I use this plugin also on a single WordPress install?

You could, but you'd probably be better off by installing the [SO Dashboard Feed Widget](http://wordpress.org/extend/plugins/dashboard-feed-widget/) plugin that I released in August 2012. That plugin actually comes with its own Settings page too.

### I have an issue with this plugin, where can I get support?

Please open an issue here on [Github](https://github.com/senlin/so-multisite-dashboard-feed-widget/issues)

## Contributions

This repo is open to _any_ kind of contributions.

## License

* License: GNU Version 2 or Any Later Version
* License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Donations

* Donate link: http://so-wp.com/donations/

## Connect with me through

[Github](https://github.com/senlin) 

[Google+](http://plus.google.com/+PietBos) 

[WordPress](http://profiles.wordpress.org/senlin/) 

[Website](http://senlinonline.com)

## Changelog

### upcoming version

* new version number format
* compatible up to WP 3.9-alpha
* changed Github & homepage links
* add READ.MD

### 1.4.1

* change text domain to prepare for language packs (via Otto - http://otto42.com/el)

### 1.4.0

* Recode the plugin and add Options page (at last)
* Update readme file
* Compatible up to WP 3.7.1
* Add version check
* Update minimum required version (WP 3.6)

###  1.3.1

* Changed compatibility to WP 3.6
* prevent direct access to file

### 1.3

* Adjusted FAQ

### 1.2.3

* Changed compatibility to WP 3.4.1

### 1.2.2

* Resave to get last updated right

### 1.2.1

* Tested on WordPress version 3.3, works

### 1.2

* Messed up uploading and versioning
* Added Screenshot

### 1.0

* First version (stable)



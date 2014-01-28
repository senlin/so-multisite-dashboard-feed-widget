SO Multisite Dashboard Feed Widget
=====================

###### Last updated 2014.01.27
###### requires at least WordPress 3.6
###### tested up to WordPress 3.8.1
###### Author: [Piet Bos](https://github.com/senlin)
###### [Stable Version](http://wordpress.org/plugins/multisite-dashboard-feed-widget/) (via WordPress Plugins Repository)
###### [Plugin homepage](http://so-wp.com/plugin/so-multisite-dashboard-feed-widget)

Shows the latest Posts from the main site of a multisite install in the top of the Dashboard of the sites hanging under the multisite install.

## Introduction

With the arrival of WordPress version 3.1.2 all of a sudden the Dashboard Feed on Multisite had disappeared. A few others noticed this too, but nobody had any solutions. That is the reason why I made this plugin. 
By default it shows the titles (and links to) the 3 latest Posts of the Main Site (`blog_id=1`) in a box with a yellow background which shows as the first available widget in the dashboard of all sites hanging under the Multisite.

Since version 2014.01.27 I have temporarily had to revert the plugin back to the older, but functional version 1.3 without an options page. This plugin desperately needs an options page and for Network sites that is a bit more complicated than for a single WordPress install. Anyone that can help me with implementing a working settings page, please contact me.

The plugin comes localized for use on sites other than the English language and/or on bi/multilingual websites. In the languages folder you will find the .po, .pot and .mo files.

I have decided to only support this plugin through <a href="https://github.com/senlin/so-multisite-dashboard-feed-widget/issues">Github</a>. Therefore, if you have any questions, need help and/or want to make a feature request, please open an issue here. You can also browse through open and closed issues to find what you are looking for and perhaps even help others.

## Changing the defaults

* If you would like to change the RSS Feed address, open `msrss.php` and delete line 2. Then change line 3 into: `$rss = fetch_feed('http://yourdomain.com/feed/');`
* If you would like to change the number of RSS items, open `msrss.php` and edit the number in line 6.
* If you would like to change the title from "Recent Updates" to something else, open `msdbfeed.php` and change the name in line 114.

## Frequently Asked Questions

### Can I use this plugin also on a single WordPress install?

No, instead please install the [SO Dashboard Feed Widget](http://wordpress.org/extend/plugins/dashboard-feed-widget/) plugin that I released in August 2012. That plugin actually comes with its own Settings page too.

### I have an issue with this plugin, where can I get support?

Please open an issue here on [Github](https://github.com/senlin/so-multisite-dashboard-feed-widget/issues)

## Contributions

This plugin desperately needs an options page and for Network sites that is a bit more complicated than for a single WordPress install. Anyone that can help me with implementing a working settings page, please contact me.

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

### 2014.01.27

* Revert entire plugin to last working version (1.3)
* compatible up to WP 3.8.1
* add README.md

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



=== Yoctopuce Sensors ===
Contributors: mvuilleu
Tags: sensor IoT
Requires at least: 3.5
Tested up to: 4.3.1
Stable tag: trunk

Add real-world sensors to your Wordpress site


== Description ==

[Yoctopuce Sensors](http://www.yoctopuce.com/EN/article/a-wordpress-plugin-for-yoctopuce-sensors) 
is WordPress plugin that connect your Wordpress site to real-world sensors.
This plug-in registers a special URL suffix "?httpcallback" used by networked sensors to post data, 
and adds a shortcode to retrieve most recent data.

To display the latest measure in WordPress, you can then use the [YSensor name="..."] shortcode in 
any page, indicating the name of your sensor (either its logical name if you assigned one or its 
hardware identifier).

= Features =
* Support for all Yoctopuce sensors
* Ethernet/Wireless sensors support
* USB sensors support (via VirtualHub)

= Requirements =
* WordPress 3.5+
* PHP 5.3+

== Installation ==

Unzip plugin files and upload them under your '/wp-content/plugins/' directory.

Resulted names will be:
  './wp-content/plugins/yocto-sensor/*'

Activate plugin at "Plugins" administration page.


== Screenshots ==

1. This screenshot shows how a real-life sensor value can be included on a Wordpress page
2. This screenshot shows the configuration panel

== Upgrade Notice ==

Upgrade normally


== Changelog ==

= 1.0.0 =
* Initial release

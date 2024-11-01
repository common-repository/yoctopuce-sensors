<?php
/*
  Plugin Name: Yoctopuce Sensors
  Plugin URI: http://www.yoctopuce.com/EN/article/a-wordpress-plugin-for-yoctopuce-sensors
  Version: 1.0.0
  Author: Yoctopuce
  Author URI: http://www.yoctopuce.com/
  Description: Add real-world sensors to your Wordpress site
  Text Domain: yocto-sensor
  License: BSD
 */

// Define plugin constants
define( 'YSENSOR_PLUGIN_FILE', __FILE__ );
define( 'YSENSOR_PLUGIN_VERSION', '1.0.0' );
define( 'YSENSOR_ENABLE_CACHE', false );

// Includes
require_once 'inc/load.php';

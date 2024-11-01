<?php
/**
 * Code executed when a YoctoHub (or VirtualHub) performs an HTTP Callback
 * 
 * We are called from parse_request action, with WP database ready for use
 */

require_once 'yoctolib/yocto_api.php';

$table_name = $wpdb->prefix . 'ysensor'; 

// Get callback data and check specified signature
$options = get_option('ysensor_options');
$authsettings = (isset($options['signature']) ? 'md5:'.$options['signature'].'@' : '');
yRegisterHub($authsettings.'callback');

// Insert in the database a record for each sensor
$sensor = yFirstSensor();
while(!is_null($sensor)) {        
    $wpdb->query( $wpdb->prepare( 
        "INSERT INTO $table_name ( sensor, value, unit ) VALUES ( %s, %f, %s )", 
            $sensor->get_friendlyName(), 
            $sensor->get_currentValue(), 
            $sensor->get_unit()
    ) );
    $sensor = $sensor->nextSensor();
}

// Delete records older than 24h
$wpdb->query( "DELETE FROM $table_name WHERE time < NOW() - INTERVAL 24 HOUR" );

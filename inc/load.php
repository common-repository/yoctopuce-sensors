<?php
class Yocto_Sensor {
	/**
	 * Hooks into WordPress
	 */
	function __construct() {
		register_activation_hook( YSENSOR_PLUGIN_FILE, array( __CLASS__, 'install' ) );
		add_action( 'init',                            array( __CLASS__, 'update' ), 20 );
		add_action( 'admin_menu',                      array( __CLASS__, 'add_admin_page' ) );
        add_action( 'admin_init',                      array( __CLASS__, 'ysensor_admin_init') );
		add_action( 'init',                            array( __CLASS__, 'register' ) );
        add_filter( 'query_vars',                      array( __CLASS__, 'query_vars') );
        add_action( 'parse_request',                   array( __CLASS__, 'http_hook' ) );
	}

	/**
	 * Plugin activation
	 */
	public static function install() {
        global $wpdb;
        
        // create table
        $table_name = $wpdb->prefix . 'ysensor'; 
		$charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    time TIMESTAMP,
                    sensor varchar(50) NOT NULL,
                    value double(12,3) NOT NULL,
                    unit varchar(12) NOT NULL,
                    UNIQUE KEY id (id),
                    KEY sensor (sensor),
                    KEY time (time)
                ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        add_option( 'ysensor_option_version', YSENSOR_PLUGIN_VERSION );
	}

	/**
	 * Plugin update hook
	 */
	public static function update() {
		$option = get_option( 'ysensor_option_version' );
		if ( $option !== YSENSOR_PLUGIN_VERSION ) {
            install();
		}
	}

	/**
	 * Add settings page in admin UI
	 */
	public static function add_admin_page() {
		require_once 'admin_options.php';
		add_options_page( 'Yocto-Sensor Options', 'Yocto-Sensor', 'manage_options', 'ysensor', 'ysensor_options_page' );
	}

	/**
	 * Register our admin settings
	 */
    public static function ysensor_admin_init() {
		require_once 'admin_options.php';
        ysensor_options_register();
    }
    
	/**
	 * Register shortcodes
	 */
	public static function register() {
		add_shortcode( 'YSensor', array( __CLASS__, 'ysensor_shortcode' ) );
	}

	/**
	 * Shortcode handler
	 */
	public static function ysensor_shortcode( $atts = null, $content = null ) {
        global $wpdb;
		$atts = shortcode_atts( array(
				'name'     => ''
			), $atts, 'YSensor' );
        
        $table_name = $wpdb->prefix . 'ysensor';         
        $row = $wpdb->get_row( $wpdb->prepare(
            "SELECT * FROM $table_name WHERE sensor=%s ORDER BY time DESC LIMIT 1", 
            $atts['name']
        ), OBJECT);
        if(!$row) return "?";
        return strVal(floatVal($row->value)).' '.$row->unit;
	}

	/**
	 * Register our query variable
	 */
    public static function query_vars( $vars ) {
        $vars[] = 'httpcallback';
        return $vars;
    }
    
	/**
	 * Low-level hook to intercept HTTP callbacks
	 */
    public static function http_hook( $wp ) {
        global $wpdb;
        
        if( array_key_exists( 'httpcallback', $wp->query_vars ) ) {
            require_once 'http_callback.php';
            die("HTTP callback done.");
        }
    }
    
}

/**
 * Register plugin function to perform checks that plugin is installed
 */
function yocto_sensor() {
	return true;
}

new Yocto_Sensor;

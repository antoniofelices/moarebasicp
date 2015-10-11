<?php
/**
*
* Plugin Name: Moare basic functions
* Plugin URI: http://studiomoare.com
* Description: Some functions Studio Moare use to create a websites.
* Version: 1.0
* Author: Antonio
* Author URI: http://studiomoare.com
* License: GPLv2 or any later version
* Text Domain: moarebasicp
* Domain Path: /languages
*
**/

// Do not uncomment the following line!
// If you need to use this constant, use it in the wp-config.php file

define ( 'MOARE_BASIC_PLUGIN_PATH', plugin_dir_path(__FILE__) );

// Localization
function moarebasicp_load_plugin_textdomain() {
    load_plugin_textdomain( 'moarebasicp', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'moarebasicp_load_plugin_textdomain' );


require_once MOARE_BASIC_PLUGIN_PATH . '/includes/moarebasicp-custom-post-types.php';
require_once MOARE_BASIC_PLUGIN_PATH . '/includes/moarebasicp-custom-categories.php';
require_once MOARE_BASIC_PLUGIN_PATH . '/includes/moarebasicp-google-analytics.php';
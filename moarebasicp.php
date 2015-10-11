<?php
/**
*
* Plugin Name: Moare basic plugin
* Plugin URI: http://studiomoare.com
* Description: Plugin con funciones para studio moareamoare.
* Version: 1.0
* Author: Antonio
* Author URI: http://studiomoare.com
* License: GPLv2 o posterior
* Text Domain: moarebasicp
* Domain Path: /languages
*
**/

// Do not uncomment the following line!
// If you need to use this constant, use it in the wp-config.php file

define ( 'MOARE_BASIC_PLUGIN_PATH', plugin_dir_path(__FILE__) );

/* Localization
function sm_localization(){
  load_plugin_textdomain( 'moarebasicp', false, MOARE_BASIC_PLUGIN_PATH . '/languages' );
}
*/

function moarebasicp_load_plugin_textdomain() {
    load_plugin_textdomain( 'moarebasicp', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'moarebasicp_load_plugin_textdomain' );


require_once MOARE_BASIC_PLUGIN_PATH . '/includes/moarebasicp-custom-post-types.php';
require_once MOARE_BASIC_PLUGIN_PATH . '/includes/moarebasicp-custom-categories.php';
require_once MOARE_BASIC_PLUGIN_PATH . '/includes/moarebasicp-google-analytics.php';
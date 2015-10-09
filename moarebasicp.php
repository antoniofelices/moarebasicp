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
*
**/

// Do not uncomment the following line!
// If you need to use this constant, use it in the wp-config.php file

define ( 'MOARE_BASIC_PLUGIN_PATH', plugin_dir_path(__FILE__) );

// Localization
function sm_localization(){
  load_plugin_textdomain( 'smbp', false, MOARE_BASIC_PLUGIN_PATH . '/languages' );
}

require MOARE_BASIC_PLUGIN_PATH . '/inc/smbp-custom-post-types.php';
require MOARE_BASIC_PLUGIN_PATH . '/inc/smbp-custom-categories.php';
require MOARE_BASIC_PLUGIN_PATH . '/inc/smbp-google-analytics.php';
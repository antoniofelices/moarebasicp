<?php
/**
 *
 * Plugin Name: Moare basic functions
 * Plugin URI: http://studiomoare.com
 * Description: Some functions Studio Moare use to create a websites.
 * Version: 0.1.0
 * Author: Antonio
 * Author URI: http://studiomoare.com
 * License: GPLv2 or any later version
 * Text Domain: moarebasicp
 * Domain Path: /languages
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   moarebasicp
 * @version   0.1.0
 * @author    antonio felices <antonio@studiomoare.com>
 * @copyright Copyright (c) 2017, Antonio Felices
 * @link      https://studiomoare.com
 * @license   GPL
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 *
 **/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('moarebasicp') ) :

class moarebasicp
{

    /**
     * Version
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    string
     */
	public $version = '0.1.0';

	/**
	 * Constructor method
	 * Empty, to prevent a new instance of the object.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {}

    /**
     * Initialize
     *
     * @since 0.1.0
	 * @access public
     * @return void
     *
     */
	public function initialize()
	{

        /**
         *
		 *
		 */
		$this->settings = array(

            // basic
            'name'				=> __('Moare Basic P', 'moarebasicp'),
            'version'			=> $this->version,

            // urls
            'file'				=> __FILE__,
            'basename'			=> trailingslashit( plugin_basename( __FILE__ ) ),
            'path'				=> trailingslashit( plugin_dir_path( __FILE__ ) ),
            'dir'				=> trailingslashit( plugin_dir_url( __FILE__ ) ),

		);

		// constants
		define( 'MOAREBASICP', 			true );
		define( 'MOAREBASICP_VERSION', 	$this->settings['version'] );
		define( 'MOAREBASICP_PATH',     $this->settings['path'] );
	}

    /**
     * Localization
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function load_textdomain()
	{

	 	// vars
	 	$domain = 'moarebasicp';
	 	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	 	$mofile = $domain . '-' . $locale . '.mo';

	 	// load from the languages directory first
	 	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . '/plugins/' . $mofile );

	 	// load from plugin language folder
	 	load_plugin_textdomain( $domain, FALSE, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' . $mofile );

	}

	/**
	 *
	 * Setup actions
	 * 
	 * @since  0.1.0
 	 * @access public
 	 * @return void
 	 */
	function setup_actions()
	{

		 add_action( 'init', array( $this, 'load_textdomain' ), 2 );

	}

	 /**
 	  * Loads files needed by the plugin.
 	  *
 	  * @since  1.0.0
 	  * @access public
 	  * @return void
 	  */
	 function includes()
	 {

 		include_once( MOAREBASICP_PATH . 'includes/function-google-analytics.php');
 		include_once( MOAREBASICP_PATH . 'includes/function-custom-post-types.php');
 		include_once( MOAREBASICP_PATH . 'includes/function-custom-categories.php');
		include_once( MOAREBASICP_PATH . 'includes/class-widget-facebook.php');
	 }


} /* End class moarebasicp */



function moarebasicp() {

	global $moarebasicp;

	if( !isset($moarebasicp) ) {

		$moarebasicp = new moarebasicp;
		$moarebasicp->initialize();
		$moarebasicp->load_textdomain();
		$moarebasicp->setup_actions();
		$moarebasicp->includes();

	}

	return $moarebasicp;

}

// initialize
moarebasicp();

endif; // class_exists check

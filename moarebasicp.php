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
         * Al usar '$this->' para declarar una variable
		 * sacas esta variable del scope de la function y la variable puede
		 * ser usada fuera de esta function initialize()
		 * Si se declara variable sin '$this->'
		 * Primero: no usar palabra reservada var $settings… dara error
		 * Segundo: variable funcionará, pero solo dentro de funcion initialize()
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
     * tanto ulrich como arabe dicen de usar init
	 * Primero declaro donde buscarar los archivos .mo
	 * Después en funcion setup_actions (mas abajo) los añado usando hook add_action (init)
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
	 * Function para hookear las anteriores load_textdomain / load_plugin_textdomain
	 * Esta es la manera de hookear functions que se encuentran dentro de una class
	 * Fijate como construye segundo parametro
	 * Primero: es un Array
	 * Segundo: usa $this para decir: es esta class. Tambien he visto usar __CLASS__ pero aparece como decreped. Es decir: add_action( 'init',  array( __CLASS__, 'load_textdomain' ) );
	 * Tercero: pasa el nombre de la function
	 * Intenté hacerlo primero instanciando la class y una vez instancia llamarlo como:  add_action( 'wp_head', $moarebasicp->function() );… da error
	 *
	 * @since  0.1.0
 	 * @access public
 	 * @return void
 	 */
	public function setup_actions()
	{

		 add_action( 'init', array( $this, 'load_textdomain' ), 2 );
		 add_action( 'init', array( $this, 'cpt' ), 2 );
		 add_action( 'init', array( $this, 'tax' ), 2 );
		 add_action( 'wp_head', array( $this, 'ga_code' ), 2 );

	}

	 /**
 	  * Loads file to create CPT.
 	  *
 	  * @since  0.1.0
 	  * @access public
 	  * @return void
 	  */
	 public function cpt()
	 {

 		include_once( MOAREBASICP_PATH . 'includes/function-cpt.php');

	 }

	 /**
 	  * Loads file to create custom taxonomies.
 	  *
 	  * @since  0.1.0
 	  * @access public
 	  * @return void
 	  */
	 public function tax()
	 {

 		include_once( MOAREBASICP_PATH . 'includes/function-tax.php');

	 }

	 /**
 	  * Loads file to load google analytics.
 	  *
 	  * @since  0.1.0
 	  * @access public
 	  * @return void
 	  */
	 public function ga_code()
	 {

 		include_once( MOAREBASICP_PATH . 'includes/function-ga-code.php');

	 }

} /* End class moarebasicp */



function moarebasicp() {

	global $moarebasicp;

	if( !isset($moarebasicp) ) {

		$moarebasicp = new moarebasicp;
		$moarebasicp->initialize();
		$moarebasicp->load_textdomain();
		$moarebasicp->setup_actions();

	}

	return $moarebasicp;

}

// initialize
moarebasicp();

endif; // class_exists check

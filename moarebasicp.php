<?php
/**
 *
 * Plugin Name: Moare basic functions
 * Plugin URI: http://studiomoare.com
 * Description: Some functions Studio Moare use to create a websites.
 * Version: 1.0.0
 * Author: Antonio
 * Author URI: http://studiomoare.com
 * License: GPLv2 or any later version
 * Text Domain: moarebasicp
 * Domain Path: /languages
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.
 *
 * @package   moarebasicp
 * @version   1.0.0
 * @author    antonio felices <antonio@studiomoare.com>
 * @copyright Copyright (c) 2017, Antonio Felices
 * @link      https://studiomoare.com
 * @license   GPL
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 */

if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Moare_Basicp' ) ) :

/**
 * Moare_Basicp.
 *
 * Include all the functions.
 *
 * @since 1.0.0
 */
class Moare_Basicp {

	/**
   * Version.
	 *
	 * @since 1.0.0
	 * @var string The plugin version number.
	 */
	public $version = '1.0.0';

	/**
	 * Constructor.
	 *
	 * Empty, to prevent a new instance of the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {}

  /**
   * Initialize.
   *
   * The real constructor.
   *
   * @since 1.0.0
   *
   * @return void
   */
	public function initialize() {

		// Vars
		$this->settings = array(

			// Basic
			'name'     => __('Moare Basic P', 'moarebasicp'),
			'version'  => $this->version,

      // Urls
      'file'      => __FILE__,
      'basename'  => trailingslashit( plugin_basename( __FILE__ ) ),
      'path'      => trailingslashit( plugin_dir_path( __FILE__ ) ),
      'dir'       => trailingslashit( plugin_dir_url( __FILE__ ) ),

		);

		// Constants
		define( 'MOAREBASICP', true );
		define( 'MOAREBASICP_VERSION', $this->settings['version'] );
		define( 'MOAREBASICP_PATH', $this->settings['path'] );

    // Load files.
    require_once( MOAREBASICP_PATH . 'includes/class-widget-loops.php' );
    require_once( MOAREBASICP_PATH . 'includes/class-widget-facebook.php'  );

	}

  /**
   * Localization.
   *
   * @since  1.0.0
   * @access public
   * @return void
   */
	public function load_textdomain() {

		// Vars
		$domain = 'moarebasicp';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		$mofile = $domain . '-' . $locale . '.mo';

		// Load from the languages directory first
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . '/plugins/' . $mofile );

		// Load from plugin language folder
		load_plugin_textdomain( $domain, FALSE, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' . $mofile );

	}

	/**
	 * Setup actions.
	 *
	 * @since  1.0.0
	 * @access public
 	 * @return void
 	 */
	public function setup_actions() {

		// Actions
		add_action( 'init', array( $this, 'load_textdomain' ), 2 );
		add_action( 'init', array( $this, 'cpt' ), 10 );
		add_action( 'init', array( $this, 'tax' ), 10 );
		add_action( 'widgets_init', array( $this, 'moare_widgets' ), 10 );
		add_action( 'wp_head', array( $this, 'ga_code' ), 10 );
		add_action( 'wp_head', array( $this, 'fb_code' ), 20 );

		// Filters
		add_filter( 'the_content', array( $this, 'social_share' ), 2 );

		// Remove actions, emojis
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

	}

	/**
	 * CPT
	 *
	 * Create CPT.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function cpt() {

    $labels = array(
    	'name'               => __( 'mycustom', 'moarebasicp' ),
    	'singular_name'      => __( 'mycustom', 'moarebasicp' ),
    	'add_new'            => __( 'Add new', 'moarebasicp' ),
    	'add_new_item'       => __( 'Add new mycustom', 'moarebasicp' ),
    	'edit_item'          => __( 'Edit mycustom', 'moarebasicp' ),
    	'new_item'           => __( 'New mycustom', 'moarebasicp' ),
    	'all_items'          => __( 'All mycustom', 'moarebasicp' ),
    	'view_item'          => __( 'See mycustom', 'moarebasicp' ),
    	'search_items'       => __( 'Search mycustom', 'moarebasicp' ),
    	'not_found'          => __( 'Not found mycustom', 'moarebasicp' ),
    	'not_found_in_trash' => __( 'Not found mycustom in trash', 'moarebasicp' ),
    	'parent_item_colon'  => '',
    	'menu_name'          => __( 'MyCustom', 'moarebasicp')
    );

    $args = array(
    	'labels'        => $labels,
    	'description'   => __('My custom type', 'moarebasicp'),
    	'public'        => true,
    	'menu_position' => 15,
    	'supports'      => array( 'title','author','thumbnail','editor','excerpt','comments','revisions','custom-fields' ),
    	'has_archive'   => true,
    	'rewrite' 	  	=> array('slug' => 'mycustom')
    );

    register_post_type( 'mycustom', $args );

	}

	/**
	 * Tax
	 *
	 * Create custom taxonomies.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function tax() {

    $labels = array(
    	'name'              => __( 'Taxonomy', 'moarebasicp' ),
      'singular_name'     => __( 'Taxonomy', 'moarebasicp' ),
      'search_items'      => __( 'Search Taxonomy', 'moarebasicp' ),
      'all_items'         => __( 'All taxonomies', 'moarebasicp' ),
      'parent_item'       => __( 'Parent Taxonomy', 'moarebasicp' ),
      'parent_item_colon' => __( 'Parent Taxonomy:', 'moarebasicp' ),
      'edit_item'         => __( 'Edit Taxonomy', 'moarebasicp' ),
      'update_item'       => __( 'Update Taxonomy', 'moarebasicp' ),
      'add_new_item'      => __( 'Add New Taxonomy', 'moarebasicp' ),
      'new_item_name'     => __( 'New Taxonomy Name', 'moarebasicp' ),
      'menu_name'         => __( 'Taxonomies', 'moarebasicp' )
    );

    $args = array(
      'hierarchical'      => true, //change if you need a tags = not hierarchy
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'custom-tax' )
    );

    register_taxonomy( 'customtax', array( 'mycustom' ), $args );

	}

	/**
	 * Code google analytics.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function ga_code() {

    ?>

		<!-- Google Analytics Universal Analytics -->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-XXXXXXXX-X', 'auto');
    ga('send', 'pageview');
    </script>

    <?php

	}

	/**
	 * Code Facebook timeline.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function fb_code() {

    ?>

		<!-- Facebook. Sometimes need to add id="fb-root" after the opening body tag -->
		<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.10";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>

		<?php

	}

	/**
   * Initialize widgets.
   *
   * @since  1.0.0
   * @return ¿?
   */
  public function moare_widgets(){

		register_widget( 'moare_facebook_widget' );
  	register_widget( 'moare_loops_widget' );

  }

	/**
	 * Social Share
	 *
	 * Add social share icons.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function social_share( $content ) {

    if( is_singular() && !is_front_page() ){

      $mb_url_params = array(
        'url'   => get_the_permalink(),
        'title' => get_the_title()
      );

      $sn_facebook = sprintf('<a href="https://facebook.com/sharer/sharer.php?u=%s">Facebook</a>',
        esc_url( $mb_url_params['url'] )
      );

      $sn_twitter = sprintf('<a href="https://twitter.com/intent/tweet?url=%s">Twitter</a>',
        esc_url( $mb_url_params['url'] )
      );

      $sn_googleplus = sprintf('<a href="https://plus.google.com/share?url=%s">Google+</a>',
        esc_url( $mb_url_params['url'] )
      );

      $sn_linkedin = sprintf('<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=%s">Linkedin</a>',
        esc_url( $mb_url_params['url'] )
      );

      // Add links
      $content .= '<div class="social">';
      $content .= $sn_facebook;
      $content .= $sn_twitter;
      $content .= $sn_googleplus;
      $content .= $sn_linkedin;
      $content .= '</div>';

      return $content;

    }else{

      return $content;

    }

	}

} /* End class moarebasicp */

/**
 * moarebasicp
 *
 * The main function responsible for returning the moarebasicp Instance to functions everywhere.
 *
 * @since 1.0.0
 *
 * @return object
 */
function moarebasicp() {

	global $moarebasicp;

	if( !isset($moarebasicp) ) {

		$moarebasicp = new Moare_Basicp;
		$moarebasicp->initialize();
		$moarebasicp->load_textdomain();
		$moarebasicp->setup_actions();

	}

	return $moarebasicp;

}

// Initialize
moarebasicp();

endif; // class_exists check

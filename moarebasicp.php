<?php
/**
 *
 * Plugin Name: Moare basic functions
 * Plugin URI: http://studiomoare.com
 * Description: Some functions Studio Moare use to create a websites. Basically: custom post types, custom taxonomies, widgets and google analytics.
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
	 * Constructor. Empty, to prevent a new instance of the object.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {}

	/**
	 * Initialize. The real constructor.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function initialize() {

		// Vars.
		$this->settings = array(

			// Basic.
			'name'      => __( 'Moare Basic P', 'moarebasicp' ),
			'version'   => $this->version,

			// Urls.
			'file'      => __FILE__,
			'basename'  => plugin_basename( __FILE__ ),
			'path'      => plugin_dir_path( __FILE__ ),
			'dir'       => plugin_dir_url( __FILE__ ),

		);

		// Constants.
		define( 'MOAREBASICP', true );
		define( 'MOAREBASICP_VERSION', $this->settings['version'] );
		define( 'MOAREBASICP_PATH', $this->settings['path'] );

		// Load files.
		include_once( MOAREBASICP_PATH . 'includes/class-widget-facebook.php'  );
		include_once( MOAREBASICP_PATH . 'includes/class-widget-loops.php' );
		include_once( MOAREBASICP_PATH . 'includes/class-widget-social-share.php'  );

	}

	/**
	 * Localization.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function load_textdomain() {

		// Vars.
		$domain = 'moarebasicp';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		$mofile = $domain . '-' . $locale . '.mo';

		// Load from the languages directory first.
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . '/plugins/' . $mofile );

		// Load from plugin language folder.
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

		// Actions.
		add_action( 'init', array( $this, 'load_textdomain' ), 2 );
		add_action( 'init', array( $this, 'register_cpt' ), 10 );
		add_action( 'init', array( $this, 'register_tax' ), 10 );
		add_action( 'init', array( $this, 'hard_crop_images' ) );
		add_action( 'widgets_init', array( $this, 'register_widgets' ), 10 );
		add_action( 'wp_head', array( $this, 'ga_code' ), 10 );
		add_action( 'wp_head', array( $this, 'fb_code' ), 20 );

		// Remove links header.
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'start_post_rel_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'parent_post_rel_link' );
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		// Remove emojis admin.
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

	}

	/**
	 * CPT. Create Custom Post Types.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_cpt() {

		// Name.
		$labels = array(
			'name'                 => _x( 'Mycustoms', 'post type general name', 'moarebasicp' ),
			'singular_name'        => _x( 'Mycustom', 'post type singular name', 'moarebasicp' ),
			'menu_name'            => _x( 'Mycustoms', 'admin menu', 'moarebasicp' ),
			'name_admin_bar'       => _x( 'Mycustom', 'add new on admin bar', 'moarebasicp' ),
			'add_new'              => _x( 'Add new', 'mycustom' , 'moarebasicp' ),
			'add_new_item'         => __( 'Add new mycustom', 'moarebasicp' ),
			'new_item'             => __( 'New mycustom', 'moarebasicp' ),
			'edit_item'            => __( 'Edit mycustom', 'moarebasicp' ),
			'view_item'            => __( 'See mycustom', 'moarebasicp' ),
			'all_items'            => __( 'All mycustom', 'moarebasicp' ),
			'search_items'         => __( 'Search mycustom', 'moarebasicp' ),
			'not_found'            => __( 'Not found mycustom', 'moarebasicp' ),
			'not_found_in_trash'   => __( 'Not found mycustom in trash', 'moarebasicp' )
		);

		$args = array(
			'labels'               => $labels,
			'description'          => __( 'My custom post type', 'moarebasicp' ),
			'public'               => true,
			'menu_position'        => 15,
			'menu_icon'            => 'dashicons-carrot',
			'supports'             => array( 'title', 'author', 'thumbnail', 'editor', 'excerpt', 'comments', 'revisions' ),
			'has_archive'          => true,
			'rewrite'              => array('slug' => 'mycustom'),
			'capability_type'      => 'post',
			'show_in_rest'         => true,
			'taxonomies'           => array(''),
		);

		register_post_type( 'mycustom', $args );

	}

	/**
	 * Tax. Create custom taxonomies.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_tax() {

		// Name.
		$labels = array(
			'name'                          => _x( 'Taxonomies', 'Taxonomy General Name', 'moarebasicp' ),
			'singular_name'                 => _x( 'Taxonomy', 'Taxonomy Singular Name', 'moarebasicp' ),
			'menu_name'                     => __( 'Taxonomy', 'moarebasicp' ),
			'all_items'                     => __( 'All Items', 'moarebasicp' ),
			'parent_item'                   => __( 'Parent Item', 'moarebasicp' ),
			'parent_item_colon'             => __( 'Parent Item:', 'moarebasicp' ),
			'new_item_name'                 => __( 'New Item Name', 'moarebasicp' ),
			'add_new_item'                  => __( 'Add New Item', 'moarebasicp' ),
			'edit_item'                     => __( 'Edit Item', 'moarebasicp' ),
			'update_item'                   => __( 'Update Item', 'moarebasicp' ),
			'view_item'                     => __( 'View Item', 'moarebasicp' ),
			'separate_items_with_commas'    => __( 'Separate items with commas', 'moarebasicp' ),
			'add_or_remove_items'           => __( 'Add or remove items', 'moarebasicp' ),
			'choose_from_most_used'         => __( 'Choose from the most used', 'moarebasicp' ),
			'popular_items'                 => __( 'Popular Items', 'moarebasicp' ),
			'search_items'                  => __( 'Search Items', 'moarebasicp' ),
			'not_found'                     => __( 'Not Found', 'moarebasicp' ),
			'no_terms'                      => __( 'No items', 'moarebasicp' ),
			'items_list'                    => __( 'Items list', 'moarebasicp' ),
			'items_list_navigation'         => __( 'Items list navigation', 'moarebasicp' ),
		);

		$args = array(
			'labels'                        => $labels,
			'hierarchical'                  => true,
			'public'                        => true,
			'query_var'                     => true,
			'rewrite'                       => array( 'slug' => 'custom-tax' ),
			'show_ui'                       => true,
			'show_admin_column'             => true,
			'show_in_nav_menus'             => true,
			'show_in_rest'                  => true
		);

		register_taxonomy( 'customtax', array( 'mycustom' ), $args );

	}

	/**
	 * Code google analytics.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function ga_code() {

		?>

		<!-- Google Analytics Universal Analytics. -->
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-X', 'auto');
		ga('send', 'pageview');
		</script>

		<?php

	}

	/**
	 * Code Facebook timeline.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function fb_code() {

		?>

		<!-- Facebook. -->
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
	 * Hard Crop size images.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function hard_crop_images() {

		add_image_size( 'medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true );

	}

	/**
	 * Initialize widgets.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_widgets() {

		register_widget( 'Moare_Widget_Facebook' );
		register_widget( 'Moare_Widget_Loops' );
		register_widget( 'Moare_Widget_Social_Share' );

	}

} /* End class moarebasicp */

/**
 * moarebasicp
 *
 * The main function responsible for returning the moarebasicp Instance to functions everywhere.
 *
 * @since 1.0.0
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

// Initialize.
moarebasicp();

endif; // class_exists check

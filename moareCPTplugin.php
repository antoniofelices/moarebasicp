<?php
/**
*
* Plugin Name: moareCPTplugin
* Description: Plugin for create custom post type.
* Version: 0.1
* Author: Antonio
* Author URI: http://www.studiomoare.com/
* License: GPLv2 o posterior
*
* Recuerda:
* El nombre del archivo tiene que ir todo en minúsculas
* El aconsejable usar un prefijo en el nombre de la función que crea mi contenido, para evitar conflictos. 
* Estoy usando prefijo mcpt.
* Puedo crear varios tipos de contenido, solo repetir la function cont_nombremitipodecontenido()
* Para activar el loop de categorias y tags, al final
**/

// Define
define ( 'MOARE_CPT_PLUGIN_PATH', plugin_dir_path(__FILE__) );

// Localization
function mcpt_localization()
{
	load_plugin_textdomain( 'mcptd', false, MOARE_CPT_PLUGIN_PATH . '/languages' );
}

/* ==========================================================================
   Nuevos tipos de contenido
   ========================================================================== */
function mcpt_mycustom() {
	$labels = array(
		'name'               => __( 'mycustom', 'mcptd' ),
		'singular_name'      => __( 'mycustom', 'mcptd' ),
		'add_new'            => __( 'Add new', 'mcptd' ),
		'add_new_item'       => __( 'Add new mycustom', 'mcptd' ),
		'edit_item'          => __( 'Edit mycustom', 'mcptd' ),
		'new_item'           => __( 'New mycustom', 'mcptd' ),
		'all_items'          => __( 'All mycustom', 'mcptd' ),
		'view_item'          => __( 'See mycustom', 'mcptd' ),
		'search_items'       => __( 'Search mycustom', 'mcptd' ),
		'not_found'          => __( 'Not found mycustom', 'mcptd' ),
		'not_found_in_trash' => __( 'Not found mycustom in trash', 'mcptd' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'MyCustom'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'My custom type',
		'public'        => true,
		'menu_position' => 15,
		'supports'      => array( 'title','author','thumbnail','editor','excerpt','comments','revisions','custom-fields' ),
		'has_archive'   => true,
		'rewrite' 		=> array('slug' => 'mycustom'),
		'taxonomies' 	=> array('category','post_tag'),//sino quiero que comparta categorias, ni etiquetas comentar o borrar
	);
	register_post_type( 'mycustom', $args );	
}
add_action( 'init', 'mcpt_mycustom' );


/* ==========================================================================
   Custom-type y categorias
   ========================================================================== */

function mcpt_namespace_add_custom_types( $query ) {
  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array('nav_menu_item', 'mycustom'));
          return $query;
        }
}
add_filter( 'pre_get_posts', 'mcpt_namespace_add_custom_types' );


/* ==========================================================================
   Custom-type y authors archives
   ==========================================================================*/

function mcpt_custom_post_author_archive($query) {
    if (!is_admin() && $query->is_author)
        $query->set( 'post_type', array('mycustom1', 'mycustom2', 'mycustom3') );
    remove_action( 'pre_get_posts', 'custom_post_author_archive' );
}
add_action('pre_get_posts', 'mcpt_custom_post_author_archive');

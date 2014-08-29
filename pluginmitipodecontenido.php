<?php
/**
*
* Plugin Name: misTipoDeContenido
* Description: Plugin para crear tipos de contenido personalizados en WP.
* Version: 0.1
* Author: Antonio
* Author URI: http://www.studiomoare.com/
* License: GPLv2 o posterior
*
* Recuerda:
* - El nombre del archivo tiene que ir todo en minúsculas
* - El aconsejable usar un prefijo en el nombre de la función que crea mi contenido, para evitar conflictos
* - Puedo crear varios tipos de contenido, solo repetir la function cont_nombremitipodecontenido()
* - Para activar el loop de categorias y tags, al final
**/

/* ==========================================================================
   Nuevos tipos de contenido
   ========================================================================== */
function cont_nombremitipodecontenido() {
	$labels = array(
		'name'               => __( 'MiTipoDeContenido' ),
		'singular_name'      => __( 'MiTipoDeContenido' ),
		'add_new'            => _x( 'Añade nuevo', 'MiTipoDeContenido' ),
		'add_new_item'       => __( 'Añade nuevo MiTipoDeContenido' ),
		'edit_item'          => __( 'Editar MiTipoDeContenido' ),
		'new_item'           => __( 'Nuevo MiTipoDeContenido' ),
		'all_items'          => __( 'Todos MiTipoDeContenido' ),
		'view_item'          => __( 'Ver MiTipoDeContenido' ),
		'search_items'       => __( 'Buscar MiTipoDeContenido' ),
		'not_found'          => __( 'No hay MiTipoDeContenido encontrados' ),
		'not_found_in_trash' => __( 'No hay MiTipoDeContenido encontrados en la papelera' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'MiTipoDeContenido'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Elementos MiTipoDeContenido de Project',
		'public'        => true,
		'menu_position' => 15,
		'supports'      => array( 'title','author','thumbnail','editor','excerpt','comments','revisions','custom-fields' ),
		'has_archive'   => true,
		'rewrite' 		=> array('slug' => 'MiTipoDeContenido'),
		'taxonomies' 	=> array('category','post_tag'),
	);
	register_post_type( 'nombremitipodecontenido', $args );	
}
add_action( 'init', 'cont_nombremitipodecontenido' );


/*--Fin nuevos tipos de contenido--*/


/* ==========================================================================
   Custom-type y categorias
   ========================================================================== */

function namespace_add_custom_types( $query ) {
  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array('nav_menu_item', 'nombreMiTipoDeContenido'));
          return $query;
        }
}
add_filter( 'pre_get_posts', 'namespace_add_custom_types' );
/*--Fin Custom-type y categorias--*/


/* ==========================================================================
   Custom-type y authors archives
   ==========================================================================*/

function custom_post_author_archive($query) {
    if (!is_admin() && $query->is_author)
        $query->set( 'post_type', array('nombreMiTipoDeContenido1', 'nombreMiTipoDeContenido2', 'nombreMiTipoDeContenido3') );
    remove_action( 'pre_get_posts', 'custom_post_author_archive' );
}
add_action('pre_get_posts', 'custom_post_author_archive');
/*--Fin custom-type y authors archives--/


/* ==========================================================================
   Para desaparecer elementos de barra lateral administracion.
   Si necesito algun hacer cambios como administrador, descomentar o comentar.
   Esta funcion y la siguiente desaparecen "visualmente" elementos del dashboard, no modifican
   estructura de WP.
   ========================================================================== */

function example_remove_dashboard_widgets() {
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );      
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );    
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );              
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );  
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );                      
}
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' ); 

function my_remove_menu_pages() {
    remove_menu_page('edit.php'); // Entradas
    //remove_menu_page('upload.php'); // Multimedia
    remove_menu_page('link-manager.php'); // Enlaces
    //remove_menu_page('edit.php?post_type=page'); // Páginas
    remove_menu_page('edit-comments.php'); // Comentarios
    //remove_menu_page('themes.php'); // Apariencia
    remove_submenu_page('themes.php','customize.php');
    remove_submenu_page('themes.php','themes.php');
    remove_submenu_page('themes.php','nav-menus.php');
   	remove_submenu_page('themes.php','theme-editor.php');
    remove_menu_page('plugins.php'); // Plugins
    remove_menu_page('users.php'); // Usuarios
    remove_menu_page('tools.php'); // Herramientas
    remove_menu_page('options-general.php'); // Ajustes
}
add_action('admin_init', 'my_remove_menu_pages');



/* ==========================================================================
   Para desaparecer "post" de barra lateral administracion en caso sea AUTHOR
   ========================================================================== */

function ocultar_entradas() {
        global $menu, $current_user, $wpdb;
        get_currentuserinfo();
        if($current_user->wp_capabilities['author']) {
    global $menu;
    unset($menu[5]);
        }
    }
add_action('admin_menu' , 'ocultar_entradas');
/*--Fin desaparecer post--*/



<?php 
/**
*
* Categories & Tags
*
**/

// New categories
function moarebasicp_cat_map() {
  $labels = array(
    'name'              => __( 'Categorie', 'moarebasicp' ),
    'singular_name'     => __( 'Categorie', 'moarebasicp' ),
    'search_items'      => __( 'Search Categorie', 'moarebasicp' ),
    'all_items'         => __( 'All Categorie', 'moarebasicp' ),
    'parent_item'       => __( 'Parent Categorie', 'moarebasicp' ),
    'parent_item_colon' => __( 'Parent Categorie:', 'moarebasicp' ),
    'edit_item'         => __( 'Edit Categorie', 'moarebasicp' ),
    'update_item'       => __( 'Update Categorie', 'moarebasicp' ),
    'add_new_item'      => __( 'Add New Categorie', 'moarebasicp' ),
    'new_item_name'     => __( 'New Categorie Name', 'moarebasicp' ),
    'menu_name'         => __( 'Categorie', 'moarebasicp' )
  );

  $args = array(
    'hierarchical'      => true, //change if you need a tags = not hierarchy)
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'categories-custom' )
  );

  register_taxonomy( 'categoriescustom', array( 'mycustom' ), $args );
}
add_action( 'init', 'moarebasicp_cat_map', 0 );

// Namespace
function moarebasicp_namespace_add_custom_types( $query ) {
  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array('nav_menu_item', 'mycustom'));
          return $query;
        }
}
add_filter( 'pre_get_posts', 'moarebasicp_namespace_add_custom_types' );

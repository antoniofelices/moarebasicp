<?php 
/**
*
* Categories & Tags
*
**/

// New categories
function smbp_cat_map() {
  $labels = array(
    'name'              => __( 'Categorie', 'smbp' ),
    'singular_name'     => __( 'Categorie', 'smbp' ),
    'search_items'      => __( 'Search Categorie', 'smbp' ),
    'all_items'         => __( 'All Categorie', 'smbp' ),
    'parent_item'       => __( 'Parent Categorie', 'smbp' ),
    'parent_item_colon' => __( 'Parent Categorie:', 'smbp' ),
    'edit_item'         => __( 'Edit Categorie', 'smbp' ),
    'update_item'       => __( 'Update Categorie', 'smbp' ),
    'add_new_item'      => __( 'Add New Categorie', 'smbp' ),
    'new_item_name'     => __( 'New Categorie Name', 'smbp' ),
    'menu_name'         => __( 'Categorie', 'smbp' )
  );

  $args = array(
    'hierarchical'      => true, //change if you need a tags (not hierarchy)
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'categories-custom' )
  );

  register_taxonomy( 'categoriescustom', array( 'mycustom' ), $args );
}
add_action( 'init', 'smbp_cat_map', 0 );

// Namespace
function smbp_namespace_add_custom_types( $query ) {
  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array('nav_menu_item', 'mycustom'));
          return $query;
        }
}
add_filter( 'pre_get_posts', 'smbp_namespace_add_custom_types' );

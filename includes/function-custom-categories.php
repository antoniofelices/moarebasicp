<?php
/**
*
* Categories & Tags
*
**/

// New categories
function moarebasicp_cat_xxx() {

  $labels = array(
    'name'              => __( 'Category', 'moarebasicp' ),
    'singular_name'     => __( 'Category', 'moarebasicp' ),
    'search_items'      => __( 'Search category', 'moarebasicp' ),
    'all_items'         => __( 'All categories', 'moarebasicp' ),
    'parent_item'       => __( 'Parent category', 'moarebasicp' ),
    'parent_item_colon' => __( 'Parent category:', 'moarebasicp' ),
    'edit_item'         => __( 'Edit category', 'moarebasicp' ),
    'update_item'       => __( 'Update category', 'moarebasicp' ),
    'add_new_item'      => __( 'Add New category', 'moarebasicp' ),
    'new_item_name'     => __( 'New category Name', 'moarebasicp' ),
    'menu_name'         => __( 'Categories', 'moarebasicp' )
  );

  $args = array(
    'hierarchical'      => true, //change if you need a tags = not hierarchy
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'categories-custom' )
  );

  register_taxonomy( 'categoriescustom', array( 'mycustom' ), $args );

}

add_action( 'init', 'moarebasicp_cat_xxx', 0 );

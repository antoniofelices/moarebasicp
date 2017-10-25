<?php
/**
*
* Custom taxonomy
*
**/

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
    'hierarchical'      => true, //change if you need a tags = not hierarchy)
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'custom-tax' )
);

register_taxonomy( 'customtax', array( 'mycustom' ), $args );

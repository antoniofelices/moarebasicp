<?php
/**
*
* Custom Post Types
*
**/

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
	'rewrite' 		=> array('slug' => 'mycustom')
);

register_post_type( 'mycustom', $args );

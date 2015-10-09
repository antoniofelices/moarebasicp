<?php 
/**
*
* Custom Post Types
*
**/

// CPT-1
function smbp_cont_xxx() {
	$labels = array(
		'name'               => __( 'mycustom', 'smbp' ),
		'singular_name'      => __( 'mycustom', 'smbp' ),
		'add_new'            => __( 'Add new', 'smbp' ),
		'add_new_item'       => __( 'Add new mycustom', 'smbp' ),
		'edit_item'          => __( 'Edit mycustom', 'smbp' ),
		'new_item'           => __( 'New mycustom', 'smbp' ),
		'all_items'          => __( 'All mycustom', 'smbp' ),
		'view_item'          => __( 'See mycustom', 'smbp' ),
		'search_items'       => __( 'Search mycustom', 'smbp' ),
		'not_found'          => __( 'Not found mycustom', 'smbp' ),
		'not_found_in_trash' => __( 'Not found mycustom in trash', 'smbp' ), 
		'parent_item_colon'  => '',
		'menu_name'          => __( 'MyCustom', 'smbp')
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'My custom type',
		'public'        => true,
		'menu_position' => 15,
		'supports'      => array( 'title','author','thumbnail','editor','excerpt','comments','revisions','custom-fields' ),
		'has_archive'   => true,
		'rewrite' 		=> array('slug' => 'mycustom')
		//'taxonomies' 	=> array('category','post_tag'),sino quiero que comparta categorias
	);
	register_post_type( 'mycustom', $args );	
}
add_action( 'init', 'smbp_cont_xxx' );


// Custom-type y authors archives
function smbp_custom_post_author_archive($query) {
    if (!is_admin() && $query->is_author)
        $query->set( 'post_type', array('mycustom', 'mycustom1', 'mycustom3') );
    remove_action( 'pre_get_posts', 'custom_post_author_archive' );
}
add_action('pre_get_posts', 'smbp_custom_post_author_archive');

// Custom fields added to CPT-1
function smbp_add_metabox_mycustom() {
	if( function_exists( 'add_meta_box' ) ) {
		add_meta_box( 'smbp-metabox', __('Custom fields','smbp'), 'smbp_show_metabox_mycustom', 'mycustom', 'advanced', 'high' );
	}
}
add_action( 'add_meta_boxes_mycustom', 'smbp_add_metabox_mycustom' );

function smbp_show_metabox_mycustom( $post ) {
	// wp_nonce_field( 'smbp_add_metabox_map', 'smbp_meta_box_noncename' );
	$post_meta = get_post_custom($post->ID);

	// Clone if you need more custom-fields
	$current_value = '';
	if( isset( $post_meta['mycustom_field_name'][0] ) ) {
		$current_value = $post_meta['mycustom_field_name'][0];
	}
	?>
	<div class="form-group">
		<label for="field-name"><?php _e('Custom field name', 'smbp'); ?></label>
		<input id="field-name" type="text" name="mycustom_field_name" value="<?php echo esc_attr( $current_value ); ?>" />
		<p class="field-description"><?php _e('Custom field description', 'smbp'); ?></p>
	</div>
<?php 
}

function smbp_save_metabox_mycustom( $post_id, $post ) {

	if ( 'post' == $post->post_type || !current_user_can('edit_post', $post_id) ){
		return;
	}

	/*if ( !isset( $_POST['smbp_meta_box_noncename'] ) || !wp_verify_nonce( $_POST['smbp_meta_box_noncename'], 'smbp_meta_box' ) ) {
		return;
	}*/

	if( isset($_POST['mycustom_field_name']) && $_POST['mycustom_field_name'] != "" ) {
		update_post_meta( $post_id, 'mycustom_field_name', sanitize_text_field( $_POST['mycustom_field_name'] ) );
	} else {
	        //$_POST['mycustom_field_name'] no tiene valor establecido, eliminar el meta field de la base de datos
		if ( isset( $post_id ) ) {
			delete_post_meta($post_id, 'mycustom_field_name');
		}
	}
}
add_action( 'save_post', 'smbp_save_metabox_mycustom', 10, 2 );

/* Paste this inside cpt loop template php == theme
	$custom_fields = get_post_custom();
	if( isset($custom_fields['mycustom_field_name']) ) : ?>
		<span><?php echo $custom_fields['mycustom_field_name'][0]; ?></span>
	<?php 
	endif; 
*/
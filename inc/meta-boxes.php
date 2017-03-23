<?php
/**
 * Flash Theme Customizer.
 *
 * @package Flash
 */


global $flash_page_layout, $flash_metabox_field_transparency;
$flash_page_layout = array(
	'default-layout' => array(
		'id'    => 'flash_page_layout',
		'value' => 'default-layout',
		'label' => esc_html__( 'Default Layout', 'flash' )
	),
	'right-sidebar' => array(
		'id'	=> 'flash_page_layout',
		'value' => 'right-sidebar',
		'label' => esc_html__( 'Right Sidebar', 'flash' )
	),
	'left-sidebar' 	=> array(
		'id'	=> 'flash_page_layout',
		'value' => 'left-sidebar',
		'label' => esc_html__( 'Left Sidebar', 'flash' )
	),
	'full-width' => array(
		'id'	=> 'flash_page_layout',
		'value' => 'full-width',
		'label' => esc_html__( 'Full Width', 'flash' )
	),
	'full-width-center' => array(
		'id'	=> 'flash_page_layout',
		'value' => 'full-width-center',
		'label' => esc_html__( 'Full Width Center', 'flash' )
	)
);

$flash_metabox_field_transparency = array(
	array(
		'id'	=> 'flash_transparency',
		'value' => 'transparent',
		'label' => esc_html__( 'Transparent Header', 'flash' )
	),
	array(
		'id'	=> 'flash_transparency',
		'value' => 'non-transparent',
		'label' => esc_html__( 'Non Transparent Header', 'flash' )
	)
);
add_action( 'add_meta_boxes', 'flash_add_custom_box' );
/**
 * Add Meta Boxes.
 */
function flash_add_custom_box() {
	add_meta_box( 'page-layout', esc_html__( 'Select Layout', 'flash' ), 'flash_layout_call', 'page', 'side', 'default' );
	add_meta_box( 'page-layout', esc_html__( 'Select Layout', 'flash' ), 'flash_layout_call', 'post', 'side', 'default' );
	add_meta_box( 'header-transparency', esc_html__( 'Header Transparency', 'flash' ), 'flash_transparency_call', array('page'), 'side'	);
}
function flash_layout_call() {
	global $flash_page_layout;
	flash_meta_form( $flash_page_layout );
}

function flash_transparency_call() {
	global $flash_metabox_field_transparency;
	flash_meta_form( $flash_metabox_field_transparency );
}


/**
 * Displays metabox to for select layout option
 */
function flash_meta_form( $flash_metabox_field ) {
	global $post;

	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'flash_meta_nonce' );

	foreach ( $flash_metabox_field as $field ) {
		$flash_meta = get_post_meta( $post->ID, $field['id'], true );

		switch( $field['id'] ) {

			// Layout
			case 'flash_page_layout':
				if( empty( $flash_meta ) ) { $flash_meta = 'default-layout'; } ?>

				<input class="post-format" type="radio" name="<?php echo $field['id']; ?>" value="<?php echo $field['value']; ?>" <?php checked( $field['value'], $flash_meta ); ?>/>
				<label class="post-format-icon"><?php echo $field['label']; ?></label><br/>
				<?php

			break;

			// Team Designation
			case 'flash_transparency':
				if( empty( $flash_meta ) ) { $flash_meta = 'non-transparent'; } ?>

				<input class="post-format" type="radio" name="<?php echo $field['id']; ?>" value="<?php echo $field['value']; ?>" <?php checked( $field['value'], $flash_meta ); ?>/>
				<label class="post-format-icon"><?php echo $field['label']; ?></label><br/>
				<?php
			break;
		}
	}
}

add_action('save_post', 'flash_save_custom_meta');
/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function flash_save_custom_meta( $post_id ) {
	global $flash_page_layout, $flash_metabox_field_transparency, $post;

	// Verify the nonce before proceeding.
   if ( !isset( $_POST[ 'flash_meta_nonce' ] ) || !wp_verify_nonce( $_POST[ 'flash_meta_nonce' ], basename( __FILE__ ) ) )
		return;

	// Stop WP from clearing custom fields on autosave
   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
		return;

	if ('page' == $_POST['post_type']) {
		if (!current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	}
	elseif (!current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	foreach ( $flash_page_layout as $field ) {
		//Execute this saving function
		$old = get_post_meta( $post_id, $field['id'], true);
		$new = sanitize_text_field($_POST[$field['id']]);
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach

	// loop through fields and save the data
	foreach ( $flash_metabox_field_transparency as $field ) {
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = ( isset( $_POST[$field['id']] ) ? sanitize_text_field( $_POST[$field['id']] ) : '' );
		if ($new && $new != $old) {
			update_post_meta( $post_id,$field['id'],$new );
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}

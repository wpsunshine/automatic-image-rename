<?php
/**
 * Plugin Name: Automatic Image Rename
 * Description: Improve your image SEO by automatically renaming files and avoiding ugly, random
 * Version: 1.0
 * Author: WP Sunshine
 * Author URL: https://wpsunshine.com
 */

add_action( 'wp_handle_upload_prefilter', 'wps_air_rename_attachment' );

function wps_air_rename_attachment( $file ) {

    // Check if we have a post and a post parent ID
    if ( isset( $_REQUEST['post_id'] ) ) {
        $post_id = $_REQUEST['post_id'];
        if ( $post_id == 0 ) {
            return $file;
        }

		$post = get_post( $post_id );

        // Get the parent post type
        $parent_post_type = get_post_type( $post_id );

        // Get the selected post types from the settings
        $selected_post_types = get_option( 'wps_air_post_types', array() );

        // If parent post type is not in the selected post types, return the file without modification
        if ( ! in_array( $parent_post_type, $selected_post_types ) ) {
			return $file;
		}

        // Get the prefix from the settings
        $prefix = get_option( 'wps_air_prefix', '' );

        // Get the delimiter from the settings
        $delimiter = get_option( 'wps_air_delimiter', '-' );

        // Get post data and use it in the file name
		if ( $post->post_name ) {
			$filetitle = $post->post_name;
		} elseif ( $post->post_title ) {
			$filetitle = $post->post_title;
		} else {
			$metadata = wp_read_image_metadata( $file['tmp_name'] );
            if ( $metadata ) {
                if ( ! empty( $metadata['title'] ) ) {
                    $filetitle = sanitize_title( $metadata['title'] );
                }
            }
		}

		$filetitle = $prefix . '-' . $filetitle;

        // Get extension
        $path_parts = pathinfo( $file['name'] );
        $extension = $path_parts['extension'];

        // Construct the new name
        $new_filename = $filetitle . '.' . $extension;
        $file['name'] = $new_filename;
    }

    return $file;

}

add_action( 'admin_init', 'wps_air_media_settings' );
function wps_air_media_settings() {

    // Add a settings section.
    add_settings_section(
        'wps_air',
        'Automatic Image Renaming',
        '',
        'media'
    );

    // Add a settings field for post types.
    add_settings_field(
        'wps_air_post_types',
        'Apply to Post Types',
        'wps_air_media_setting_callback',
        'media',
        'wps_air'
    );

    // Register the settings field.
    register_setting(
        'media',
        'wps_air_post_types'
    );

	// Add a settings field for the prefix.
    add_settings_field(
        'wps_air_prefix',
        'Prefix for Image Filenames',
        'wps_air_media_setting_callback_prefix',
        'media',
        'wps_air'
    );

    // Register the settings field.
    register_setting(
        'media',
        'wps_air_prefix',
    );

}

function wps_air_media_setting_callback() {

    // Get the current settings from the db.
    $options = get_option( 'wps_air_post_types', array() );

    // Get all public post types.
    $post_types = get_post_types( array( 'public' => true ) );

    // Iterate over all public post types
    foreach ( $post_types as $post_type ) {

		// Skip attachments as that wouldn't make sense here.
		if ( $post_type == 'attachment' ) {
			continue;
		}

        // Get post type object for label
        $post_type_obj = get_post_type_object( $post_type );

        // Check if the current post type is selected.
        $checked = in_array( $post_type, $options ) ? 'checked' : '';

        // Output the checkbox for the current post type.
        echo '<label><input type="checkbox" name="wps_air_post_types[]" value="' . esc_attr( $post_type ) . '" ' . esc_attr( $checked ) . '> ' . esc_html( $post_type_obj->labels->name ) . '</label><br>';
    }

}

function wps_air_media_setting_callback_prefix() {

    // Get the current prefix from the db.
    $prefix = get_option( 'wps_air_prefix', '' );

    // Output the input field for the prefix
    echo '<input type="text" name="wps_air_prefix" value="' . esc_attr( $prefix ) . '">';

}

<?php

/*
Plugin Name: Vips FFI Image Editor
Plugin URI: https://github.com/notglossy/vips-image-editor-ffi
Description: High performance WordPress image processing with Vips using PHP FFI.
Version: 2.0.0
Author: Not Glossy
Author URI: https://github.com/notglossy/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

add_action( 'admin_notices', function() {
    if ( ! extension_loaded( 'ffi' ) ) {
        echo '<div class="notice notice-warning"><p>';
        echo __( "FFI PHP extension is not loaded. VIPS image editor can't function without it. VIPS editor has been disabled.", 'vips-image-editor' );
        echo '</p></div>';
    }
} );

function image_editors_add_vips_ffi( $editors ) {
	
    if ( ! class_exists( 'Image_Editor_Vips_FFI' ) ) {
        
        // Check if we are using local Composer
        if ( file_exists( __DIR__ . '/vendor' ) ) {
            require __DIR__ . '/vendor/autoload.php';
        }

        include_once 'editors/vips-ffi.php';

    }
		
	if ( ! in_array( 'Image_Editor_Vips_FFI', $editors ) )
		array_unshift( $editors, 'Image_Editor_Vips_FFI' );

	return $editors;
}

add_filter( 'wp_image_editors', 'image_editors_add_vips_ffi' );

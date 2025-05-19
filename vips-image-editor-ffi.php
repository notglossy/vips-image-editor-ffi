<?php
/**
 * Plugin Name: Vips FFI Image Editor
 * Plugin URI: https://github.com/notglossy/vips-image-editor-ffi
 * Description: High performance WordPress image processing with Vips using PHP FFI.
 * Version: 3.0.0
 * Author: Not Glossy
 * Author URI: https://github.com/notglossy/
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: vips-image-editor
 * Requires PHP: 8.2
 * Requires at least: 6.0
 * Tested up to: 6.8.1
 *
 * @package NotGlossy\VipsImageEditorFFI
 */

namespace NotGlossy\VipsImageEditorFFI;

// exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

add_action(
	'admin_notices',
	function () {
		if ( ! extension_loaded( 'ffi' ) ) {
			echo '<div class="notice notice-warning"><p>';
			echo esc_html( __( "FFI PHP extension is not loaded. VIPS image editor can't function without it. VIPS editor has been disabled.", 'vips-image-editor' ) );
			echo '</p></div>';
		}
	}
);

/**
 * Adds the Vips FFI image editor to the list of available image editors.
 *
 * @param array $editors List of available image editor classes.
 * @return array Updated list of image editor classes.
 */
function image_editors_add_vips_ffi( $editors ) {

	if ( ! class_exists( __NAMESPACE__ . '\\Image_Editor_Vips_FFI' ) ) {

		include_once __DIR__ . '/classes/class-image-editor-vips-ffi.php';

	}

	$editor_class = __NAMESPACE__ . '\\Image_Editor_Vips_FFI';

	if ( ! in_array( $editor_class, $editors, true ) ) {
		array_unshift( $editors, $editor_class );
	}

	return $editors;
}

/**
 * Initialize the plugin
 */
function init() {

	// Check if we are using local Composer.
	if ( file_exists( __DIR__ . '/vendor' ) ) {
		require __DIR__ . '/vendor/autoload.php';
	}

	// Include Format_Support helper class.
	include_once __DIR__ . '/classes/class-format-support.php';
}

// Initialize the plugin.
add_action( 'plugins_loaded', __NAMESPACE__ . '\\init' );

// Use WordPress add_filter function from global namespace.
\add_filter( 'wp_image_editors', __NAMESPACE__ . '\\image_editors_add_vips_ffi' );

<?php
/**
 * This file contains the Format_Support class, which provides methods to check
 * for support of various image formats using the libvips library.
 *
 * @package VipsImageEditorFFI
 */

namespace NotGlossy\VipsImageEditorFFI;

/**
 * Helper class to check for HEIF/HEIC support
 */
class Format_Support {

	/**
	 * Check if the server's libvips has HEIF support
	 *
	 * @return bool Whether HEIF is supported
	 */
	public static function has_heif_support() {
		try {
			// Try to find the heif loader in vips.
			$all_loaders = \Jcupitt\Vips\Image::findLoad( '.heic' );

			// If we don't get an exception and the loader exists, heif is supported.
			return ! empty( $all_loaders );
		} catch ( \Exception $e ) {
			return false;
		}
	}

	/**
	 * Check if a specific MIME type is supported by the current vips installation
	 *
	 * @param string $mime_type The MIME type to check.
	 * @return bool Whether the format is supported
	 */
	public static function is_format_supported( $mime_type ) {
		static $supported_cache = array();

		// Return cached result if available.
		if ( isset( $supported_cache[ $mime_type ] ) ) {
			return $supported_cache[ $mime_type ];
		}

		$supported = false;

		switch ( $mime_type ) {
			case 'image/jpeg':
			case 'image/png':
			case 'image/gif':
			case 'image/webp':
				$supported = true;
				break;

			case 'image/heic':
			case 'image/heif':
				$supported = self::has_heif_support();
				break;

			case 'image/avif':
				$supported = true;
				break;

			case 'image/jxl':
				$supported = true;
				break;
		}

		// Cache the result.
		$supported_cache[ $mime_type ] = $supported;

		return $supported;
	}
}

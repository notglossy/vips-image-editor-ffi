<?php
/**
 * This file contains the Format_Support class, which provides methods to check
 * for support of various image formats using the libvips library.
 *
 * @package VipsImageEditorFFI
 */

namespace NotGlossy\VipsImageEditorFFI;

/**
 * Helper class to check for image format support via libvips.
 */
class Format_Support {

	/**
	 * Map of MIME types to file extensions used to probe libvips for format support.
	 *
	 * @var array<string, string>
	 */
	private static $mime_to_ext = array(
		'image/jpeg' => '.jpg',
		'image/png'  => '.png',
		'image/gif'  => '.gif',
		'image/webp' => '.webp',
		'image/heic' => '.heic',
		'image/heif' => '.heif',
		'image/avif' => '.avif',
		'image/jxl'  => '.jxl',
	);

	/**
	 * Check if a specific MIME type is supported by the current vips installation.
	 *
	 * Uses vips_foreign_find_save_buffer() to query libvips for available format
	 * support by suffix matching. This is more reliable than findLoad() which
	 * requires an actual file to sniff.
	 *
	 * @param string $mime_type The MIME type to check.
	 * @return bool Whether the format is supported.
	 */
	public static function is_format_supported( $mime_type ) {
		static $supported_cache = array();

		// Return cached result if available.
		if ( isset( $supported_cache[ $mime_type ] ) ) {
			return $supported_cache[ $mime_type ];
		}

		$supported = false;

		if ( isset( self::$mime_to_ext[ $mime_type ] ) ) {
			$ext = self::$mime_to_ext[ $mime_type ];
			try {
				$saver     = \Jcupitt\Vips\FFI::vips()->vips_foreign_find_save_buffer( $ext );
				$supported = ! empty( $saver );

				// Some libvips versions don't register .avif as a buffer saver suffix.
				// Fall back to testing actual AV1 compression with a tiny image, since
				// the HEIF module may exist but only support HEVC (not AV1).
				if ( ! $supported && 'image/avif' === $mime_type ) {
					$supported = self::test_heif_compression( \Jcupitt\Vips\ForeignHeifCompression::AV1 );
				}
			} catch ( \Exception $e ) {
				$supported = false;
			}
		}

		// Cache the result.
		$supported_cache[ $mime_type ] = $supported;

		return $supported;
	}

	/**
	 * Test if a specific HEIF compression type is supported by attempting
	 * to encode a tiny 1x1 image.
	 *
	 * @param string $compression A ForeignHeifCompression enum value (e.g. 'av1', 'hevc').
	 * @return bool Whether the compression type is supported.
	 */
	private static function test_heif_compression( $compression ) {
		try {
			$test_image = \Jcupitt\Vips\Image::black( 1, 1 );
			$test_image->heifsave_buffer( array( 'compression' => $compression ) );
			return true;
		} catch ( \Exception $e ) {
			return false;
		}
	}
}

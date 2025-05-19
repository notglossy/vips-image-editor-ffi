=== VIPS Image Editor (PHP FFI) ===
Contributors: notglossy
Tags: vips, image, ffi, webp, heic, avif, jxl, raspberry pi, low memory, performance
Requires at least: 6.0.0
Tested up to: 6.8.1
Requires PHP: 8.2.0
Stable tag: 3.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

High performance WordPress image processing with VIPS using PHP FFI. Ideal for low-powered devices like Raspberry Pi.

== Description ==

VIPS Image Editor leverages the libvips image processing library through PHP's Foreign Function Interface (FFI) to provide high-performance image processing for WordPress.

**Features:**

* Extremely fast image processing - up to 10x faster than GD or ImageMagick
* Memory efficient - processes images in streams without loading the entire image into memory
* Ideal for low-powered devices like Raspberry Pi, shared hosting, or budget VPS instances
* Support for modern image formats:
  * JPEG, PNG, GIF (traditional formats)
  * WebP (Google's efficient web format)
  * AVIF (AV1 Image File Format)
  * HEIC/HEIF (High Efficiency Image Formats used by iOS)
  * JXL (JPEG XL)
* Properly namespaced code in the `NotGlossy\VipsImageEditorFFI` namespace
* Extensive code quality tools integration (Psalm, PHPCS)

This plugin is ideal for sites with many images or sites using modern image formats.

**Performance on Raspberry Pi and Low-Powered Devices:**

VIPS significantly outperforms other image processing libraries on resource-constrained hardware:

* **Memory Usage**: VIPS processes images in small chunks rather than loading the entire image into memory, making it possible to handle large images on devices with limited RAM
* **Processing Speed**: Even on single-board computers like Raspberry Pi, VIPS can resize images 3-5x faster than ImageMagick
* **Real-world Benefits**:
  * WordPress sites on Raspberry Pi can handle image uploads without running out of memory
  * Shared hosting environments can process larger images without hitting resource limits
  * Reduced CPU usage means less throttling on resource-constrained environments

If you're running WordPress on a Raspberry Pi home server, low-cost VPS, or shared hosting with strict memory limits, this plugin can dramatically improve your site's performance and reliability.

== Installation ==

1. Install the libvips package on your server:
   * Ubuntu/Debian: `apt install libvips42`
   * CentOS/RHEL: `yum install vips`
   * For HEIC/HEIF support, also install: `apt install libheif-dev` (Ubuntu/Debian)

2. Ensure PHP's FFI extension is enabled in your php.ini

3. Upload the plugin files to the `/wp-content/plugins/vips-image-editor-ffi` directory

4. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= Will this plugin work with shared hosting? =

This plugin requires the libvips library to be installed on the server, which may not be available on shared hosting. Check with your hosting provider.

= Does this support WebP, AVIF, HEIC, and other modern formats? =

Yes! The plugin supports JPEG, PNG, GIF, WebP, AVIF, HEIC/HEIF (with proper libvips support), and JXL. Support for some formats depends on your server's libvips configuration.

= How do I check if my server supports HEIC/HEIF? =

You can use this PHP code to check if your libvips installation supports HEIC/HEIF:

```php
if (class_exists('\\NotGlossy\\VipsImageEditorFFI\\Format_Support')) {
    $has_heif = \NotGlossy\VipsImageEditorFFI\Format_Support::has_heif_support();
    echo $has_heif ? 'HEIF support: Yes' : 'HEIF support: No';
}
```

= Does this plugin really work well on Raspberry Pi? =

Yes! VIPS is specifically designed to be memory efficient, which makes it ideal for Raspberry Pi and other single-board computers with limited RAM. Users have reported excellent results with WordPress running on Raspberry Pi 3 and 4 models.

= How much memory does VIPS save compared to other image processors? =

VIPS typically uses 5-10x less memory than ImageMagick and GD. For example, processing a 20MP image might require 300-400MB with ImageMagick but only 40-50MB with VIPS. This makes a huge difference on devices with 1GB RAM or less.

= I'm on a budget VPS with limited resources. Will this help? =

Absolutely. If you're on a VPS with limited CPU and memory, VIPS can dramatically improve your site's performance when processing images. This is especially noticeable when generating thumbnails for large images or when multiple image processing operations happen simultaneously.

== Changelog ==

= 3.0.0 =
* Feature: Added proper namespacing using `NotGlossy\VipsImageEditorFFI`
* Feature: Added support for WebP, HEIC, and HEIF formats
* Feature: Added automatic runtime detection of format support
* Feature: Added code quality tools (Psalm, PHP_CodeSniffer)
* Fix: Fixed duplicate case in stream() function for image/jxl
* Change: Updated filter prefix to 'notglossy_vips_image_editor' from 'vips_ie'

= 2.0.0 =
* Forked from original VIPS php extension version of the plugin.
* Feature: Modified to work with the new v2.0 FFI based VIPS binding.
* Feature: Default to Vips thumbnail since it is supported by all versions of Vips compatible with FFI.
* Fix: Fixed issue with WP_Image_Editor::maybe_exif_rotate(), where WordPress would uneccesarily attempt to rotate JPG images.
* Fix: Added `$filesize` value to returned array when saving file (new in WordPress 6.0.0)

= 1.1.0 =
* Feature: vips thumbnail is used instead of resize if vips version is newer than 8.6.0 for faster resizing
* Fix: Fixed issue where error was not handled correctly if target size was larger than image size
* Fix: Disabled vips cache by default since it took up more memory without any performance benefits

= 1.0.3 =
* Fix Bedrock compatibility

= 1.0.2 =
* Add package name to composer.json

= 1.0.1 =
* Add WordPress readme.txt

= 1.0.0 =
* Initial release

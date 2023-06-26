=== VIPS Image Editor (PHP FFI) ===
Contributors: notglossy
Tags: vips, image, ffi
Requires at least: 6.0.0
Tested up to: 6.2.2
Requires PHP: 7.4.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

High performance WordPress image processing with VIPS using PHP FFI.

== Changelog ==

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

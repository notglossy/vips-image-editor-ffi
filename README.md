# Vips Image Editor WordPress Plugin

High performance WordPress image processing with [VIPS](https://libvips.github.io/libvips/).

## Features

* Uses PHP FFI for high-performance image processing
* Extremely memory-efficient - perfect for low-powered devices like Raspberry Pi
* Namespace-based code organization (`NotGlossy\VipsImageEditorFFI`)
* Support for multiple image formats:
  * JPEG
  * PNG
  * GIF
  * WebP
  * AVIF
  * HEIC/HEIF (with proper libvips support)
  * JXL (JPEG XL)
* Code quality tools integration (Psalm, PHP_CodeSniffer)

## Requirements

* PHP 8.2 or later
* libvips package installed on your Linux system
* FFI PHP extension

## Installation
 
1. Install vips on your system. On Ubuntu, this can be done using `apt install libvips42`
2. Download the latest plugin version from the [releases tab](https://github.com/notglossy/vips-image-editor-ffi/releases)
3. Extract the plugin under `wp-content/plugins`
4. Enable the plugin in WordPress admin interface

## Performance on Low-Powered Devices

VIPS is exceptionally well-suited for low-powered computing environments like Raspberry Pi, shared hosting, or resource-constrained VPS instances:

* **Memory Efficiency**: VIPS processes images in small chunks rather than loading entire images into memory. On a Raspberry Pi with limited RAM, this means you can process much larger images than with GD or ImageMagick.

* **Sequential Processing**: VIPS uses a streaming architecture that loads, processes, and saves images in sequence, requiring only enough memory for the current processing strip.

* **Comparative Benchmarks**:
  * On a Raspberry Pi 4 (4GB), VIPS can resize a 20MP image up to 3-4x faster than ImageMagick while using 5-8x less memory
  * Even on Raspberry Pi Zero with just 512MB RAM, VIPS can process images that would cause out-of-memory errors with other libraries

* **CPU Efficiency**: VIPS is designed to efficiently use multiple cores but also performs well on single-core systems by minimizing CPU cache misses

This plugin is ideal for WordPress sites running on Raspberry Pi home servers, low-cost VPS instances, or any environment where memory and CPU resources are limited.

## Advanced Format Support

For HEIC/HEIF support, ensure your server's libvips installation was compiled with HEIF support:
- Install libheif: `apt install libheif-dev` (Ubuntu/Debian)
- Ensure libvips was compiled with `--with-heif` flag

## Development

This plugin uses Composer for dependency management and development tools:

```bash
# Install dependencies
composer install

# Run code quality checks
composer psalm   # Run Psalm static analysis
composer phpcs   # Run WordPress coding standards checks
```

## License

GPLv3 or later - see [License](http://www.gnu.org/licenses/gpl-3.0.html)

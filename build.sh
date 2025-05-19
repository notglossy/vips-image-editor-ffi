#!/usr/bin/env bash

# Exit if any command fails
set -e

# Plugin information
PLUGIN_NAME="vips-image-editor-ffi"
PLUGIN_VERSION=$(grep "Version:" vips-image-editor-ffi.php | awk -F' ' '{print $3}')
PLUGIN_VERSION=${PLUGIN_VERSION:-"3.0.0"}
OUTPUT_DIR="./dist"
BUILD_DIR="$OUTPUT_DIR/build/$PLUGIN_NAME"
ZIP_FILE="$OUTPUT_DIR/$PLUGIN_NAME-$PLUGIN_VERSION.zip"

# Make sure we have composer
if ! command -v composer &> /dev/null; then
    echo "Composer is required but could not be found"
    exit 1
fi

# Check if zip command is available
if ! command -v zip &> /dev/null; then
    echo "zip command is required but could not be found"
    exit 1
fi

# Create build directories
echo "Creating build directories..."
rm -rf "$OUTPUT_DIR"
mkdir -p "$BUILD_DIR"


# Copy distribution composer file
echo "Setting up distribution composer configuration..."
cp composer.dist.json "$BUILD_DIR/composer.json"

# Copy plugin files
echo "Copying plugin files..."
cp -r classes "$BUILD_DIR/"
cp vips-image-editor-ffi.php "$BUILD_DIR/"
cp README.md "$BUILD_DIR/"
cp readme.txt "$BUILD_DIR/"
cp LICENSE "$BUILD_DIR/"

# Install dependencies
echo "Installing dependencies..."
cd "$BUILD_DIR"
composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction --no-progress
cd -

# Remove composer files
echo "Cleaning up composer files..."
rm "$BUILD_DIR/composer.json"
rm "$BUILD_DIR/composer.lock"

# Create zip file
echo "Creating zip file..."
cd "$OUTPUT_DIR/build"
zip -r "../$PLUGIN_NAME-$PLUGIN_VERSION.zip" "$PLUGIN_NAME" -x "*.git*" -x "*.github*" -x "*phpcs*" -x "*.DS_Store" -x "*__MACOSX*" -x "*.vscode*"
cd -

# Cleanup build directory
echo "Cleaning up..."
rm -rf "$OUTPUT_DIR/build"

# Success message
echo "Package created successfully: $ZIP_FILE"
echo "Plugin version: $PLUGIN_VERSION"

exit 0

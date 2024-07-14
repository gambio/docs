#!/bin/bash

# -----------------------------------------------------------------------------
# DEVELOPERS.GAMBIO.DE
#
# Execute this script to produce API documentation for each code section of the
# application. This script is using various libraries to generate documentation
# that originates directly from the doc-block comments of the source code.
#
# There are some cases though where the documentation comes from other sources,
# like CSS and unit test coverage.
# The REST API documentation is concatenated from YAML files found
# under REST/swagger/ within this script's directory.
#
# If one of the following commands fail that might be possibly due to an error
# in the source comments that crashes the generators. Read the console logs for
# further info on troubleshooting.
# -----------------------------------------------------------------------------

# move to the directory of the script (dirname tool needs to be installed)
cd "$(dirname "$0")"

# initialize
DEST="developers.gambio.de"
cd ..
rm -rf $DEST
mkdir $DEST
cp -r src/JSEngine/node_modules/developers.gambio.de/dist/* $DEST/

# tutorials
mkdir $DEST/docs/tutorials
cp -r docs/Tutorials/* $DEST/docs/tutorials

# REST (swagger/dapperdox)
node src/JSEngine/node_modules/dapperdox-gx/dapperdox-gx.js -y docs/REST/swagger/ -d $DEST/docs/rest -c docs/REST/dapperdox

# jsdoc
src/JSEngine/node_modules/.bin/jsdoc -r \
    "src/JSEngine/libs" \
    "src/JSEngine/extensions" \
    "src/admin/javascript/engine/extensions" \
    "src/admin/javascript/engine/widgets" \
    "src/admin/javascript/engine/libs" \
    "src/templates/Honeygrid/javascript/engine/libs" \
     -d "$DEST/docs/jsdoc" \
     -c "src/JSEngine/node_modules/jsdoc-gx/JSDocConfiguration.json" \
     --readme "src/JSEngine/node_modules/jsdoc-gx/JSEngine.md"

# phpdoc
php docs/PHP/phpdoc.phar -d "src/GXEngine" -d "src/GXMainComponents" -t "$DEST/docs/phpdoc"
find $DEST/docs/phpdoc -name "phpdoc-cache*" -delete


# gx-admin-css
cp -r docs/CSS/gx-admin-css $DEST/docs
cp src/admin/html/assets/styles/compatibility.min.css $DEST/docs/gx-admin-css/assets/styles/compatibility.min.css
cp src/admin/html/assets/styles/compatibility-vendor.min.css $DEST/docs/gx-admin-css/assets/styles/gx-admin-vendor.min.css
cp src/admin/html/assets/styles/legacy/global-colorpicker.css $DEST/docs/gx-admin-css/assets/styles/global-colorpicker.css
cp src/admin/html/assets/javascript/compatibility-vendor.min.js $DEST/docs/gx-admin-css/assets/scripts/admin-vendor.min.js
cp -r src/admin/includes/ckeditor $DEST/docs/gx-admin-css/assets/ext/ckeditor
cp -r src/admin/html/assets/javascript/engine $DEST/docs/gx-admin-css/assets/modules
cp -r src/admin/html/assets/images/datatables $DEST/docs/gx-admin-css/assets/images
mkdir $DEST/docs/gx-admin-css/assets/jse
cp -r src/JSEngine/build $DEST/docs/gx-admin-css/assets/jse

# Online Manual
node src/JSEngine/node_modules/online-manual/install.js $DEST/docs/

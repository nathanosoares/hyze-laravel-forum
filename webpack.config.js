/**
 * The Path module.
 */
const path = require('path');

/**
 * Custom Webpack config.
 *
 * Described here, in the separate file, for the IDE support.
 *
 * @see https://gist.github.com/nachodd/4e120492a5ddd56360e8cff9595753ae
 */
module.exports = {
    resolve: {
        alias: {
            "@components": path.resolve(
                __dirname,
                "resources/forum/js/components"
            ),
            "@views": path.resolve(
                __dirname,
                "resources/forum/js/views"
            ),
            "@store": path.resolve(
                __dirname,
                "resources/forum/js/store"
            )
        }
    }
};
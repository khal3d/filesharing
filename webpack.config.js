var Encore = require('@symfony/webpack-encore');

Encore
// The project directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // The public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

    // Create hashed filenames (e.g. app.abc123.css)
    .enableVersioning()

    // Will create public/build/app.js and public/build/app.scss
    .addEntry('app', './assets/js/app.js')

    // Allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    // Enable source maps during development
    .enableSourceMaps(!Encore.isProduction())

    // Empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // allow SASS/SCSS files to be processed
    .enableSassLoader(function(options) {
    })

    .autoProvidejQuery()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();

const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', [
        './assets/js/app.js',
        './node_modules/jquery/dist/jquery.min.js'
    ])

    .cleanupOutputBeforeBuild()
    .autoProvidejQuery()
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
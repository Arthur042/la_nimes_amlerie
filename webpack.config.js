const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('script', './assets/script/index.ts')
    .addStyleEntry('style', './assets/style/index.scss')
    .copyFiles([
        {from: './assets/images', to: 'images/[path][name].[ext]'},
        {from: './assets/images/caroussel', to: 'images/caroussel/[path][name].[ext]'},
        {from: './assets/images/header', to: 'images/header/[path][name].[ext]'},
        {from: './assets/images/mark', to: 'images/mark/[path][name].[ext]'},
        {from: './assets/images/opinion', to: 'images/opinion/[path][name].[ext]'},
        {from: './assets/images/product_item', to: 'images/product_item/[path][name].[ext]'},
        {from: './assets/images/icon', to: 'images/icon/[path][name].[ext]'},
        {from: './assets/images/icon/connection', to: 'images/icon/connection/[path][name].[ext]'},
        {from: './assets/images/icon/footer', to: 'images/icon/footer/[path][name].[ext]'},
        {from: './assets/images/icon/header', to: 'images/icon/header/[path][name].[ext]'},
        {from: './assets/images/icon/offCanva', to: 'images/icon/offCanva/[path][name].[ext]'},
        {from: './assets/images/icon/panier', to: 'images/icon/panier/[path][name].[ext]'},
        {from: './assets/images/icon/product', to: 'images/icon/product/[path][name].[ext]'},
        {from: './assets/images/icon/reassurant', to: 'images/icon/reassurant/[path][name].[ext]'},


    ])

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    .enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();

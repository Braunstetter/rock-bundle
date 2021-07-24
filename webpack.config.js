let Encore = require('@symfony/webpack-encore');
// process.env.NODE_ENV = Encore.isProduction() ? 'production' : 'development';

const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'production');
}

if(Encore.isProduction()) {
    Encore.setOutputPath('./src/Resources/public/')
} else {
    Encore.setOutputPath('./../../../Sites/Agency/braunstetter/public/bundles/rock')
}

Encore
    // .copyFiles({
    //     from: './src/Assets/images',
    //     to: 'images/[path][name].[ext]',
    // })

    .setPublicPath('/')
    .setManifestKeyPrefix('bundles/rock')
    .addStyleEntry('tailwind', './src/Assets/css/tailwind.css')
    // .addStyleEntry('base-form', './src/Assets/css/base-form.css')
    .splitEntryChunks()

    .enableSingleRuntimeChunk()

    .configureBabel((babelConfig) => {
        if (Encore.isProduction()) {
            babelConfig.plugins.push(
                'transform-react-remove-prop-types'
            );

            babelConfig.plugins.push('@babel/plugin-proposal-object-rest-spread');
            babelConfig.plugins.push('@babel/plugin-proposal-class-properties');
        }
    })

    .cleanupOutputBeforeBuild()
    // .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())

    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    .enablePostCssLoader((options) => {
        options.postcssOptions = {
            path: './postcss.config.js'
        };
    });

const backend = Encore.getWebpackConfig();
backend.name = 'backend';
// reset Encore to build the second config
Encore.reset();

module.exports = [backend];

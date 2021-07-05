const mix = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin');
const useHttps = process.env.MIX_WEBPACK_HTTPS === 'enabled';

//
const SSL = () => {
    if (!process.env.SSL_CERT && !process.env.SSL_KEY) {
        return {
            key: `${process.env.MIX_SECURE_PATH}${process.env.MIX_HOST}.key`,
            cert: `${process.env.MIX_SECURE_PATH}${process.env.MIX_HOST}.crt`,
        };
    }
    return {
        key: process.env.SSL_KEY,
        cert: process.env.SSL_CERT
    };
};

browserSync.init({
    injectChanges: false,
    host: process.env.MIX_HOST,
    proxy: `https://${process.env.MIX_HOST}`,
    open: "external",
    files: [
        "web/assets/css/{*,**/*}.css",
        "web/assets/js/{*,**/*}.js",
        "templates/{*,**/*}.twig",
    ],
    https: {
        key: `${process.env.MIX_SECURE_PATH}${process.env.MIX_HOST}.key`,
        cert: `${process.env.MIX_SECURE_PATH}${process.env.MIX_HOST}.crt`,
    },
});

const browserSyncConfig = {
    injectChanges: false,
    host: process.env.MIX_HOST,
    proxy: `https://${process.env.MIX_HOST}`,
    open: 'external',
    files: ['web/assets/css/{*,**/*}.css', 'web/assets/js/{*,**/*}.js', 'templates/{*,**/*}.twig']
};

if (useHttps) {
    browserSyncConfig.https = SSL();
}

mix
    .setPublicPath(path.normalize('./web'))
    .js('src/js/app.js', 'assets/js')
    .sass('src/scss/app.scss', 'assets/css')
    .copy('src/assets/', 'web/assets')
    .browserSync(browserSyncConfig)
    .extract()
    .version();

mix.webpackConfig({
    plugins: [
        new CompressionPlugin({
            filename: '[path].gz[query]',
            algorithm: 'gzip',
            test: /\.(js|css|html|svg)$/,
            minRatio: 1,
            deleteOriginalAssets: false
        })
    ]
});

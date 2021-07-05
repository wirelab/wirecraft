const mix = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin');
const homedir = require('os').homedir();
const useHttps = true;

const SSL = () => {
    if (!process.env.SSL_CERT && !process.env.SSL_KEY) {
        return {
            key: homedir + '/.config/valet/Certificates/' + process.env.PROJECT_NAME + '.key',
            cert: homedir + '/.config/valet/Certificates/' + process.env.PROJECT_NAME + '.crt'
        };
    }
    return {
        key: process.env.SSL_KEY,
        cert: process.env.SSL_CERT
    };
};

const browserSyncConfig = {
    injectChanges: false,
    host: process.env.PROJECT_NAME,
    proxy: 'https://' + process.env.PROJECT_NAME,
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

const mix = require('laravel-mix');
require('dotenv').config();

// The BrowserSync proxy url. If you use npm run serve this is fine,
// If you use valet to host you need to change the url
// to the right url in your environment variables.
let browserSyncProxy =
    process.env.BROWSERSYNC_PROXY === undefined ?
        'http://localhost:1422/' :
        process.env.BROWSERSYNC_PROXY;

// The main mix setup here.
mix.setPublicPath(path.normalize('./web'))
    .js('src/js/app.js', 'assets/js')
    .sass('src/scss/app.scss', 'assets/css')

    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    loader: "ts-loader",
                    exclude: /node_modules/
                }
            ]
        },
        resolve: {
            modules: [
                "node_modules",
                path.resolve(__dirname, 'src/ts')
            ],
            alias: {
                "@": path.resolve(__dirname, 'src/ts/'),
            },
            extensions: ["*", ".js", ".jsx", ".vue", ".ts", ".tsx"]
        }
    })

    // Copy folders
    .copy('src/favicon', 'web/assets/favicon')
    .copy('src/fonts', 'web/assets/fonts')
    .copy('src/icons', 'web/assets/icons')
    .copy('src/img', 'web/assets/img')
    .copy('src/logos', 'web/assets/logos')
    .copy('src/videos', 'web/assets/videos')

    // Browser sync
    .browserSync({
        injectChanges: false,
        open: "local",
        proxy: browserSyncProxy,
        ui: {
            port: 3000
        },
        port: 1423,
        notify: false,
        files: [
            "web/assets/css/{*,**/*}.css",
            "web/assets/js/{*,**/*}.js",
            "templates/{*,**/*}.twig",
        ],
    })
    .version();

// Run a dev server if we run the serve command
if (process.env.SERVE === "true") {
    const Connect = require('gulp-connect-php');

    Connect.server({
        base: './web',
        port: 1422,
        keepalive: true
    });
}
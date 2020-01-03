const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const Connect = require("gulp-connect-php");
const merge = require("webpack-merge");
const common = require("./webpack.common");

const configureDevServer = function() {
  Connect.server({
    base: "./web",
    port: 1422,
    keepalive: true
  });

  return new BrowserSyncPlugin({
    proxy: "localhost:1422",
    port: 1422,
    notify: false,
    files: ["./templates/**/*.twig"]
  });
};

module.exports = env => {
  env = env || {};

  return merge(common(env), {
    mode: "development",
    devtool: "inline-source-map",
    plugins: [new configureDevServer()]
  });
};

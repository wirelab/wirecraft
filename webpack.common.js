const path = require("path");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const BundleAnalyzerPlugin = require("webpack-bundle-analyzer")
  .BundleAnalyzerPlugin;

const rootEntry = "./src/js/app.js";
const cleanFiles = [
  "./web/assets/*.js",
  "./web/assets/*.css",
  "./web/assets/*.map"
];
const assetOutput = path.resolve(__dirname, "web/assets");

const getBrowsersList = env => {
  let browserslist = require("./package.json").browserslist;
  if (env.supportLegacyBrowsers) {
    browserslist = `${browserslist}, IE 11`;
  }
  return browserslist;
};

const configureStaticFiles = [
  {
    context: "./src/icons",
    from: "**/*",
    to: "icons/"
  },
  {
    context: "./src/img",
    from: "**/*",
    to: "img/"
  }
];

const configureBabelLoader = env => {
  return {
    test: /\.m?js/,
    exclude: /(node_modules)/,
    use: {
      loader: "babel-loader",
      options: {
        presets: [
          [
            "@babel/preset-env",
            {
              useBuiltIns: "entry",
              corejs: 3,
              targets: getBrowsersList(env)
            }
          ]
        ],
        plugins: ["@babel/plugin-syntax-dynamic-import"]
      }
    }
  };
};

const configureFontLoader = () => {
  return {
    test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
    use: [
      {
        loader: 'file-loader',
        options: {
          name: '[name].[ext]',
          outputPath: 'fonts/',
          publicPath: 'fonts/'
        }
      }
    ]
  }
};

const configureCssLoader = env => {
  return {
    test: /\.scss$/,
    use: [
      MiniCssExtractPlugin.loader,
      {
        loader: "css-loader",
        options: {
          sourceMap: true
        }
      },
      {
        loader: "postcss-loader",
        options: {
          ident: "postcss",
          plugins: [
            require("autoprefixer")({
              ...(env.supportLegacyBrowsers
                ? {
                    overrideBrowserslist: getBrowsersList(env)
                  }
                : {})
            })
          ]
        }
      },
      {
        loader: "sass-loader",
        options: {
          sourceMap: true,
          prependData: `
                        @import "./src/scss/abstracts/_variables.scss";
                        @import "./src/scss/abstracts/_mixins.scss";
                    `
        }
      }
    ]
  };
};

const configureFileLoader = () => {
  return {
    test: /\.(png|jpg|gif|svg)$/,
    use: [
      {
        loader: "file-loader",
        options: {}
      }
    ]
  };
};

const configureVueLoader = () => {
  return {
    test: /\.vue$/,
    loader: "vue-loader"
  };
};

module.exports = env => {
  return {
    entry: {
      app: rootEntry
    },
    module: {
      rules: [
        configureBabelLoader(env),
        configureCssLoader(env),
        configureFileLoader(),
        configureFontLoader(),
        configureVueLoader()
      ]
    },
    plugins: [
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: cleanFiles.map(filePath => path.resolve(__dirname, filePath)),
        cleanStaleWebpackAssets: false
      }),
      new CopyWebpackPlugin(configureStaticFiles),
      new VueLoaderPlugin(),
      new MiniCssExtractPlugin({
        filename: "[name].css",
        chunkFilename: "[id].css"
      }),
      new BundleAnalyzerPlugin({
        analyzerMode: env.includeBundleAnalyzer ? "server" : "disabled"
      })
    ],
    output: {
      filename: "[name].bundle.js",
      chunkFilename: "[name].bundle.js",
      path: assetOutput,
      publicPath: "assets/"
    }
  };
};

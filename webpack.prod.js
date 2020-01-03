const merge = require('webpack-merge');
const common = require('./webpack.common');

const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require("terser-webpack-plugin");

module.exports = merge(common, {
   mode: 'production',
   devtool: 'source-map',
   optimization: {
      minimizer: [new TerserPlugin(), new OptimizeCSSAssetsPlugin({})]
   }
});
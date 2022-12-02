const path = require("path");
const webpack = require("webpack");
const BUILD_DIR = path.resolve(__dirname, "app", "public", "dist");

const devMode = false;
module.exports = {
  entry: {
    MainMenu: "./app/src/js/Menu/Menu.jsx",
    TableList: "./app/src/js/TableList/TableList.jsx",
    Invoice: "./app/src/js/Invoice/Invoice.jsx",
  },
  mode: "development",
  devtool: "inline-source-map",
  module: {
    rules: [
      {
        test: /\.tsx?$/,
        use: "ts-loader",
        exclude: /(node_modules|bower_components|vendor)/,
      },
      {
        test: /\.(js|jsx)$/,
        exclude: /(node_modules|bower_components|vendor)/,
        loader: "babel-loader",
        options: { presets: ["@babel/env"] },
      },
      {
        test: /\.s[ac]ss$/i,
        use: ["style-loader", "css-loader", "sass-loader"],
      },
      {
        test: /\.css$/,
        use: ["style-loader", "css-loader"],
      },
    ],
  },

  plugins: [
    new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
      "window.jQuery": "jquery",
      "window.$": "jquery",
    }),
  ],
  resolve: { extensions: ["*", ".js", ".jsx", ".ts"] },

  output: {
    path: BUILD_DIR,
    publicPath: "/dist/",
    filename: "[name].bundle.js",
  },
};

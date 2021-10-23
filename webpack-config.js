const path = require( 'path' );
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

const configuration = {
	entry: {
		'main': './src/index.js',
		'disable-admin-notices': './src/js/disable-admin-notices.js'
	},

	output: {
		filename: 'js/[name].js',
		path: path.resolve( __dirname, 'assets' ),
	},

  plugins: [
		new MiniCssExtractPlugin({
      filename: "css/style.css",
      chunkFilename: "[id].css",
      ignoreOrder: false,
    }),
	],

	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader'
			},
			{
				test: /\.css$/i,
				use: [{
					loader: MiniCssExtractPlugin.loader,
					options: {},
				}, "css-loader"],
			}
		]
	},

	optimization: {
    minimizer: [
      `...`,
      new CssMinimizerPlugin(),
    ],
  },

};



// Export the config object.
module.exports = configuration;
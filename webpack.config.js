const path = require( 'path' );
const CopyWebpackPlugin = require('copy-webpack-plugin');
const defaults = require('@wordpress/scripts/config/webpack.config');

module.exports = {
	...defaults,
	externals: {
		react: 'React',
		'react-dom': 'ReactDOM',
	},
 	entry: {
		'dashboard-app': './src/index.js',
	},
	output: {
		path: path.resolve( __dirname, './assets/' ),
		filename: '[name].js',
	},
	plugins: [
		// ...defaultConfig.plugins,
		...defaults.plugins.filter( function ( plugin ) {
			if ( plugin.constructor.name === 'LiveReloadPlugin' ) {
				return false;
			}
			return true;
		} ),
		new CopyWebpackPlugin({
			patterns: [
				{ from: 'src/icons', to: 'icons' },
			],
		}),
	],
	resolve: {
		alias: {
			'@components': path.resolve( __dirname, 'src/components' ),
			'@features': path.resolve( __dirname, 'src/features' ),
			'@helpers': path.resolve( __dirname, 'src/helpers' ),
			'@store': path.resolve( __dirname, 'src/store' ),
			'@icons': path.resolve( __dirname, 'src/icons' ),
			'@pages': path.resolve( __dirname, 'src/pages' ),
		},
	},
};
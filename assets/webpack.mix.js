let mix = require('laravel-mix');
const path = require('path');

mix.webpackConfig({
	resolve: {
		alias: {
			jquery: path.join(__dirname, 'node_modules/jquery/src/jquery'),
		},
	},
});

mix
	.js(['src/js/app.js'], 'js')
	.sass('src/scss/app.scss', 'css')
	.sourceMaps()
	.options({
		processCssUrls: false,
		postCss: [require('autoprefixer')],
	})
	.sourceMaps(true, 'source-map')
	.setPublicPath('dist');


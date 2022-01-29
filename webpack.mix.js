const mix = require('laravel-mix');

mix.babelConfig({
  plugins: ['@babel/plugin-syntax-dynamic-import'],
});

mix.config.webpackConfig.output = {
  chunkFilename: 'app/chunks/[name].js?id=[contenthash]',
  publicPath: ''
}

mix.js('vue_app/app.js', 'public/app/main.js')

mix.version();

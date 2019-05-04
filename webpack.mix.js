require('dotenv').config();

let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

var browserSyncArgs = {
  proxy: process.env.BS_PROXY_URL,
  port: process.env.BS_PORT ? process.env.BS_PORT : 8080,
  open: process.env.BS_OPEN ? process.env.BS_OPEN : true,
  files: [
    '!node_modules',
    '!framework/vendor',
    '!assets/js/dist',
    'assets/{*,**/**/*,**/*}',
    'assets/js/{*,**/**/*,**/*}',
    'assets/js/pages/{*,**/**/*,**/*}',
    '{*,**/*}.php'
  ]
}

if(process.env.NODE_ENV === 'local' && process.env.CERT) {
  browserSyncArgs['https'] = {
    key:  process.env.KEY,
    cert: process.env.CERT
  }
}

mix
  .setPublicPath('assets')
  .sourceMaps()
  .options({
    processCssUrls: false,
    uglify: {
      uglifyOptions: {
        mangle: {
          reserved: ['$super', '$', 'exports', 'require', 'jQuery', 'jquery']
        }
      }
    }
  })
  .babel([
      'assets/js/inc/*.js',
  ],  'assets/js/app.js')
  .sass('assets/sass/theme.scss', 'css/')
  .copy('node_modules/font-awesome/fonts/*', 'assets/fonts/')
  .browserSync(browserSyncArgs)

//
//
// mix.sass('theme.scss', 'assets/css/theme.css')
//  .scripts(['assets/js/inc/' ], 'assets/js/app.js')
//  .copy('node_modules/font-awesome/fonts/*', 'assets/fonts/');/
//
// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.standaloneSass('src', output); <-- Faster, but isolated from Webpack.
// mix.fastSass('src', output); <-- Alias for mix.standaloneSass().
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.dev');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });

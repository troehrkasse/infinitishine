var elixir = require('laravel-elixir');

elixir.config.assetsPath = 'assets/';
elixir.config.publicPath = 'assets/';

elixir(function(mix) {
    mix.sass('theme.scss', 'assets/css/theme.css')
    .scripts(['assets/js/inc/' ], 'assets/js/app.js')
        .copy('node_modules/font-awesome/fonts/*', 'assets/fonts/');
});
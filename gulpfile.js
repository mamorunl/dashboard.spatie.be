var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

elixir(function(mix) {
    mix.browserify('app.js')
    mix.sass('app.scss');
    mix.version(['js/app.js', 'css/app.css']);
    mix.scripts(['jquery-3.2.0.min.js', 'jquery.cycle2.js', 'jquery.cycle2.scrollVert.min.js'], 'public/js/extra.js');
});

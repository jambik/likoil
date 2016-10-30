const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    /* App files */
    mix.styles([
        '../../../bower_components/bootstrap/dist/css/bootstrap.min.css',
        '../../../bower_components/font-awesome/css/font-awesome.min.css'
    ], 'public/css/app.bundle.css');
    mix.scripts([
        '../../../bower_components/jquery/dist/jquery.min.js',
        '../../../bower_components/bootstrap/dist/js/bootstrap.min.js',
        '../../../bower_components/jquery.easing/js/jquery.easing.min.js'
    ], 'public/js/app.bundle.js');
    mix.copy([
        'bower_components/bootstrap/fonts',
        'bower_components/font-awesome/fonts/*.*',
    ], 'public/fonts');


    // mix.copy('node_modules/swagger-ui/dist', 'public/apidocs');
    // mix.copy('bower_components/elfinder', 'public/library/elfinder');


    /* Admin files */
    mix.styles([
        '../../../bower_components/bootstrap/dist/css/bootstrap.min.css',
        '../../../bower_components/animate.css/animate.min.css',
        '../../../bower_components/sweetalert/dist/sweetalert.css',
        '../../../bower_components/select2/dist/css/select2.min.css',
        '../../../bower_components/datetimepicker/jquery.datetimepicker.css',
        '../../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
    ], 'public/css/admin.bundle.css');
    mix.scripts([
        '../../../bower_components/jquery/dist/jquery.min.js',
        '../../../bower_components/bootstrap/dist/js/bootstrap.min.js',
        '../../../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.min.js',
        '../../../node_modules/vue/dist/vue.min.js',
        '../../../bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js',
        '../../../bower_components/jquery.scrollTo/jquery.scrollTo.min.js',
        '../../../bower_components/sweetalert/dist/sweetalert.min.js',
        '../../../bower_components/select2/dist/js/select2.min.js',
        '../../../bower_components/select2/dist/js/i18n/ru.js',
        '../../../bower_components/datatables.net/js/jquery.dataTables.min.js',
        '../../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
        '../../../bower_components/datetimepicker/build/jquery.datetimepicker.full.min.js'
    ], 'public/js/admin.bundle.js');

    /* CKEDITOR Files */
    mix.copy([
        'node_modules/ckeditor/ckeditor.js',
        'node_modules/ckeditor/contents.css',
        'node_modules/ckeditor/styles.js'
    ], 'public/library/ckeditor');
    mix.copy([
        'node_modules/ckeditor/lang/en.js',
        'node_modules/ckeditor/lang/ru.js'
    ], 'public/library/ckeditor/lang');
    mix.copy('node_modules/ckeditor/plugins/*.*', 'public/library/ckeditor/plugins');
    mix.copy('node_modules/ckeditor/plugins/div', 'public/library/ckeditor/plugins/div');
    mix.copy('node_modules/ckeditor/plugins/font', 'public/library/ckeditor/plugins/font');
    mix.copy('node_modules/ckeditor/plugins/image', 'public/library/ckeditor/plugins/image');
    mix.copy('node_modules/ckeditor/plugins/justify', 'public/library/ckeditor/plugins/justify');
    mix.copy('node_modules/ckeditor/plugins/link', 'public/library/ckeditor/plugins/link');
    mix.copy('node_modules/ckeditor/plugins/magicline', 'public/library/ckeditor/plugins/magicline');
    mix.copy('node_modules/ckeditor/plugins/stylesheetparser', 'public/library/ckeditor/plugins/stylesheetparser');
    mix.copy('node_modules/ckeditor/plugins/table', 'public/library/ckeditor/plugins/table');
    mix.copy('node_modules/ckeditor/skins/moono', 'public/library/ckeditor/skins/moono');
    // mix.copy('node_modules/ckeditor/config.js', 'public/library/ckeditor');
});


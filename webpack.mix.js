const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.setPublicPath(path.normalize('./'));
mix.js([
   'resources/js/app.js',
   
   'js/plugins/loaders/blockui.min.js',
   'js/plugins/visualization/d3/d3.min.js',
   'js/plugins/forms/validation/validate.min.js',
   'js/plugins/forms/inputs/touchspin.min.js',
   'js/plugins/forms/selects/select2.min.js',
   'js/plugins/forms/styling/switch.min.js',
   'js/plugins/forms/styling/uniform.min.js',
   'js/plugins/forms/selects/bootstrap_multiselect.js',
   ], 'js')
   .sass('resources/sass/app.scss', 'css')
   .scripts([
      'js/plugins/pickers/daterangepicker.js',
      'js/plugins/visualization/d3/d3_tooltip.js',
      'js/plugins/ui/moment/moment.min.js',
      'js/plugins/notifications/sweet_alert.min.js',
      'js/main/app.js',
   ],'./js/all.js')
   .styles([
    'assets/css/vendor/bootstrap.min.css',
    'assets/css/vendor/animate.css',
    'assets/css/vendor/font-awesome.min.css',
    'assets/js/vendor/animsition/css/animsition.min.css',
    'assets/js/vendor/daterangepicker/daterangepicker-bs3.css',
    'assets/js/vendor/morris/morris.css',
    'assets/js/vendor/owl-carousel/owl.carousel.css',
    'assets/js/vendor/owl-carousel/owl.theme.css',
    'assets/js/vendor/rickshaw/rickshaw.min.css',
    'assets/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css',
    'assets/js/vendor/datatables/css/jquery.dataTables.min.css',
    'assets/js/vendor/datatables/datatables.bootstrap.min.css',
    'assets/js/vendor/chosen/chosen.css',
    'assets/js/vendor/summernote/summernote.css',
    'assets/js/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css',
    'assets/js/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css',
    'assets/js/vendor/datatables/extensions/ColVis/css/dataTables.colVis.min.css',
    'assets/js/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css',
    'assets/css/main.css',
    'assets/js/vendor/modernizr/modernizr-2.8.3-respond-1.4.2.min.js',
  ], './css/all.css');

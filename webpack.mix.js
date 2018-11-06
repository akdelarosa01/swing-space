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

mix.js('resources/js/app.js', 'public/js')
	.scripts([
		'resources/plugins/modernizr/modernizr.custom.js',
    	'public/js/app.js',
		'resources/plugins/js-storage/js.storage.js',
		'resources/plugins/js-cookie/src/js.cookie.js',
		'resources/plugins/pace/pace.js',
		'resources/plugins/metismenu/dist/metisMenu.js',
		'resources/plugins/switchery-npm/index.js',
		'resources/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
		'resources/plugins/chartist/dist/chartist.js',
		'resources/plugins/toast/jquery.toast.js',
		'resources/plugins/jquery-mask/jquery.mask.min.js',
		'resources/plugins/datatables.net/js/jquery.dataTables.js',
		'resources/plugins/datatables.net-bs4/js/dataTables.bootstrap4.js',
		'resources/plugins/localize/jquery.localize.min.js',
		'resources/plugins/select2/select2.min.js',
		'resources/js/scripts/app.js',
		'resources/js/global.js'
    ], 'public/js/main.js')
    .js('resources/js/pages/super_admin/module.js', 'public/js/pages/super_admin/')
    .js('resources/js/pages/super_admin/transaction_codes.js', 'public/js/pages/super_admin/')

    .js('resources/js/pages/customer/customer_list.js', 'public/js/pages/customer/')
    .js('resources/js/pages/customer/membership.js', 'public/js/pages/customer/')

    .js('resources/js/pages/settings/dropdown.js', 'public/js/pages/settings/')

    .js('resources/js/pages/employee/employee_list.js', 'public/js/pages/employee/')
    .js('resources/js/pages/employee/registration.js', 'public/js/pages/employee/')

    .js('resources/js/pages/inventory/receive_items.js', 'public/js/pages/inventory/')





    .sass('resources/sass/app.scss', 'public/css')
    .styles([
    	'public/css/app.css',
    	'resources/plugins/metismenu/dist/metisMenu.css',
		'resources/plugins/switchery-npm/index.css',
		'resources/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css',
		'resources/sass/icons/line-awesome.min.css',
		'resources/sass/icons/dripicons.min.css',
		'resources/sass/icons/material-design-iconic-font.min.css',
		'resources/sass/icons/font-awesome.min.css',
		'resources/plugins/toast/jquery.toast.css',
		'resources/plugins/select2/select2.min.css',
		'resources/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css',
		'resources/sass/common/main.bundle.css',
		'resources/sass/layouts/vertical/core/main.css',
		'resources/sass/layouts/vertical/menu-type/compact.css',
		'resources/sass/layouts/vertical/themes/theme-e.css',
		'resources/sass/common/custom.css',
	], 'public/css/main.css');

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/*----------------------------------
| Route for Dashboard Module
|-----------------------------------
|
*/
$route['dashboard/get-log'] 		= 'dashboard/get_log';

/*----------------------------------
| Route for SMTP Configuration Module
|-----------------------------------
|
*/
$route['konfigurasi-smtp'] 			= 'konfigurasi/smtp/index';
$route['submit-smtp'] 				= 'konfigurasi/smtp/submit';

/*----------------------------------
| Route for Account Management Module
|-----------------------------------
|
*/
$route['default_controller'] 		= 'masuk';
$route['aktivasi/(:any)'] 			= 'aktivasi/index/$1';
$route['do-aktivasi'] 				= 'aktivasi/submit';

/*----------------------------------
| Route for Access Management Module
|-----------------------------------
|
*/
$route['manajemen-akses/data']			= 'manajemen_akses/data';
$route['manajemen-akses/get-akses']		= 'manajemen_akses/get_akses';
$route['tambah-akses']					= 'manajemen_akses/tambah';
$route['ubah-akses']					= 'manajemen_akses/ubah';
$route['hapus-akses']					= 'manajemen_akses/hapus';
$route['manajemen-akses/update-index']	= 'manajemen_akses/update_index';

/*----------------------------------
| Route for User Management Module
|-----------------------------------
|
*/
$route['manajemen-user/data']		= 'manajemen_user/data';
$route['manajemen-user/get-user']	= 'manajemen_user/get_user';
$route['tambah-user']				= 'manajemen_user/tambah';
$route['ubah-user']					= 'manajemen_user/ubah';
$route['hapus-user']				= 'manajemen_user/hapus';

/*----------------------------------
| Route for Sys Log Module
|-----------------------------------
|
*/
$route['log-sistem']					= 'log_sistem/index';
$route['log-sistem/data/(:any)/(:any)']	= 'log_sistem/data/$1/$2';

/*----------------------------------
| Route for Pengaturan SMTP Module
|-----------------------------------
|
*/
$route['pengaturan-smtp']			= 'pengaturan_smtp/index';
$route['pengaturan-smtp/submit']	= 'pengaturan_smtp/submit';
$route['pengaturan-aplikasi']		= 'pengaturan_aplikasi/index';
$route['pengaturan-aplikasi/submit']= 'pengaturan_aplikasi/submit';

/*----------------------------------
| Route for Tamu Masuk/Keluar Module
|-----------------------------------
|
*/
$route['tamu']						= 'tamu/index';
$route['tamu-keluar']				= 'tamu/tamu_keluar';

/*----------------------------------
| Route for Log Tamu Module
|-----------------------------------
|
*/
$route['data-tamu']						= 'log_tamu/index';
$route['detail-tamu']					= 'log_tamu/detail';
$route['data-tamu/data/(:any)/(:any)']	= 'log_tamu/data/$1/$2';

/*----------------------------------
| Other Settings
|-----------------------------------
|
*/
$route['page-error/(:any)'] 		= 'page_error/index/$1';
$route['404_override'] 				= 'page_error/index';
$route['translate_uri_dashes'] 		= TRUE;

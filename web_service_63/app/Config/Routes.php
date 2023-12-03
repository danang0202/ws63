<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->post('login', 'Login::index');                     // login dengan parameter nim dan hash password 
$routes->get('gethashpw', 'GetHashPW::index');              // dapatkan hash password
$routes->get('getextracontent', 'GetExtraContent::index');  // dapatkan wilayah kerja / anggota tim
$routes->get('listing', 'Listing::create');                 // tidak terpakai di angaktan 62
$routes->post('listingsby', 'ListingSby::index');           // digunakan CAPI Riset 1 Surabaya
$routes->post('listingr4', 'ListingR4::index');             // digunakan CAPI Riset 4 
$routes->post('listingr3', 'ListingR3::index');             // digunakan CAPI Riset 3
$routes->post('listingr2', 'ListingR2::index');             // tidak terpakai di angkatan 62
$routes->post('posisipcl', 'Posisipcl::index');             // untuk update posisi pcl
$routes->post('listingr1', 'ListingR1::index');             // tidak terpakai di angkatan 62
$routes->post('listingr12', 'ListingR12::index');           // digunakan CAPI Riset Integrasi 1 dan 2
$routes->post('latestversion/(:segment)', 'LatestVersion::index/$1'); // untuk mendapatkan versi CAPI terbaru
$routes->resource('dataruta');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

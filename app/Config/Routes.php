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
$routes->setDefaultController('Bazzeting');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Bazzeting::index',['filter' => 'auth']);
$routes->get('/logout', 'Bazzeting::logout');
$routes->get('/login', 'Bazzeting::login');
$routes->post('/auth', 'Bazzeting::auth');
$routes->get('/formasi', 'Bazzeting::formasi',['filter' => 'auth']);
$routes->get('/formasi/(:num)', 'Bazzeting::formasi/$1',['filter' => 'auth']);
$routes->get('/pejabat', 'Bazzeting::pejabat',['filter' => 'auth']);
$routes->get('/pejabat/(:num)', 'Bazzeting::pejabat/$1',['filter' => 'auth']);
$routes->get('/pejabat/(:num)/(:num)', 'Bazzeting::pejabat/$1/$2',['filter' => 'auth']);
$routes->get('/pejabat/(:num)/(:num)/(:num)', 'Bazzeting::pejabat/$1/$2/$3',['filter' => 'auth']);
$routes->get('/laporan', 'Bazzeting::laporan',['filter' => 'auth']);
$routes->get('/downloadExcel/', 'Bazzeting::downloadExcel',['filter' => 'auth']);
$routes->get('/downloadExcel/(:num)', 'Bazzeting::downloadExcel/$1',['filter' => 'auth']);
//$routes->get('/(:any)', 'Bazzeting::content');
$routes->group('simpan', function ($routes) {
    $routes->post('fungsional', 'Bazzeting::sfungsional',['filter' => 'auth']);
    //$routes->add('blog', 'Admin\Blog::index');
});

$routes->group('hapus', function ($routes) {
    $routes->get('fungsional/(:alphanum)/(:alphanum)', 'Bazzeting::hfungsional/$1/$2',['filter' => 'auth']);
    //$routes->add('blog', 'Admin\Blog::index');
});

$routes->group('api', function ($routes) {
    $routes->get('pegawai/(:num)', 'ApiKepegawaian::lspegawai/$1');
    $routes->get('unker/(:num)', 'ApiKepegawaian::unker/$1');
    $routes->get('lsunker/(:num)', 'ApiKepegawaian::lsunker/$1');
});

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

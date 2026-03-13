<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==================
// AUTH
// ==================
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

// Dashboard redirect
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// ==================
// ADMIN ROUTES
// ==================
$routes->group('admin', ['filter' => 'role:admin'], function($routes){

    $routes->get('/', 'Dashboard::admin');
    $routes->get('dashboard', 'Dashboard::admin');

    // Produk (CRUD)
    $routes->get('produk', 'Admin\Produk::index');
    $routes->get('produk/create', 'Admin\Produk::create');
    $routes->post('produk/store', 'Admin\Produk::store');
    $routes->get('produk/edit/(:num)', 'Admin\Produk::edit/$1');
    $routes->post('produk/update/(:num)', 'Admin\Produk::update/$1');
    $routes->get('produk/delete/(:num)', 'Admin\Produk::delete/$1');

    // Kategori (CRUD)
    $routes->get('kategori', 'Admin\Kategori::index');
    $routes->get('kategori/create', 'Admin\Kategori::create');
    $routes->post('kategori/store', 'Admin\Kategori::store');
    $routes->get('kategori/edit/(:num)', 'Admin\Kategori::edit/$1');
    $routes->post('kategori/update/(:num)', 'Admin\Kategori::update/$1');
    $routes->get('kategori/delete/(:num)', 'Admin\Kategori::delete/$1');

    // Pengguna (CRUD)
    $routes->get('pengguna', 'Admin\Pengguna::index');
    $routes->get('pengguna/create', 'Admin\Pengguna::create');
    $routes->post('pengguna/store', 'Admin\Pengguna::store');
    $routes->get('pengguna/edit/(:num)', 'Admin\Pengguna::edit/$1');
    $routes->post('pengguna/update/(:num)', 'Admin\Pengguna::update/$1');
    $routes->get('pengguna/delete/(:num)', 'Admin\Pengguna::delete/$1');
    $routes->get('pengguna/toggle/(:num)', 'Admin\Pengguna::toggle/$1');
});

// ==================
// KASIR ROUTES
// ==================
$routes->group('kasir', ['filter' => 'role:kasir'], function($routes){
    $routes->get('/', 'Dashboard::kasir');
    $routes->get('dashboard', 'Dashboard::kasir');

    // Produk
    $routes->get('produk', 'Kasir\Produk::index');

    // POS
    $routes->get('penjualan', 'Kasir\Penjualan::index');
    $routes->post('penjualan/add', 'Kasir\Penjualan::addToCart');
    $routes->get('penjualan/remove/(:num)', 'Kasir\Penjualan::removeCart/$1');
    $routes->post('penjualan/store', 'Kasir\Penjualan::store');

    // Riwayat & Struk
    $routes->get('penjualan/riwayat', 'Kasir\Penjualan::riwayat');
    $routes->get('penjualan/struk/(:num)', 'Kasir\Penjualan::struk/$1');
    $routes->get('penjualan/struk-pdf/(:num)', 'Kasir\Penjualan::strukPdf/$1');
});


// ==================
// OWNER ROUTES
// ==================
$routes->group('owner', ['filter' => 'role:owner'], function($routes){
    $routes->get('/', 'Dashboard::owner');
    $routes->get('dashboard', 'Dashboard::owner');

    // Laporan
    $routes->get('laporan', 'Owner\Laporan::index');
    $routes->post('laporan/filter', 'Owner\Laporan::filter');
    $routes->get('laporan/pdf', 'Owner\Laporan::exportPdf');
    $routes->get('laporan/excel', 'Owner\Laporan::exportExcel');

    // Log aktivitas
    $routes->get('log', 'Owner\LogAktivitas::index');

   $routes->get('produk', 'Owner\Produk::index');
});
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {

    // =========================
    // USERS
    // =========================
    $routes->get('users', 'Api\UserController::index');
    $routes->get('users/(:num)', 'Api\UserController::show/$1');
    $routes->post('users', 'Api\UserController::create');
    $routes->put('users/(:num)', 'Api\UserController::update/$1');
    $routes->delete('users/(:num)', 'Api\UserController::delete/$1');


    // =========================
    // SYARAT & KETENTUAN
    // =========================
    $routes->get('syarat', 'Api\SyaratKetentuanController::index');
    $routes->get('syarat/aktif', 'Api\SyaratKetentuanController::aktif');
    $routes->get('syarat/(:num)', 'Api\SyaratKetentuanController::show/$1');
    $routes->post('syarat', 'Api\SyaratKetentuanController::create');
    $routes->put('syarat/(:num)', 'Api\SyaratKetentuanController::update/$1');
    $routes->delete('syarat/(:num)', 'Api\SyaratKetentuanController::delete/$1');


    // =========================
    // PERSETUJUAN SYARAT
    // =========================
    $routes->get('persetujuan', 'Api\PersetujuanSyaratController::index');
    $routes->get('persetujuan/sewa/(:num)', 'Api\PersetujuanSyaratController::bySewa/$1');
    $routes->get('persetujuan/(:num)', 'Api\PersetujuanSyaratController::show/$1');
    $routes->post('persetujuan', 'Api\PersetujuanSyaratController::create');
    $routes->put('persetujuan/(:num)', 'Api\PersetujuanSyaratController::update/$1');
    $routes->delete('persetujuan/(:num)', 'Api\PersetujuanSyaratController::delete/$1');


    // =========================
    // KENDARAAN
    // =========================
    $routes->get('kendaraan', 'Api\KendaraanController::index');
    $routes->get('kendaraan/jenis/(:segment)', 'Api\KendaraanController::byJenis/$1');
    $routes->get('kendaraan/(:num)', 'Api\KendaraanController::show/$1');
    $routes->post('kendaraan', 'Api\KendaraanController::create');
    $routes->put('kendaraan/(:num)', 'Api\KendaraanController::update/$1');
    $routes->delete('kendaraan/(:num)', 'Api\KendaraanController::delete/$1');


    // =========================
    // FOTO KENDARAAN
    // =========================
    $routes->get('foto-kendaraan/(:num)', 'Api\FotoKendaraanController::byKendaraan/$1');
    $routes->post('foto-kendaraan', 'Api\FotoKendaraanController::create');
    $routes->delete('foto-kendaraan/(:num)', 'Api\FotoKendaraanController::delete/$1');


    // =========================
    // PENYEWAAN
    // =========================
    $routes->get('penyewaan', 'Api\PenyewaanController::index');
    $routes->get('penyewaan/user/(:num)', 'Api\PenyewaanController::byUser/$1');
    $routes->get('penyewaan/(:num)', 'Api\PenyewaanController::show/$1');
    $routes->post('penyewaan', 'Api\PenyewaanController::create');
    $routes->put('penyewaan/(:num)', 'Api\PenyewaanController::update/$1');
    $routes->delete('penyewaan/(:num)', 'Api\PenyewaanController::delete/$1');


    // =========================
    // DATA PENYEWA
    // =========================
    $routes->get('data-penyewa', 'Api\DataPenyewaController::index');
    $routes->get('data-penyewa/sewa/(:num)', 'Api\DataPenyewaController::bySewa/$1');
    $routes->get('data-penyewa/(:num)', 'Api\DataPenyewaController::show/$1');
    $routes->post('data-penyewa', 'Api\DataPenyewaController::create');
    $routes->put('data-penyewa/(:num)', 'Api\DataPenyewaController::update/$1');
    $routes->delete('data-penyewa/(:num)', 'Api\DataPenyewaController::delete/$1');


    // =========================
    // FAQ
    // =========================
    $routes->get('faq', 'Api\FaqController::index');
    $routes->get('faq/aktif', 'Api\FaqController::aktif');
    $routes->get('faq/(:num)', 'Api\FaqController::show/$1');
    $routes->post('faq', 'Api\FaqController::create');
    $routes->put('faq/(:num)', 'Api\FaqController::update/$1');
    $routes->delete('faq/(:num)', 'Api\FaqController::delete/$1');

});
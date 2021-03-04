<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Beranda');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Auth::index');
$routes->add('/', 'Auth::index');

$routes->get('logout', 'Auth::logout');
$routes->add('blokir', 'Auth::blokir');


$routes->get('/dashboard', 'Dashboard::index');
$routes->add('/dashboard/keluar', 'Dashboard::keluar');

///routes kasir
$routes->get('/kasir', 'Kasir::index');
$routes->post('/kasir/tambahkeranjangadmin', 'Kasir::tambahkeranjangadmin');
$routes->post('/kasir/tambahtransaksisementarakonsumen', 'Kasir::tambahtransaksisementarakonsumen');
$routes->put('/kasir/ubahjeniskasir', 'Kasir::ubahjeniskasir');
$routes->get('/kasir/kecohhapuskeranjangadmin/(:any)', 'Kasir::kecohhapuskeranjangadmin');
$routes->delete('/kasir/kecohhapuskeranjangadmin/(:num)', 'Kasir::hapuskeranjangadmin/$1');
$routes->get('/kasir/kecohhapusallkeranjangadmin/(:any)', 'Kasir::kecohhapusallkeranjangadmin');
$routes->delete('/kasir/kecohhapusallkeranjangadmin/(:num)', 'Kasir::hapusallkeranjangadmin/$1');



$routes->get('/kasir/invoice/(:any)', 'Invoice::index/$1');
$routes->post('/kasir/tambahtransaksi/(:any)', 'Invoice::tambahtransaksi/$1');
$routes->get('/kasir/kecohhapusinvoice/(:num)', 'Invoice::kecohhapusinvoive');
$routes->delete('/kasir/kecohhapusinvoice/(:any)', 'Invoice::hapusinvoice/$1');


$routes->get('/kasir/utang', 'Utang::index');


$routes->get('/kasir/invoice_utang/(:any)', 'InvoiceUtang::index/$1');
$routes->get('/kasir/kecohhapusinvoiceutang/(:num)', 'InvoiceUtang::kecohhapusinvoiveutang');
$routes->delete('/kasir/kecohhapusinvoiceutang/(:any)', 'InvoiceUtang::hapusinvoiceutang/$1');
$routes->post('/kasir/simpan_invoice_utang', 'InvoiceUtang::simpan_invoice_utang');




$routes->get('/pengguna', 'Pengguna::index');
$routes->put('/pengguna/editpengguna', 'Pengguna::editpengguna');


$routes->get('/pengguna/katasandi', 'UbahKataSandi::index');
$routes->put('/pengguna/editkatasandi', 'UbahKataSandi::editkatasandi');


$routes->get('/barang', 'Barang::index');
$routes->post('/barang/tambahbarang', 'Barang::tambahbarang');
$routes->put('/barang/editbarang', 'Barang::editbarang');
$routes->add('/barang/kecohhapusbarang/(:any)', 'Barang::kecohhapusbarang');
$routes->delete('/barang/kecohhapusbarang/(:num)', 'Barang::hapusbarang/$1');


$routes->get('/barang/daftarsatuan', 'Satuan::index');
$routes->post('/barang/tambahsatuan', 'Satuan::tambahsatuan');
$routes->put('/barang/editsatuan', 'Satuan::editsatuan');
$routes->add('/barang/kecohhapussatuan/(:any)', 'Satuan::kecohhapussatuan');
$routes->delete('/barang/kecohhapussatuan/(:num)', 'Satuan::hapussatuan/$1');

///tambah daftar kategori
$routes->get('/barang/daftarkategori', 'Kategori::index');
$routes->post('/barang/tambahkategori', 'Kategori::tambahkategori');
$routes->put('/barang/editkategori', 'Kategori::editkategori');
$routes->add('/barang/kecohhapuskategori/(:any)', 'Kategori::kecohhapuskategori');
$routes->delete('/barang/kecohhapuskategori/(:num)', 'Kategori::hapuskategori/$1');

///tambah daftar merek
$routes->get('/barang/daftarmerek', 'Merek::index');
$routes->post('/barang/tambahmerek', 'Merek::tambahmerek');
$routes->put('/barang/editmerek', 'Merek::editmerek');
$routes->add('/barang/kecohhapusmerek/(:any)', 'Merek::kecohhapusmerek');
$routes->delete('/barang/kecohhapusmerek/(:num)', 'Merek::hapusmerek/$1');


///tambah daftar kategori
$routes->get('/barang/daftarsupplier', 'Supplier::index');
$routes->post('/barang/tambahsupplier', 'Supplier::tambahsupplier');
$routes->put('/barang/editsupplier', 'Supplier::editsupplier');
$routes->add('/barang/kecohhapussupplier/(:any)', 'Supplier::kecohhapussupplier');
$routes->delete('/barang/kecohhapussupplier/(:num)', 'Supplier::hapussupplier/$1');

///ubah kode barang
$routes->get('/barang/pengaturankodebarang', 'KodeBarang::index');
$routes->put('/barang/editkodebarang', 'KodeBarang::editkodebarang');
///
$routes->get('/barang/pengaturankodetransaksi', 'KodeTransaksi::index');
$routes->put('/barang/editkodetransaksi', 'KodeTransaksi::editkodetransaksi');

$routes->get('/barang/pengaturankoderetur', 'KodeRetur::index');
$routes->put('/barang/editkoderetur', 'KodeRetur::editkoderetur');

$routes->get('/barang/stok', 'Stok::index');
$routes->put('/barang/editstok', 'Stok::editstok');



$routes->get('/barang/masuk', 'BarangMasuk::index');
$routes->post('/barang/barangmasuk', 'BarangMasuk::barangmasuk');
$routes->post('/barang/tambahpengirim', 'BarangMasuk::tambahpengirim');
$routes->post('/barang/tambahbarangmasuk', 'BarangMasuk::tambahbarangmasuk');
$routes->get('/barang/ambilbarang', 'BarangMasuk::ambilbarang');
$routes->post('/barang/ambilidbarang', 'BarangMasuk::ambilidbarang');



$routes->get('/role', 'Role::index');
$routes->add('/role/ambilidr', 'Role::ambilidr');
$routes->add('/role/tambahneditrole', 'Role::tambahneditrole');
$routes->add('/role/unikrole', 'Role::unikrole');
$routes->add('/role/hapusrole', 'Role::hapusrole');

$routes->add('/role/tambahrole', 'Role::tambahrole');
$routes->add('/role/editrole', 'Role::editrole');
$routes->add('/role/kecohhapusrole/(:any)', 'Role::kecohhapusrole');
$routes->delete('/role/kecohhapusrole/(:num)', 'Role::hapusrole/$1');
///
$routes->get('/role/roleakses/(:num)', 'Role::roleakses/$1');
$routes->add('/role/ubahakses', 'Role::ubahakses');



$routes->get('/menu', 'Menu::index');
$routes->post('/menu/tambahmenu', 'Menu::tambahmenu');
$routes->put('/menu/editmenu', 'Menu::editmenu');
$routes->get('/menu/kecohhapusmenu/(:any)', 'Menu::kecohhapusmenu');
$routes->delete('/menu/kecohhapusmenu/(:num)', 'Menu::hapusmenu/$1');


///
$routes->get('/menu/submenu', 'Submenu::index');
$routes->post('/menu/tambahsubmenu', 'Submenu::tambahsubmenu');
$routes->put('/menu/editsubmenu', 'Submenu::editsubmenu');
$routes->get('/menu/kecohhapussubmenu/(:any)', 'Submenu::kecohhapussubmenu');
$routes->delete('/menu/kecohhapussubmenu/(:num)', 'Submenu::hapussubmenu/$1');



///
$routes->get('/toko', 'Toko::index');
$routes->add('/toko/tambahkaryawan', 'Toko::tambahkaryawan');
$routes->add('/toko/editkaryawan/(:num)', 'Toko::editkaryawan/$1');

$routes->add('/toko/kecohhapuskaryawan/(:any)', 'Toko::kecohhapuskaryawan');
$routes->delete('/toko/kecohhapuskaryawan/(:num)', 'Toko::hapuskaryawan/$1');

///
$routes->get('/toko/profiltoko', 'Toko::profiltoko');
$routes->post('/toko/editprofiltoko', 'Toko::editprofiltoko');

///LAPORAN///
$routes->add('/masuk', 'LaporanMasuk::index');
$routes->add('/masuk/barangmasukminggu', 'LaporanMasuk::barangmasukminggu');
$routes->add('/masuk/ambilbarangmasukmingguan', 'LaporanMasuk::ambilbarangmasukmingguan');
$routes->add('/masuk/barangmasukbulan', 'LaporanMasuk::barangmasukbulan');
$routes->add('/masuk/barangmasuktahun', 'LaporanMasuk::barangmasuktahun');

$routes->add('/keluar', 'LaporanKeluar::index');
$routes->add('/keluar/barangkeluarminggu', 'LaporanKeluar::barangkeluarminggu');
$routes->add('/keluar/ambilbarangkeluarmingguan', 'LaporanKeluar::ambilbarangkeluarmingguan');
$routes->add('/keluar/barangkeluarbulan', 'LaporanKeluar::barangkeluarbulan');
$routes->add('/keluar/barangkeluartahun', 'LaporanKeluar::barangkeluartahun');


$routes->get('transaksi', 'Transaksi::index');
$routes->add('transaksi/(:segment)', 'Transaksi::detail_transaksi/$1');
$routes->add('tambahttt', 'Transaksi::tambahttt');

$routes->add('/menu/getmenuu', 'Menu::getmenuu');

$routes->add('form', 'Retur::index');
$routes->post('/form/ambilkodetransaksi', 'Retur::ambilkodetransaksi');
$routes->post('/form/tambahkeranjangretur', 'Retur::tambahkeranjangretur');
// $routes->add('/form/ubahjeniskasir', 'Retur::ubahjeniskasir');
$routes->post('/form/tambahretursementara', 'Retur::tambahretursementara');
$routes->get('/form/kecohhapuskeranjangretur/(:any)', 'Retur::kecohhapuskeranjangretur');
$routes->delete('/form/kecohhapuskeranjangretur/(:num)', 'Retur::hapuskeranjangretur/$1');
$routes->get('/form/kecohhapusallkeranjangretur/(:any)', 'Retur::kecohhapusallkeranjangretur');
$routes->delete('/form/kecohhapusallkeranjangretur/(:num)', 'Retur::hapusallkeranjangretur/$1');


$routes->get('/form/invoiceretur', 'InvoiceRetur::index');
$routes->post('/form/tambahtransaksiretur', 'InvoiceRetur::tambahtransaksiretur');
$routes->get('/form/kecohhapusinvoiceretur/(:any)', 'InvoiceRetur::kecohhapusinvoiveretur');
$routes->delete('/form/kecohhapusinvoiceretur/(:num)', 'InvoiceRetur::hapusinvoiceretur/$1');


$routes->add('laporan', 'LaporanRetur::index');



$routes->add('/laporan/summary_tanggal', 'LaporanSummary::index');
$routes->add('/laporan/summary_bulan', 'LaporanSummary::summary_bulan');
$routes->add('/laporan/summary_tahun', 'LaporanSummary::summary_tahun');





/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

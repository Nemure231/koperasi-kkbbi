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
$routes->add('/kasir/tambahkeranjangadmin', 'Kasir::tambahkeranjangadmin');
$routes->add('/kasir/tambahtransaksisementarakonsumen', 'Kasir::tambahtransaksisementarakonsumen');
$routes->add('/kasir/ubahjeniskasir', 'Kasir::ubahjeniskasir');
$routes->add('/kasir/kecohhapuskeranjangadmin/(:any)', 'Kasir::kecohhapuskeranjangadmin');
$routes->delete('/kasir/kecohhapuskeranjangadmin/(:num)', 'Kasir::hapuskeranjangadmin/$1');
$routes->add('/kasir/kecohhapusallkeranjangadmin/(:any)', 'Kasir::kecohhapusallkeranjangadmin');
$routes->delete('/kasir/kecohhapusallkeranjangadmin/(:num)', 'Kasir::hapusallkeranjangadmin/$1');

$routes->get('/kasir/invoice/(:any)', 'Kasir::invoice/$1');
$routes->add('/kasir/utang', 'Kasir::utang');
$routes->add('/kasir/cetaksetruk', 'Kasir::cetaksetruk');
$routes->add('/kasir/tambahtransaksi/(:any)', 'Kasir::tambahtransaksi/$1');
$routes->add('/kasir/kecohhapusinvoice/(:num)', 'Kasir::kecohhapusinvoive');
$routes->delete('/kasir/kecohhapusinvoice/(:any)', 'Kasir::hapusinvoice/$1');


$routes->get('/kasir/invoice_utang/(:any)', 'Kasir::invoice_utang/$1');
$routes->add('/kasir/kecohhapusinvoiceutang/(:num)', 'Kasir::kecohhapusinvoiveutang');
$routes->delete('/kasir/kecohhapusinvoiceutang/(:any)', 'Kasir::hapusinvoiceutang/$1');

$routes->add('/kasir/simpan_invoice_utang', 'Kasir::simpan_invoice_utang');




$routes->get('/pengguna', 'Pengguna::index');
$routes->add('/pengguna', 'Pengguna::index');
$routes->add('/pengguna/editpengguna', 'Pengguna::editpengguna');


$routes->get('/pengguna/katasandi', 'Pengguna::katasandi');
$routes->add('/pengguna/editkatasandi', 'Pengguna::editkatasandi');


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
$routes->get('/barang/pengaturankodebarang', 'Barang::pengaturankodebarang');
$routes->add('/barang/editkodebarang', 'Barang::editkodebarang');
///
$routes->get('/barang/pengaturankodetransaksi', 'Barang::pengaturankodetransaksi');
$routes->add('/barang/editkodetransaksi', 'Barang::editkodetransaksi');

$routes->get('/barang/pengaturankoderetur', 'Barang::pengaturankoderetur');
$routes->add('/barang/editkoderetur', 'Barang::editkoderetur');

$routes->get('/barang/stok', 'Barang::stok');
$routes->add('/barang/editstok', 'Barang::editstok');

$routes->get('/barang/masuk', 'Barang::masuk');
$routes->add('/barang/barangmasuk', 'Barang::barangmasuk');
$routes->add('/barang/tambahpengirim', 'Barang::tambahpengirim');
$routes->add('/barang/tambahbarangmasuk', 'Barang::tambahbarangmasuk');
$routes->get('/barang/ambilbarang', 'Barang::ambilbarang');
$routes->add('/barang/ambilidbarang', 'Barang::ambilidbarang');



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
$routes->add('/menu/ambilidm', 'Menu::ambilidm');
$routes->add('/menu/tambahneditmenu', 'Menu::tambahneditmenu');
$routes->add('/menu/unikmenu', 'Menu::unikmenu');
$routes->add('/menu/hapusmenu', 'Menu::hapusmenu');
///
$routes->get('/menu/submenu', 'Menu::submenu');
$routes->add('/menu/ambilids', 'Menu::ambilids');
$routes->add('/menu/tambahneditsubmenu', 'Menu::tambahneditsubmenu');
$routes->add('/menu/uniksubmenu', 'Menu::uniksubmenu');
$routes->add('/menu/uniksubmenuurl', 'Menu::uniksubmenuurl');
$routes->add('/menu/hapussubmenu', 'Menu::hapussubmenu');

$routes->add('/menu/tambahmenu', 'Menu::tambahmenu');
$routes->add('/menu/editmenu', 'Menu::editmenu');
$routes->add('/menu/kecohhapusmenu/(:any)', 'Menu::kecohhapusmenu');
$routes->delete('/menu/kecohhapusmenu/(:num)', 'Menu::hapusmenu/$1');

$routes->add('/menu/tambahsubmenu', 'Menu::tambahsubmenu');
$routes->add('/menu/editsubmenu', 'Menu::editsubmenu');
$routes->add('/menu/kecohhapussubmenu/(:any)', 'Menu::kecohhapussubmenu');
$routes->delete('/menu/kecohhapussubmenu/(:num)', 'Menu::hapussubmenu/$1');



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
$routes->add('/masuk', 'Masuk::index');
$routes->add('/masuk/barangmasukminggu', 'Masuk::barangmasukminggu');
$routes->add('/masuk/ambilbarangmasukmingguan', 'Masuk::ambilbarangmasukmingguan');
$routes->add('/masuk/barangmasukbulan', 'Masuk::barangmasukbulan');
$routes->add('/masuk/barangmasuktahun', 'Masuk::barangmasuktahun');

$routes->add('/keluar', 'Keluar::index');
$routes->add('/keluar/barangkeluarminggu', 'Keluar::barangkeluarminggu');
$routes->add('/keluar/ambilbarangkeluarmingguan', 'Keluar::ambilbarangkeluarmingguan');
$routes->add('/keluar/barangkeluarbulan', 'Keluar::barangkeluarbulan');
$routes->add('/keluar/barangkeluartahun', 'Keluar::barangkeluartahun');


$routes->get('transaksi', 'Transaksi::index');
$routes->add('transaksi/(:segment)', 'Transaksi::detail_transaksi/$1');
$routes->add('tambahttt', 'Transaksi::tambahttt');

$routes->add('/menu/getmenuu', 'Menu::getmenuu');

$routes->add('form', 'Form::index');
$routes->add('/form/ambilkodetransaksi', 'Form::ambilkodetransaksi');
$routes->add('/form/tambahkeranjangretur', 'Form::tambahkeranjangretur');
$routes->add('/form/ubahjeniskasir', 'Form::ubahjeniskasir');
$routes->add('/form/tambahretursementara', 'Form::tambahretursementara');
$routes->add('/form/kecohhapuskeranjangretur/(:any)', 'Form::kecohhapuskeranjangretur');
$routes->delete('/form/kecohhapuskeranjangretur/(:num)', 'Form::hapuskeranjangretur/$1');
$routes->add('/form/kecohhapusallkeranjangretur/(:any)', 'Form::kecohhapusallkeranjangretur');
$routes->delete('/form/kecohhapusallkeranjangretur/(:num)', 'Form::hapusallkeranjangretur/$1');

$routes->get('/form/invoiceretur', 'Form::invoiceretur');
$routes->add('/form/tambahtransaksiretur', 'Form::tambahtransaksiretur');
$routes->add('/form/kecohhapusinvoiceretur/(:any)', 'Form::kecohhapusinvoiveretur');
$routes->delete('/form/kecohhapusinvoiceretur/(:num)', 'Form::hapusinvoiceretur/$1');


$routes->add('laporan', 'Laporan::index');
$routes->add('/laporan/summary_tanggal', 'Laporan::summary_tanggal');
$routes->add('/laporan/summary_bulan', 'Laporan::summary_bulan');
$routes->add('/laporan/summary_tahun', 'Laporan::summary_tahun');





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

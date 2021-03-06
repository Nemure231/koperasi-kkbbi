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

$routes->group('akun', function($routes){
	$routes->get('profil', 'Pengguna::index');
	$routes->put('profil/ubah', 'Pengguna::ubah');
	$routes->get('sandi', 'Sandi::index');
	$routes->put('sandi/ubah', 'Sandi::ubah');
});

$routes->group('beranda', function($routes){

	$routes->get('dashboard_masuk', 'Dashboard::index');
	$routes->add('dashboard_keluar', 'Dashboard::keluar');	
});


$routes->group('suplai', function($routes){
	$routes->get('barang', 'Barang::index');
	$routes->post('barang/tambah', 'Barang::tambah');
	$routes->put('barang/ubah', 'Barang::ubah');
	$routes->delete('barang/hapus', 'Barang::hapus');

	$routes->get('satuan', 'Satuan::index');
	$routes->post('satuan/tambah', 'Satuan::tambah');
	$routes->put('satuan/ubah', 'Satuan::ubah');
	$routes->delete('satuan/hapus', 'Satuan::hapus');

	$routes->get('kategori', 'Kategori::index');
	$routes->post('kategori/tambah', 'Kategori::tambah');
	$routes->put('kategori/ubah', 'Kategori::ubah');
	$routes->delete('kategori/hapus', 'Kategori::hapus');

	$routes->get('merek', 'Merek::index');
	$routes->post('merek/tambah', 'Merek::tambah');
	$routes->put('merek/ubah', 'Merek::ubah');
	$routes->delete('merek/hapus', 'Merek::hapus');

	$routes->get('supplier', 'Supplier::index');
	$routes->post('supplier/tambah', 'Supplier::tambah');
	$routes->put('supplier/ubah', 'Supplier::ubah');
	$routes->delete('supplier/hapus', 'Supplier::hapus');

	
});

$routes->group('fitur', function($routes){

	$routes->get('kasir', 'Kasir::index');
	$routes->post('kasir/tambah_keranjang', 'Kasir::tambah_keranjang');
	$routes->post('kasir/tambah_transaksi_sementara', 'Kasir::tambah_transaksi_sementara');
	$routes->put('kasir/ubah_jenis_kasir', 'Kasir::ubah_jenis_kasir');
	$routes->delete('kasir/hapus_barang', 'Kasir::hapus_barang');
	$routes->delete('kasir/hapus_keranjang', 'Kasir::hapus_keranjang');

	$routes->get('kasir/invoice/(:any)', 'Invoice::index/$1');
	$routes->post('kasir/invoice/tambah', 'Invoice::tambah');
	// $routes->get('kasir/kecohhapusinvoice/(:num)', 'Invoice::kecohhapusinvoive');
	$routes->delete('kasir/invoice/hapus', 'Invoice::hapus');	

	$routes->get('utang', 'Utang::index');
	$routes->get('utang/invoice_utang/(:any)', 'InvoiceUtang::index/$1');
	$routes->get('utang/kecohhapusinvoiceutang/(:num)', 'InvoiceUtang::kecohhapusinvoiveutang');
	$routes->delete('utang/kecohhapusinvoiceutang/(:any)', 'InvoiceUtang::hapusinvoiceutang/$1');
	$routes->post('utang/simpan_invoice_utang', 'InvoiceUtang::simpan_invoice_utang');

	$routes->get('barang_masuk', 'BarangMasuk::index');
	$routes->post('barang_masuk/barangmasuk', 'BarangMasuk::barangmasuk');
	$routes->post('barang_masuk/tambahpengirim', 'BarangMasuk::tambahpengirim');
	$routes->post('barang_masuk/tambahbarangmasuk', 'BarangMasuk::tambahbarangmasuk');
	$routes->get('barang_masuk/ambilbarang', 'BarangMasuk::ambilbarang');
	$routes->post('barang_masuk/ambilidbarang', 'BarangMasuk::ambilidbarang');

	$routes->add('retur', 'Retur::index');
	$routes->post('retur/ambilkodetransaksi', 'Retur::ambilkodetransaksi');
	$routes->post('retur/tambahkeranjangretur', 'Retur::tambahkeranjangretur');
	$routes->post('retur/tambahretursementara', 'Retur::tambahretursementara');
	$routes->get('retur/kecohhapuskeranjangretur/(:any)', 'Retur::kecohhapuskeranjangretur');
	$routes->delete('retur/kecohhapuskeranjangretur/(:num)', 'Retur::hapuskeranjangretur/$1');
	$routes->get('retur/kecohhapusallkeranjangretur/(:any)', 'Retur::kecohhapusallkeranjangretur');
	$routes->delete('retur/kecohhapusallkeranjangretur/(:num)', 'Retur::hapusallkeranjangretur/$1');

	$routes->get('retur/invoice_retur', 'InvoiceRetur::index');
	$routes->post('retur/invoice_retur/tambahtransaksiretur', 'InvoiceRetur::tambahtransaksiretur');
	$routes->get('retur/invoice_retur/kecohhapusinvoiceretur/(:any)', 'InvoiceRetur::kecohhapusinvoiveretur');
	$routes->delete('retur/invoice_retur/kecohhapusinvoiceretur/(:num)', 'InvoiceRetur::hapusinvoiceretur/$1');
});


$routes->group('laporan', function($routes){

	$routes->add('masuk_hari', 'LaporanMasuk::index');
	$routes->add('masuk_minggu', 'LaporanMasuk::barangmasukminggu');
	// $routes->add('/masuk/ambilbarangmasukmingguan', 'LaporanMasuk::ambilbarangmasukmingguan');
	$routes->add('masuk_bulan', 'LaporanMasuk::barangmasukbulan');
	$routes->add('masuk_tahun', 'LaporanMasuk::barangmasuktahun');

	$routes->add('keluar_hari', 'LaporanKeluar::index');
	$routes->add('keluar_minggu', 'LaporanKeluar::barangkeluarminggu');
	// $routes->add('keluar/ambilbarangkeluarmingguan', 'LaporanKeluar::ambilbarangkeluarmingguan');
	$routes->add('keluar_bulan', 'LaporanKeluar::barangkeluarbulan');
	$routes->add('keluar_tahun', 'LaporanKeluar::barangkeluartahun');


	$routes->add('retur', 'LaporanRetur::index');

	$routes->add('summary_tanggal', 'LaporanSummary::index');
	$routes->add('summary_bulan', 'LaporanSummary::summary_bulan');
	$routes->add('summary_tahun', 'LaporanSummary::summary_tahun');
});



$routes->group('pengaturan', function($routes){

	$routes->get('role', 'Role::index');
	$routes->post('role/tambahrole', 'Role::tambahrole');
	$routes->put('role/editrole', 'Role::editrole');
	$routes->get('role/kecohhapusrole/(:any)', 'Role::kecohhapusrole');
	$routes->delete('role/kecohhapusrole/(:num)', 'Role::hapusrole/$1');
	$routes->get('role/roleakses/(:num)', 'RoleAkses::index/$1');
	$routes->post('role/ubahakses', 'RoleAkses::ubahakses');


	$routes->get('menu', 'Menu::index');
	$routes->post('menu/tambahmenu', 'Menu::tambahmenu');
	$routes->put('menu/editmenu', 'Menu::editmenu');
	$routes->get('menu/kecohhapusmenu/(:any)', 'Menu::kecohhapusmenu');
	$routes->delete('menu/kecohhapusmenu/(:num)', 'Menu::hapusmenu/$1');

	///
	$routes->get('submenu', 'Submenu::index');
	$routes->post('submenu/tambahsubmenu', 'Submenu::tambahsubmenu');
	$routes->put('submenu/editsubmenu', 'Submenu::editsubmenu');
	$routes->get('submenu/kecohhapussubmenu/(:any)', 'Submenu::kecohhapussubmenu');
	$routes->delete('submenu/kecohhapussubmenu/(:num)', 'Submenu::hapussubmenu/$1');


	$routes->get('kode_barang', 'KodeBarang::index');
	$routes->put('kode_barang/editkodebarang', 'KodeBarang::editkodebarang');
	///
	$routes->get('kode_transaksi', 'KodeTransaksi::index');
	$routes->put('kode_transaksi/editkodetransaksi', 'KodeTransaksi::editkodetransaksi');

	$routes->get('kode_retur', 'KodeRetur::index');
	$routes->put('kode_retur/editkoderetur', 'KodeRetur::editkoderetur');

	$routes->get('stok', 'Stok::index');
	$routes->put('stok/editstok', 'Stok::editstok');
});

$routes->group('tempat', function($routes){

	
	$routes->get('karyawan', 'Karyawan::index');
	$routes->post('karyawan/tambahkaryawan', 'Karyawan::tambahkaryawan');
	$routes->post('karyawan/editkaryawan/(:num)', 'Karyawan::editkaryawan/$1');
	$routes->get('karyawan/kecohhapuskaryawan/(:any)', 'Karyawan::kecohhapuskaryawan');
	$routes->delete('karyawan/kecohhapuskaryawan/(:num)', 'Karyawan::hapuskaryawan/$1');

	$routes->get('toko', 'Toko::index');
	$routes->post('toko/editprofiltoko', 'Toko::editprofiltoko');

});


$routes->get('transaksi', 'Transaksi::index');
$routes->add('transaksi/(:segment)', 'Transaksi::detail_transaksi/$1');
$routes->add('tambahttt', 'Transaksi::tambahttt');

$routes->add('/menu/getmenuu', 'Menu::getmenuu');








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

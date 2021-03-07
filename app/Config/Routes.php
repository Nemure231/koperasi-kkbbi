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
	$routes->delete('kasir/invoice/hapus', 'Invoice::hapus');	

	$routes->get('utang', 'Utang::index');
	$routes->get('utang/invoice/(:any)', 'InvoiceUtang::index/$1');
	$routes->post('utang/invoice/tambah', 'InvoiceUtang::tambah');

	$routes->get('barang_masuk', 'BarangMasuk::index');
	$routes->post('barang_masuk/tambah_barang', 'BarangMasuk::tambah_barang');
	$routes->post('barang_masuk/tambah_pengirim', 'BarangMasuk::tambah_pengirim');
	$routes->post('barang_masuk/tambah', 'BarangMasuk::tambah');
	$routes->get('barang_masuk/ambil_detail', 'BarangMasuk::ambil_detail');
	$routes->post('barang_masuk/ambil_harga', 'BarangMasuk::ambil_harga');

	$routes->add('retur', 'Retur::index');
	$routes->post('retur/ambil_kode', 'Retur::ambil_kode');
	$routes->post('retur/tambah_keranjang', 'Retur::tambah_keranjang');
	$routes->post('retur/tambah_transaksi_sementara', 'Retur::tambah_transaksi_sementara');
	$routes->delete('retur/hapus_barang', 'Retur::hapus_barang');
	$routes->delete('retur/hapus_keranjang', 'Retur::hapus_keranjang');

	$routes->get('retur/invoice', 'InvoiceRetur::index');
	$routes->post('retur/invoice/tambah', 'InvoiceRetur::tambah');
	$routes->delete('retur/invoice/hapus', 'InvoiceRetur::hapus');
});


$routes->group('laporan', function($routes){

	$routes->add('masuk/harian', 'LaporanMasuk::index');
	$routes->add('masuk/mingguan', 'LaporanMasuk::mingguan');
	$routes->add('masuk/bulanan', 'LaporanMasuk::bulanan');
	$routes->add('masuk/tahunan', 'LaporanMasuk::tahunan');

	$routes->add('keluar/harian', 'LaporanKeluar::index');
	$routes->add('keluar/mingguan', 'LaporanKeluar::mingguan');
	$routes->add('keluar/bulanan', 'LaporanKeluar::bulanan');
	$routes->add('keluar/tahunan', 'LaporanKeluar::tahunan');

	$routes->add('retur', 'LaporanRetur::index');

	$routes->add('summary/tanggal', 'LaporanSummary::index');
	$routes->add('summary/bulan', 'LaporanSummary::bulan');
	$routes->add('summary/tahun', 'LaporanSummary::tahun');
});



$routes->group('pengaturan', function($routes){

	$routes->get('role', 'Role::index');
	$routes->post('role/tambah', 'Role::tambah');
	$routes->put('role/ubah', 'Role::ubah');
	$routes->delete('role/hapus', 'Role::hapus');


	$routes->get('role/akses/(:num)', 'RoleAkses::index/$1');
	$routes->post('role/akses/ubah', 'RoleAkses::ubah');


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

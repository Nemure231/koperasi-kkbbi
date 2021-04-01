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
$routes->post('login', 'Auth::login');
$routes->post('logout', 'Auth::logout');
$routes->add('blokir', 'Auth::blokir');

$routes->group('akun', function($routes){
	$routes->group('profil', function($routes){
		$routes->get('', 'Pengguna::index', ['filter' => 'cek_akses']);
		$routes->put('ubah', 'Pengguna::ubah');
	});
	$routes->group('sandi', function($routes){
		$routes->get('', 'Sandi::index', ['filter' => 'cek_akses']);
		$routes->put('ubah', 'Sandi::ubah');
	});
});

$routes->group('beranda', function($routes){

	$routes->get('dashboard_masuk', 'Dashboard::index', ['filter' => 'cek_akses']);
	$routes->get('dashboard_keluar', 'Dashboard::keluar', ['filter' => 'cek_akses']);	
});


$routes->group('suplai', function($routes){
	$routes->group('barang', function($routes){
		$routes->get('', 'Barang::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'Barang::tambah');
		$routes->put('ubah', 'Barang::ubah');
		$routes->delete('hapus', 'Barang::hapus');
	});
	$routes->group('satuan', function($routes){
		$routes->get('', 'Satuan::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'Satuan::tambah');
		$routes->put('ubah', 'Satuan::ubah');
		$routes->delete('hapus', 'Satuan::hapus');
	});
	$routes->group('kategori', function($routes){
		$routes->get('', 'Kategori::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'Kategori::tambah');
		$routes->put('ubah', 'Kategori::ubah');
		$routes->delete('hapus', 'Kategori::hapus');
	});
	$routes->group('merek', function($routes){
		$routes->get('', 'Merek::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'Merek::tambah');
		$routes->put('ubah', 'Merek::ubah');
		$routes->delete('hapus', 'Merek::hapus');
	});
	$routes->group('supplier', function($routes){
		$routes->get('', 'Supplier::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'Supplier::tambah');
		$routes->put('ubah', 'Supplier::ubah');
		$routes->delete('hapus', 'Supplier::hapus');
	});
	$routes->group('kode', function($routes){
		$routes->get('barang', 'KodeBarang::index', ['filter' => 'cek_akses']);
		$routes->put('barang/ubah', 'KodeBarang::ubah');
		
		$routes->get('transaksi', 'KodeTransaksi::index', ['filter' => 'cek_akses']);
		$routes->put('transaksi/ubah', 'KodeTransaksi::ubah');
	});
	$routes->group('stok', function($routes){
		$routes->get('', 'Stok::index', ['filter' => 'cek_akses']);
		$routes->post('cari', 'Stok::cari');
	});

});

$routes->group('fitur', function($routes){

	$routes->group('kasir', function($routes){
		$routes->get('', 'Kasir::index', ['filter' => 'cek_akses']);
		$routes->post('tambah_keranjang', 'Kasir::tambah_keranjang');
		$routes->post('tambah_transaksi_sementara', 'Kasir::tambah_transaksi_sementara');
		$routes->put('ubah_jenis_kasir', 'Kasir::ubah_jenis_kasir');
		$routes->delete('hapus_barang', 'Kasir::hapus_barang');
		$routes->delete('hapus_keranjang', 'Kasir::hapus_keranjang');
		
		$routes->group('invoice', function($routes){
			$routes->get('(:any)', 'Invoice::index/$1', ['filter' => 'cek_akses']);
			$routes->post('tambah', 'Invoice::tambah');
			$routes->delete('hapus', 'Invoice::hapus');
		});
	});
	$routes->group('utang', function($routes){
		$routes->get('', 'Utang::index', ['filter' => 'cek_akses']);
		$routes->get('invoice/(:any)', 'InvoiceUtang::index/$1');
		$routes->post('invoice/tambah', 'InvoiceUtang::tambah');
	});
	$routes->group('barang_masuk', function($routes){
		$routes->get('', 'BarangMasuk::index', ['filter' => 'cek_akses']);
		$routes->post('tambah_barang', 'BarangMasuk::tambah_barang');
		$routes->post('tambah_pengirim', 'BarangMasuk::tambah_pengirim');
		$routes->post('tambah', 'BarangMasuk::tambah');
		$routes->get('ambil_detail', 'BarangMasuk::ambil_detail');
		$routes->post('ambil_harga', 'BarangMasuk::ambil_harga');
	});
});


$routes->group('laporan', function($routes){

	$routes->add('masuk/cari', 'LaporanMasuk::index', ['filter' => 'cek_akses']);
	$routes->add('keluar/cari', 'LaporanKeluar::index', ['filter' => 'cek_akses']);

	$routes->group('summary', function($routes){
		$routes->add('tanggal', 'LaporanSummary::index', ['filter' => 'cek_akses']);
		$routes->add('bulan', 'LaporanSummary::bulan', ['filter' => 'cek_akses']);
		$routes->add('tahun', 'LaporanSummary::tahun', ['filter' => 'cek_akses']);
	});
});



$routes->group('pengaturan', function($routes){

	$routes->group('role', function($routes){
		$routes->get('', 'Role::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'Role::tambah');
		$routes->put('ubah', 'Role::ubah');
		$routes->delete('hapus', 'Role::hapus');

		$routes->get('akses/(:num)', 'RoleAkses::index/$1');
		$routes->post('akses/ubah', 'RoleAkses::ubah');
	});
	$routes->group('menu', function($routes){
		$routes->get('', 'Menu::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'Menu::tambah');
		$routes->put('ubah', 'Menu::ubah');
		$routes->delete('hapus', 'Menu::hapus');
	});
	$routes->group('menu_utama', function($routes){
		$routes->get('', 'MenuUtama::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'MenuUtama::tambah');
		$routes->put('ubah', 'MenuUtama::ubah');
		$routes->delete('hapus', 'MenuUtama::hapus');
	});
	$routes->group('submenu', function($routes){
		$routes->get('', 'Submenu::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'Submenu::tambah');
		$routes->put('ubah', 'Submenu::ubah');
		$routes->delete('hapus', 'Submenu::hapus');
	});
});

$routes->group('tempat', function($routes){
	$routes->group('karyawan', function($routes){
		$routes->get('', 'Karyawan::index', ['filter' => 'cek_akses']);
		$routes->post('tambah', 'Karyawan::tambah');
		$routes->put('ubah', 'Karyawan::ubah');
		$routes->delete('hapus', 'Karyawan::hapus');
	});

	$routes->get('toko', 'Toko::index', ['filter' => 'cek_akses']);
	$routes->put('toko/ubah', 'Toko::ubah');

});










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

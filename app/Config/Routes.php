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


$routes->get('/', 'Beranda::index');




$routes->add('produk', 'Produk::index');



$routes->add('produk/(:segment)', 'Produk::detail_produk/$1');

$routes->get('kategori', 'Produk::kategori');
$routes->add('kategori/(:segment)', 'Produk::detail_kategori/$1');

$routes->get('merek', 'Produk::merek');
$routes->add('merek/(:segment)', 'Produk::detail_merek/$1');

$routes->get('penyuplai', 'Produk::penyuplai');
$routes->add('penyuplai/(:segment)', 'Produk::detail_penyuplai/$1');

$routes->get('profil', 'Profil::index');


$routes->get('pendaftaran', 'Pendaftaran::index');
$routes->post('pendaftaran/tambah', 'Pendaftaran::tambah');

$routes->get('konfirmasi', 'Konfirmasi::index');
$routes->put('konfirmasi/pilih-jenis', 'Konfirmasi::ubah');
$routes->put('konfirmasi/unggah-bukti', 'Konfirmasi::unggah');

$routes->get('pengajuan', 'Pengajuan::index');
$routes->post('pengajuan/ambil_barang', 'Pengajuan::ambil_barang');
$routes->post('pengajuan/tambah', 'Pengajuan::tambah');

$routes->get('pengajuan/riwayat', 'Pengajuan::riwayat');





$routes->get('login', 'Auth::index');
$routes->post('aksi_login', 'Auth::login');
$routes->post('logout', 'Auth::logout');
$routes->add('blokir', 'Auth::blokir');

$routes->add('verifikasi', 'Auth::verify');


$routes->group('akun', function($routes){
	$routes->get('profil', 'Pengguna::index', ['filter' => 'cek_akses']);
	$routes->put('profil/ubah', 'Pengguna::ubah');
	$routes->get('sandi', 'Sandi::index', ['filter' => 'cek_akses']);
	$routes->put('sandi/ubah', 'Sandi::ubah');
});

$routes->group('beranda', function($routes){

	$routes->get('dashboard_masuk', 'Dashboard::index', ['filter' => 'cek_akses']);
	$routes->get('dashboard_keluar', 'Dashboard::keluar', ['filter' => 'cek_akses']);	
});


$routes->group('suplai', function($routes){
	$routes->get('barang', 'Barang::index', ['filter' => 'cek_akses']);
	$routes->post('barang/tambah', 'Barang::tambah');
	$routes->put('barang/ubah', 'Barang::ubah');
	$routes->delete('barang/hapus', 'Barang::hapus');

	$routes->get('satuan', 'Satuan::index', ['filter' => 'cek_akses']);
	$routes->post('satuan/tambah', 'Satuan::tambah');
	$routes->put('satuan/ubah', 'Satuan::ubah');
	$routes->delete('satuan/hapus', 'Satuan::hapus');

	$routes->get('kategori', 'Kategori::index', ['filter' => 'cek_akses']);
	$routes->post('kategori/tambah', 'Kategori::tambah');
	$routes->put('kategori/ubah', 'Kategori::ubah');
	$routes->delete('kategori/hapus', 'Kategori::hapus');

	$routes->get('merek', 'Merek::index', ['filter' => 'cek_akses']);
	$routes->post('merek/tambah', 'Merek::tambah');
	$routes->put('merek/ubah', 'Merek::ubah');
	$routes->delete('merek/hapus', 'Merek::hapus');

	$routes->get('penyuplai', 'Penyuplai::index', ['filter' => 'cek_akses']);
	$routes->post('penyuplai/tambah', 'Penyuplai::tambah');
	$routes->put('penyuplai/ubah', 'Penyuplai::ubah');
	$routes->delete('penyuplai/hapus', 'Penyuplai::hapus');

});

$routes->group('fitur', function($routes){

	$routes->get('kasir', 'Kasir::index', ['filter' => 'cek_akses']);
	$routes->get('kasir/reset_csrf', 'Kasir::reset_csrf', ['filter' => 'cek_akses']);
	$routes->post('kasir/ambil_barang', 'Kasir::ambil_barang');
	$routes->post('kasir/tambah_keranjang', 'Kasir::tambah_keranjang');
	$routes->post('kasir/tambah_keranjang_qr', 'Kasir::tambah_keranjang_qr');
	$routes->post('kasir/tambah_transaksi_sementara', 'Kasir::tambah_transaksi_sementara');
	$routes->put('kasir/ubah_jenis_kasir', 'Kasir::ubah_jenis_kasir');
	$routes->delete('kasir/hapus_barang', 'Kasir::hapus_barang');
	$routes->delete('kasir/hapus_keranjang', 'Kasir::hapus_keranjang');

	$routes->get('kasir/invoice/(:any)', 'Invoice::index/$1', ['filter' => 'cek_akses']);
	$routes->put('kasir/invoice/ubah', 'Invoice::ubah');
	$routes->post('kasir/invoice/ambil_surel', 'Invoice::ambil_surel');
	$routes->delete('kasir/invoice/hapus', 'Invoice::hapus');	

	$routes->get('utang', 'Utang::index', ['filter' => 'cek_akses']);
	$routes->get('utang/invoice/(:any)', 'InvoiceUtang::index/$1');
	$routes->post('utang/invoice/tambah', 'InvoiceUtang::tambah');

	$routes->get('barang_masuk', 'BarangMasuk::index', ['filter' => 'cek_akses']);
	$routes->post('barang_masuk/tambah_barang', 'BarangMasuk::tambah_barang');
	$routes->post('barang_masuk/tambah_pengirim', 'BarangMasuk::tambah_pengirim');
	$routes->post('barang_masuk/tambah', 'BarangMasuk::tambah');
	$routes->get('barang_masuk/ambil_detail', 'BarangMasuk::ambil_detail');
	$routes->post('barang_masuk/ambil_harga', 'BarangMasuk::ambil_harga');

	$routes->add('retur', 'Retur::index', ['filter' => 'cek_akses']);
	$routes->post('retur/ambil_kode', 'Retur::ambil_kode');
	$routes->post('retur/tambah_keranjang', 'Retur::tambah_keranjang');
	$routes->post('retur/tambah_transaksi_sementara', 'Retur::tambah_transaksi_sementara');
	$routes->delete('retur/hapus_barang', 'Retur::hapus_barang');
	$routes->delete('retur/hapus_keranjang', 'Retur::hapus_keranjang');

	$routes->get('retur/invoice', 'InvoiceRetur::index', ['filter' => 'cek_akses']);
	$routes->post('retur/invoice/tambah', 'InvoiceRetur::tambah');
	$routes->delete('retur/invoice/hapus', 'InvoiceRetur::hapus');

	$routes->get('pendaftar', 'Pendaftar::index', ['filter' => 'cek_akses']);
	$routes->put('pendaftar/konfirm-online', 'Pendaftar::konfirm_online');
	$routes->post('pendaftar/konfirm-offline', 'Pendaftar::konfirm_offline');
	$routes->post('pendaftar/beritahu', 'Pendaftar::beritahu');

	$routes->get('pendaftar/invoice/(:any)', 'InvoicePendaftar::index/$1');
	$routes->put('pendaftar/invoice/ubah', 'InvoicePendaftar::ubah');

	$routes->get('pengaju', 'Pengaju::index', ['filter' => 'cek_akses']);
	$routes->put('pengaju/tolak', 'Pengaju::tolak');
	$routes->put('pengaju/terima', 'Pengaju::terima');
	$routes->put('pengaju/konfirm', 'Pengaju::konfirm');
});


$routes->group('laporan', function($routes){

	$routes->add('masuk', 'LaporanMasuk::index', ['filter' => 'cek_akses']);
	$routes->add('keluar', 'LaporanKeluar::index', ['filter' => 'cek_akses']);


	$routes->add('summary/tanggal', 'LaporanSummary::index', ['filter' => 'cek_akses']);
	$routes->add('summary/bulan', 'LaporanSummary::bulan', ['filter' => 'cek_akses']);
	$routes->add('summary/tahun', 'LaporanSummary::tahun', ['filter' => 'cek_akses']);

	$routes->get('keuangan-bulanan', 'LaporanKeuangan::index', ['filter' => 'cek_akses']);
	$routes->post('keuangan-bulanan/cari', 'LaporanKeuangan::cari');
	$routes->post('keuangan-bulanan/tambah', 'LaporanKeuangan::tambah');

	$routes->get('stok', 'LaporanStok::index', ['filter' => 'cek_akses']);
	$routes->post('stok/cari', 'LaporanStok::cari');

});



$routes->group('pengaturan', function($routes){

	$routes->get('role', 'Role::index', ['filter' => 'cek_akses']);
	$routes->post('role/tambah', 'Role::tambah');
	$routes->put('role/ubah', 'Role::ubah');
	$routes->delete('role/hapus', 'Role::hapus');


	$routes->get('role/akses/(:num)', 'RoleAkses::index/$1');
	$routes->post('role/akses/ubah', 'RoleAkses::ubah');

	$routes->get('menu', 'Menu::index', ['filter' => 'cek_akses']);
	$routes->post('menu/tambah', 'Menu::tambah');
	$routes->put('menu/ubah', 'Menu::ubah');
	$routes->delete('menu/hapus', 'Menu::hapus');

	$routes->get('menu_utama', 'MenuUtama::index', ['filter' => 'cek_akses']);
	$routes->post('menu_utama/tambah', 'MenuUtama::tambah');
	$routes->put('menu_utama/ubah', 'MenuUtama::ubah');
	$routes->delete('menu_utama/hapus', 'MenuUtama::hapus');

	$routes->get('submenu', 'Submenu::index', ['filter' => 'cek_akses']);
	$routes->post('submenu/tambah', 'Submenu::tambah');
	$routes->put('submenu/ubah', 'Submenu::ubah');
	$routes->delete('submenu/hapus', 'Submenu::hapus');

	$routes->get('kode/barang', 'KodeBarang::index', ['filter' => 'cek_akses']);
	$routes->put('kode/barang/ubah', 'KodeBarang::ubah');
	
	$routes->get('kode/transaksi', 'KodeTransaksi::index', ['filter' => 'cek_akses']);
	$routes->put('kode/transaksi/ubah', 'KodeTransaksi::ubah');

	$routes->get('kode/retur', 'KodeRetur::index', ['filter' => 'cek_akses']);
	$routes->put('kode/retur/ubah', 'KodeRetur::ubah');

	$routes->get('stok', 'Stok::index', ['filter' => 'cek_akses']);
	$routes->put('stok/ubah', 'Stok::ubah');
});

$routes->group('tempat', function($routes){

	$routes->get('karyawan', 'Karyawan::index', ['filter' => 'cek_akses']);
	$routes->post('karyawan/tambah', 'Karyawan::tambah');
	$routes->post('karyawan/ubah', 'Karyawan::ubah');
	$routes->delete('karyawan/hapus', 'Karyawan::hapus');

	$routes->get('toko', 'Toko::index', ['filter' => 'cek_akses']);
	$routes->post('toko/ubah', 'Toko::ubah');

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

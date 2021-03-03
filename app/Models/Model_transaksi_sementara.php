<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_transaksi_sementara extends Model
{
	protected $table                = 'transaksi_sementara';
	protected $primaryKey           = 'id_transaksi_sementara';
	protected $allowedFields        = [
	'ts_barang_id','ts_qty','ts_harga','ts_user_id','ts_role_id',
	'ts_kode_transaksi','ts_jumlah_uang','ts_kembalian','ts_uri',
	'ts_nama_pengutang','ts_nomor_pengutang','ts_status_transaksi','ts_tanggal_sementara'];

	
}

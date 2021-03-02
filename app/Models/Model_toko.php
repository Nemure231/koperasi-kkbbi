<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_toko extends Model
{
	protected $table                = 'toko';
	protected $primaryKey           = 'id_toko';
	protected $allowedFields        = [
		'nama_toko', 'telepon_toko', 'email_toko', 'alamat_toko',
		'deskripsi_toko', 'logo_toko', 'logo_koperasi_inter'
	];

}

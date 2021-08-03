<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_pengajuan extends Model
{

	protected $table                = 'pengajuan';
	protected $allowedFields        = ['penyuplai_id','kode', 'stok', 'alasan', 'status', 'tanggal'];




}

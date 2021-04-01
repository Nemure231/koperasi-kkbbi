<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_kode_retur extends Model
{
	protected $table                = 'tb_kode_retur';
	protected $primaryKey           = 'id_tb_kode_retur';
	protected $allowedFields        = ['huruf_kode_retur', 'jumlah_angka'];
	
}

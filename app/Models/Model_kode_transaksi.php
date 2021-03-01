<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_kode_transaksi extends Model
{
	protected $table                = 'tb_kode_transaksi';
	protected $primaryKey           = 'id_tb_kode_transaksi';
	protected $returnType           = 'array';
	protected $allowedFields        = ['huruf_kode_transaksi', 'jumlah_angka'];
	
}

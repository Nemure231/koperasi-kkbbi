<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_kode_barang extends Model
{
	protected $table                = 'tb_kode_barang';
	protected $primaryKey           = 'id_tb_kode_barang';
	protected $returnType           = 'array';
	protected $allowedFields        = ['huruf_kode_barang', 'jumlah_angka'];
	
}

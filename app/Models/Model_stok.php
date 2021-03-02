<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_stok extends Model
{
	protected $table                = 'stok';
	protected $primaryKey           = 'id_stok';
	protected $allowedFields        = ['min_stok'];


}

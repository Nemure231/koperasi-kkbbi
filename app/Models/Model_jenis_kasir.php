<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_jenis_kasir extends Model
{
	protected $table                = 'jenis_kasir';
	protected $primaryKey           = 'id_jenis_kasir';
	protected $allowedFields        = ['user_id', 'role_id'];

	
}

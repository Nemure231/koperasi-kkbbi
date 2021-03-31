<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_user_role extends Model
{
	protected $table                = 'user_role';
	protected $primaryKey           = 'id_role';
	protected $allowedFields        = ['role'];


}

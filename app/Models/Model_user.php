<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_user extends Model{

    protected $table = 'user';
    protected $allowedFields = ['nama', 'surel', 'sandi', 'telepon', 'alamat', 'role_id', 'status', 'tanggal'];
    
}

?>
<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_user extends Model{

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['nama', 'email', 'gambar', 'sandi', 'telepon', 'alamat', 'role_id', 'is_active', 'date_created'];
    
}
?>
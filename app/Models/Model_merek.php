<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_merek extends Model{

    protected $table = 'merek';
    protected $primaryKey = 'id_merek';
    protected $allowedFields = ['nama_merek'];
    
}
?>
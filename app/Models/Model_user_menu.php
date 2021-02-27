<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_user_menu extends Model{

    protected $table = 'user_menu';
    protected $primaryKey = 'id_menu';
    protected $allowedFields = ['menu'];
    protected $useAutoIncrement = true;
    
}
?>
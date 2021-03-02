<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_user_menu extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
     }

    protected $table = 'user_menu';
    protected $primaryKey = 'id_menu';
    protected $allowedFields = ['menu'];

    
}
?>
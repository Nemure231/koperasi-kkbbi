<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_user_sub_menu extends Model{

    protected $table = 'user_sub_menu';
    protected $primaryKey = 'id_submenu';
    protected $allowedFields = ['menu_id', 'judul', 'url', 'icon', 'is_active', 'menu_utama_id'];

    
}
?>
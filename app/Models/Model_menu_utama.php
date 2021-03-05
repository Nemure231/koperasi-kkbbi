<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_menu_utama extends Model{


    protected $table = 'menu_utama';
    protected $primaryKey = 'id_menu_utama';
    protected $allowedFields = ['menu_id', 'nama_menu_utama'];


    
}
?>
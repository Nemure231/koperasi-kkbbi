<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_sandi extends Model{


    protected $table = 'user';
    protected $allowedFields = 'sandi';


    public function EditKataSandi($password_hash){
            $session = \Config\Services::session();
            $id = $session->get('id');
            $db      = \Config\Database::connect();
            $builder = $db->table($this->table);
            // $queryB = "UPDATE `user` SET `sandi` = $password_hash WHERE `id` = $id
            // ";
            // $menu = $db->query($queryB);
            // return $menu;
            $builder->set($this->allowedFields, $password_hash);
            $builder->where('id', $id);
            return $query = $builder->update();
    }
}
?>
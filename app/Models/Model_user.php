<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_user extends Model{

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = 'gambar';


    // public function getBuku($judul2 = false){
    //     if($judul2 ==false){
    //         return $this->findAll();
    //     }

    //     return $this->where
    // }


    
}
?>
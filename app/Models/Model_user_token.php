<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_user_token extends Model{

    protected $table = 'user_token';
    protected $allowedFields = ['email_token', 'kode_token', 'date_created'];
    
}
?>
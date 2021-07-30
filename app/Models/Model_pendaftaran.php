<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_pendaftaran extends Model{

    protected $table = 'pendaftaran';
    protected $allowedFields = ['penyuplai_id', 'kode', 'biaya', 'bukti', 'status'];
    
}
?>
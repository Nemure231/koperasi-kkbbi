<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_pendaftaran extends Model{

    protected $table = 'pendaftaran';
    protected $allowedFields = ['penyuplai_id', 'user_id', 'kode', 'biaya', 'waktu_awal', 'waktu_akhir', 'tanggal'];
    
}
?>
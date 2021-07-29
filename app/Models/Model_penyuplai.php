<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_penyuplai extends Model{

    protected $table = 'penyuplai';
    protected $allowedFields = ['user_id', 'no_ktp', 'pekerjaan',
        'no_rekening', 'bank', 'atas_nama'
    ];
    
}
?>
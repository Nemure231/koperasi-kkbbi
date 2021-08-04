<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_pengeluaran extends Model{

    protected $table = 'pengeluaran';
    protected $allowedFields = ['nama', 'total', 'bulan',
        'tahun'
    ];
    
}
?>
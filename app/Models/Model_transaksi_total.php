<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_transaksi_total extends Model{

    protected $table = 'transaksi_total';
    protected $primaryKey = 'id_transaksi_total';
    protected $allowedFields = ['tt_kode_transaksi', 'tt_user_id', 'tt_role_id', 'tt_total_harga', 'tt_total_qty', 'tt_jumlah_uang', 'tt_kembalian', 'tt_nama_penerima', 'tt_telepon_penerima', 'tt_tanggal_beli'];
    protected $useAutoIncrement = true;
    
}
?>
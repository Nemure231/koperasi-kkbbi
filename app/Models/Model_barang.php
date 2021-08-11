<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_barang extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
    }

    protected $table = 'barang';
    // protected $primaryKey = 'id_barang';
    protected $allowedFields = [
        'nama', 'kode', 'kategori_id', 'satuan_id', 
        'merek_id', 'penyuplai_id', 'harga_pokok', 'harga_konsumen',
        'harga_anggota', 'stok_id', 'stok', 'deskripsi', 'gambar', 'status', 'qr',
        'tanggal', 'tanggal_update'];

    
    public function TambahStok($id, $stok){
        
        $this->db->query("update barang set stok=stok+'$stok' where id='$id'");
    }

            

}
?>
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


    public function AutoKodeBarang(){

        $this->db->transStart();
        $query = $this->db->table('barang')
                        ->select('RIGHT(barang.kode,5) as kode', FALSE)
                        ->orderBy('kode', 'DESC')
                       
                        ->limit(1)->get()->getRowArray();

            if (count($query) <>0) {
                //$query2 = $query->get()->getRowArray();
                $kode= intval($query['kode']) + 1;
            }else{
                $kode =1;
            }
       
        // $kode1 = $this->db->table('tb_kode_barang')
        //                     ->select('huruf_kode_barang, jumlah_angka')
        //                     ->get()->getRowArray();
    
            $batas= str_pad($kode, "".'5'."","0", STR_PAD_LEFT);
            $kodetampil= "".'BR-'."" .$batas;
            return $kodetampil;
            
        $this->db->transComplete();
    }
    
}
?>
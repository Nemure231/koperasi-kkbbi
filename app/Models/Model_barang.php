<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_barang extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
    }

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $returnType           = 'array';
    protected $allowedFields = ['nama_barang', 'kode_barang', 'kategori_id', 'satuan_id', 'merek_id', 'pengirim_barang_id', 'harga_pokok', 'harga_konsumen', 'harga_anggota', 'stok_id', 'stok_barang', 'deskripsi_barang', 'gambar_barang', 'tanggal', 'tanggal_update'];


    public function AutoKodeBarang(){

        $this->db->transStart();
        $query = $this->db->table('barang')
                        ->select('RIGHT(barang.kode_barang,2) as kode_barang', FALSE)
                        ->orderBy('kode_barang', 'DESC')
                       
                        ->limit(1)->get()->getRowArray();

            if (count($query) <>0) {
                //$query2 = $query->get()->getRowArray();
                $kode= intval($query['kode_barang']) + 1;
            }else{
                $kode =1;
            }
       
        $kode1 = $this->db->table('tb_kode_barang')
                            ->select('huruf_kode_barang, jumlah_angka')
                            ->get()->getRowArray();
    
            $batas= str_pad($kode, "".$kode1['jumlah_angka']."","0", STR_PAD_LEFT);
            $kodetampil= "".$kode1['huruf_kode_barang']."" .$batas;
            return $kodetampil;
            
        $this->db->transComplete();
    }
    
}
?>
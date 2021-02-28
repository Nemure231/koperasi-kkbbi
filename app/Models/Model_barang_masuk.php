<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_barang_masuk extends Model{


    public function __construct(){
        $this->db = \Config\Database::connect();
    }

    protected $table = 'barang_masuk';
    protected $primaryKey = 'id_barang_masuk';
    protected $allowedFields = [
        'barang_id', 'pengirim_barang_id', 'jumlah_barang_masuk', 
        'harga_pokok_pb', 'total_harga_pokok', 'tanggal_masuk'
    ];

    public function TambahBarangMasuk($data, $data2){
        $this->db->transStart();
        $builder = $this->db->table('barang_masuk');
        $builder->insertBatch($data);

        foreach ($data2 as  $dt):
            $datas[] = array(
                'bi' => $dt['barang_id'],
                'jml' =>  $dt['jumlah_barang_masuk'],
                'pbi' =>  $dt['pengirim_barang_id'],
                'hp' => $dt['harga_pokok_pb'],
                'ha' =>  $dt['harga_anggota'],
                'hk' =>  $dt['harga_konsumen'],
                
            );
            $jml = $dt['jumlah_barang_masuk'];
            $idb = $dt['barang_id'];
            $hp = $dt['harga_pokok_pb'];
            $ha = $dt['harga_anggota'];
            $hk = $dt['harga_konsumen'];
            $pbi = $dt['pengirim_barang_id'];
            $jmlesc = $this->db->escapeString($jml);
            $idbesc = $this->db->escapeString($idb);
            $hpesc = $this->db->escapeString($hp);
            $hkesc = $this->db->escapeString($hk);
            $haesc = $this->db->escapeString($ha);
            $pbiesc = $this->db->escapeString($pbi);
            $this->db->query("update barang set stok_barang=stok_barang+'$jmlesc' where id_barang='$idbesc'");
            $this->db->table('barang')->set('harga_pokok', $hpesc)
            ->set('harga_konsumen', $hkesc)->set('harga_anggota', $haesc)
            ->set('pengirim_barang_id', $pbiesc)
            ->where('id_barang', $idbesc)->update();
        endforeach;

        $this->db->transComplete();

    }
    
}
?>
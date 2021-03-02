<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_transaksi_total extends Model{

    public function __construct(){
        
		$this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
	}

    protected $table = 'transaksi_total';
    protected $primaryKey = 'id_transaksi_total';
    protected $allowedFields = ['tt_kode_transaksi', 'tt_user_id', 'tt_role_id', 'tt_total_harga', 'tt_total_qty', 'tt_jumlah_uang', 'tt_kembalian', 'tt_nama_penerima', 'tt_telepon_penerima', 'tt_tanggal_beli'];
    

    public function AutoKodeTransaksi(){
        date_default_timezone_set("Asia/Jakarta");
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $query = $this->db->table('transaksi_total')
                        ->select('RIGHT(transaksi_total.tt_kode_transaksi,2) as tt_kode_transaksi', FALSE)
                        ->orderBy('tt_kode_transaksi', 'DESC')
                        ->limit(1)->get()->getRowArray();

            if (count($query) <> 0) {
                //$query2 = $query->get()->getRowArray();
                $kode= intval($query['tt_kode_transaksi']) + 1;
            }else{
                $kode =1;
            }
       
        $kode1 = $this->db->table('tb_kode_transaksi')
                            ->select('huruf_kode_transaksi, jumlah_angka')
                            ->get()->getRowArray();
    
            $batas= str_pad($kode, "".$kode1['jumlah_angka']."","0", STR_PAD_LEFT);
            $bulan = date('my');
            $random = rand(1, 1000);
            $kodetampil= "".$kode1['huruf_kode_transaksi']."" .$random.$bulan.$id_user.$batas;
            return $kodetampil;
            
        $this->db->transComplete();
    }
}
?>
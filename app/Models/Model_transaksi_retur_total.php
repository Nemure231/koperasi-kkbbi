<?php namespace App\Models;
use CodeIgniter\Model;

class Model_transaksi_retur_total extends Model{

    public function __construct(){
        
		$this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
	}

    protected $table = 'transaksi_retur_total';
    protected $primaryKey = 'id_transaksi_retur_total';
    protected $returnType = 'array';
    protected $allowedFields = [
        'trt_transaksi_total_id', 'trt_kode_retur', 'trt_role_id',
        'trt_user_id', 'trt_r_total_harga', 'trt_r_qty','trt_n_total_harga',
        'trt_n_qty','trt_hp_kembalian', 'trt_hk_total_bayar', 'trt_hk_jumlah_uang',
        'trt_hk_kembalian','trt_tanggal'
    ];

    public function AutoKodeRetur(){
        date_default_timezone_set("Asia/Jakarta");
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $query = $this->db->table('transaksi_retur_total')
                        ->select('RIGHT(transaksi_retur_total.trt_kode_retur,2) as trt_kode_retur', FALSE)
                        ->orderBy('trt_kode_retur', 'DESC')
                        ->limit(1)->get()->getRowArray();

            if (count($query) <> 0) {
                //$query2 = $query->get()->getRowArray();
                $kode= intval($query['trt_kode_retur']) + 1;
            }else{
                $kode =1;
            }
       
        $kode1 = $this->db->table('tb_kode_retur')
                            ->select('huruf_kode_retur, jumlah_angka')
                            ->get()->getRowArray();
    
            $batas= str_pad($kode, "".$kode1['jumlah_angka']."","0", STR_PAD_LEFT);
            $bulan = date('dmy');
            $kodetampil= "".$kode1['huruf_kode_retur']."" .$bulan.$id_user.$batas;
            return $kodetampil;
            
        $this->db->transComplete();
    }

    
}
?>
<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_transaksi_sementara_retur extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
     }


    protected $table = 'transaksi_sementara_retur';
    protected $primaryKey = 'id_transaksi_sementara_retur';
    protected $allowedFields = [
    'tsr_transaksi_total_id','tsr_role_id', 'tsr_user_id',
    'tsr_kode_retur','tsr_r_barang_id','tsr_r_qty','tsr_r_subtotal',
    'tsr_n_barang_id','tsr_n_qty','tsr_n_subtotal','tsr_kembalian_pl',
    'tsr_total_bayar_k','tsr_jumlah_uang_k','tsr_kembalian_k'
    ];

    public function GetAllTransaksiSemantaraReturForInsertRetur(){
        $id_session = $this->session->get('id_user');
        $this->db->transStart();

        $builderrm = $this->db->table('transaksi_sementara_retur');
        $builderrm->select('tsr_r_barang_id, tsr_r_qty');
        $builderrm->where('tsr_r_barang_id>', 0);
        $builderrm->where('tsr_user_id', $id_session);
        $builderrm->join('barang', 'barang.id_barang = transaksi_sementara_retur.tsr_r_barang_id');
        //$builderrm->groupBy('k_kode_keranjang');
        $queryrm = $builderrm->get()->getResultArray();
       
        
        foreach ($queryrm as  $qtyrm):
            $data[] = array(
                'qty' =>  $qtyrm['tsr_r_qty'],
                'bi' => $qtyrm['tsr_r_barang_id']
            );
            $qty = $qtyrm['tsr_r_qty'];
            $idb = $qtyrm['tsr_r_barang_id'];
            $qtyesc = $this->db->escapeString($qty);
            $idbesc = $this->db->escapeString($idb);
            $stok = $this->db->query("update barang set stok_barang=stok_barang+'$qtyesc' where id_barang='$idbesc'");
        endforeach;


        


        $builder = $this->db->table('transaksi_sementara_retur');
        $builder->selectSUM('tsr_r_qty');
        $builder->selectSUM('tsr_r_subtotal');
        $builder->where('tsr_user_id', $id_session);
        $builder->groupBy('tsr_kode_retur');
        $query = $builder->get()->getRowArray();

        $buildern = $this->db->table('transaksi_sementara_retur');
        $buildern->select('tsr_transaksi_total_id, tsr_kode_retur, tsr_user_id, tsr_role_id, tsr_kembalian_pl, tsr_total_bayar_k, tsr_jumlah_uang_k, tsr_kembalian_k');
        $buildern->selectSUM('tsr_n_qty');
        $buildern->selectSUM('tsr_n_subtotal');
        $buildern->where('tsr_user_id', $id_session);
        $buildern->groupBy('tsr_kode_retur');
        $queryn = $buildern->get()->getRowArray();

            $data = array(
                'trt_transaksi_total_id' => $queryn['tsr_transaksi_total_id'],
                'trt_kode_retur' => $queryn['tsr_kode_retur'],
                'trt_role_id' => $queryn['tsr_role_id'],
                'trt_user_id' => $queryn['tsr_user_id'],
                'trt_r_total_harga' => $query['tsr_r_subtotal'],
                'trt_r_qty' => $query['tsr_r_qty'],
                'trt_n_total_harga' => $queryn['tsr_n_subtotal'],
                'trt_n_qty' => $queryn['tsr_n_qty'],
                'trt_hp_kembalian' => $queryn['tsr_kembalian_pl'],
                'trt_hk_total_bayar' =>  $queryn['tsr_total_bayar_k'],
                'trt_hk_jumlah_uang' =>   $queryn['tsr_jumlah_uang_k'],
                'trt_hk_kembalian' =>   $queryn['tsr_kembalian_k'],
                // 'tt_tanggal_beli' => $this->request->getPost('tt_tanggal_beli'),
            );
        //dd($data);
        $builder1 = $this->db->table('transaksi_retur_total');
        $builder1->insert($data);
        $lastID = $this->db->insertID();
       

        $builder2 = $this->db->table('transaksi_sementara_retur');
        $builder2->select('tsr_r_barang_id, tsr_r_qty, tsr_r_subtotal');
        $builder2->where('tsr_r_barang_id>', 0);
        $builder2->where('tsr_user_id', $id_session);
        $query2 = $builder2->get()->getResultArray();


        $builder2n = $this->db->table('transaksi_sementara_retur');
        $builder2n->select('tsr_n_barang_id, tsr_n_qty, tsr_n_subtotal');
        $builder2n->where('tsr_n_barang_id>', 0);
        $builder2n->where('tsr_user_id', $id_session);
        $query2n = $builder2n->get()->getResultArray();



        foreach ($query2 as  $qt2):
            $data1[] = array(
                'transaksi_total_retur_id' => $lastID,
                'r_barang_id' => $qt2['tsr_r_barang_id'],
                'r_qty' => $qt2['tsr_r_qty'],
                'r_subtotal' => $qt2['tsr_r_subtotal']
            );
        endforeach;

        foreach ($query2n as  $qt3):
            $data2[] = array(
                'transaksi_total_retur_id' => $lastID,
                'n_barang_id' =>  $qt3['tsr_n_barang_id'],
                'n_qty' =>  $qt3['tsr_n_qty'],
                'n_subtotal' =>  $qt3['tsr_n_subtotal']
            );
        endforeach;


        $builder3 = $this->db->table('transaksi_retur');
        $builder3->insertBatch($data1);
        $builder3->insertBatch($data2);
        $this->db->transComplete();
    }


    public function HapusAllInvoiceRetur(){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $builder1 = $this->db->table('transaksi_sementara_retur');
        $builder1->select('tsr_n_barang_id, tsr_n_qty');
        $builder1->where('tsr_n_barang_id >', 0);
        $builder1->where('tsr_user_id', $id_user);
        $builder1->join('barang', 'barang.id_barang = transaksi_sementara_retur.tsr_n_barang_id');
        //$builder1->groupBy('k_kode_keranjang');
        $query = $builder1->get()->getResultArray();
        //dd($query);
        
        foreach ($query as  $qt2):
            $data[] = array(
                'qty' =>  $qt2['tsr_n_qty'],
                'bi' => $qt2['tsr_n_barang_id']
            );
            $qty = $qt2['tsr_n_qty'];
            $idb = $qt2['tsr_n_barang_id'];
            $qtyesc = $this->db->escapeString($qty);
            $idbesc = $this->db->escapeString($idb);
            $stok = $this->db->query("update barang set stok_barang=stok_barang+'$qtyesc' where id_barang='$idbesc'");
        endforeach;

        $builder = $this->db->table('transaksi_sementara_retur');
        $builder->where('tsr_user_id', $id_user);
        $builder->delete();

        $this->db->transComplete();

        
    }
    
}
?>
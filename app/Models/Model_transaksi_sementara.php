<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_transaksi_sementara extends Model
{
	public function __construct(){
		$this->db = \Config\Database::connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();
	}


	public function HapusAllInvoiceAdmin($id){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();

        $builder1 = $this->db->table('transaksi');
        $builder1->select('transaksi.barang_id as ts_barang_id, transaksi.qty as ts_qty');
        $builder1->where('transaksi.detail_transaksi_id', $id);
        $builder1->join('detail_transaksi', 'detail_transaksi.id = transaksi.detail_transaksi_id');
        $builder1->join('barang', 'barang.id = transaksi.barang_id');
        $query = $builder1->get()->getResultArray();
        foreach ($query as  $qt2):
            $data[] = array(
                'qty' =>  $qt2['ts_qty'],
                'bi' => $qt2['ts_barang_id']
            );
            $qty = $qt2['ts_qty'];
            $idb = $qt2['ts_barang_id'];
            $stok = $this->db->query("update barang set stok=stok+'$qty' where id='$idb'");
        endforeach;

        $this->db->table('detail_transaksi')
                ->where('status', 2)
                ->where('id', $id)
                ->delete();

        $this->db->table('transaksi')
                ->where('detail_transaksi_id', $id)
                ->delete();
        $this->db->transComplete();

        
    }

	public function GetAllTransaksiSemantaraForInsertAdmin($kod){
        $id = $this->session->get('id_user');
        $this->db->transStart();
        $builder = $this->db->table('transaksi_sementara');
        $builder->select('ts_kode_transaksi, ts_user_id, ts_kembalian, ts_jumlah_uang, ts_role_id');
        $builder->selectSUM('ts_qty');
        $builder->selectSUM('ts_harga');
        $builder->where('ts_kode_transaksi', $kod);
        $builder->groupBy('ts_kode_transaksi');
        $query = $builder->get()->getRowArray();

            $data = array(
                'tt_kode_transaksi' => $query['ts_kode_transaksi'],
                'tt_total_qty' => $query['ts_qty'],
                'tt_user_id' => $query['ts_user_id'],
                'tt_role_id' => $query['ts_role_id'],
                'tt_total_harga' => $query['ts_harga'],
                'tt_kembalian' => $query['ts_kembalian'],
                'tt_nama_penerima' => htmlspecialchars($this->request->getPost('tt_nama_penerima'), ENT_QUOTES),
                // 'tt_alamat_penerima' =>  htmlspecialchars($this->request->getPost('tt_alamat_penerima'), ENT_QUOTES),
                // 'tt_keterangan' =>  htmlspecialchars($this->request->getPost('tt_keterangan'), ENT_QUOTES),
                'tt_jumlah_uang' => $query['ts_jumlah_uang'],
                'tt_tanggal_beli' => $this->request->getPost('tt_tanggal_beli'),
            );
        
        $builder1 = $this->db->table('transaksi_total');
        $builder1->insert($data);
        $lastID = $this->db->insertID();
       

        $builder2 = $this->db->table('transaksi_sementara');
        $builder2->select('ts_barang_id, ts_qty, ts_harga');
        $builder2->where('ts_kode_transaksi', $kod);
        $query2 = $builder2->get()->getResultArray();

        foreach ($query2 as  $qt2):
            $data1[] = array(
                't_transaksi_total_id' => $lastID,
                't_barang_id' => $qt2['ts_barang_id'],
                't_qty' => $qt2['ts_qty'],
                't_harga' => $qt2['ts_harga']
            );
        endforeach;
        $builder3 = $this->db->table('transaksi');
        $builder3->insertBatch($data1);
        $this->db->transComplete();
    }

    public function GetAllTransaksiSemantaraForInsertUtang($kod){
        $id_session = $this->session->get('id_user');
        $this->db->transStart();
        $builder = $this->db->table('transaksi_sementara');
        $builder->select('ts_kode_transaksi, ts_nama_pengutang ,ts_nomor_pengutang ,ts_user_id, ts_kembalian, ts_jumlah_uang, ts_role_id');
        $builder->selectSUM('ts_qty');
        $builder->selectSUM('ts_harga');
        $builder->where('ts_kode_transaksi', $kod);
        $builder->groupBy('ts_kode_transaksi');
        $query = $builder->get()->getRowArray();

            $data = array(
                'tt_kode_transaksi' => $query['ts_kode_transaksi'],
                'tt_user_id' => $query['ts_user_id'],
                'tt_role_id' => $query['ts_role_id'],
                'tt_total_harga' => $query['ts_harga'],
                'tt_total_qty' => $query['ts_qty'],
                'tt_jumlah_uang' => $this->request->getPost('tt_jumlah_uang'),
                'tt_kembalian' => $this->request->getPost('tt_kembalian'),
                'tt_nama_penerima' => $query['ts_nama_pengutang'],
                'tt_telepon_penerima' => $query['ts_nomor_pengutang'],
                //'tt_alamat_penerima' => htmlspecialchars($this->request->getPost('tt_alamat_penerima'), ENT_QUOTES),
                //'tt_keterangan' =>  htmlspecialchars($this->request->getPost('tt_keterangan'), ENT_QUOTES),
                'tt_tanggal_beli' => $this->request->getPost('tt_tanggal_beli'),
            );
        
        $builder1 = $this->db->table('transaksi_total');
        $builder1->insert($data);
        $lastID = $this->db->insertID();

        $builder2 = $this->db->table('transaksi_sementara');
        $builder2->select('ts_barang_id, ts_qty, ts_harga');
        $builder2->where('ts_kode_transaksi', $kod);
        $query2 = $builder2->get()->getResultArray();

        foreach ($query2 as  $qt2):
            $data1[] = array(
                't_transaksi_total_id' => $lastID,
                't_barang_id' => $qt2['ts_barang_id'],
                't_harga' => $qt2['ts_harga'],
                't_qty' => $qt2['ts_qty']
            );
        endforeach;
        $builder3 = $this->db->table('transaksi');
        $builder3->insertBatch($data1);
        $this->db->transComplete();
    }


	
}

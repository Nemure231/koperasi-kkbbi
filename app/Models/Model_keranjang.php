<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_keranjang extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
     }

    protected $table = 'keranjang';
    protected $allowedFields = [
        'barang_id', 'qty',	'harga', 'user_id',	'kode'	
    
    ];

    public function TambahKeranjangAdmin(){

        $id = $this->session->get('id_user');

        $qty = $this->request->getPost('k_qty');

        $remmin = str_replace("-", "", $qty);
        $remplus = str_replace("+", "", $remmin);
		
        $bukuid = $this->request->getPost('k_barang_id');
        //$roleid = $this->request->getPost('k_role_id');
        $harga = $this->request->getPost('k_harga_barang');
		$random = rand('1', '1000000000');
		$data = array(
			'barang_id' => $bukuid,
            'qty' =>  $remplus,
            'harga'=> $harga,
            'user_id' => $id,
			'kode' => ''.$random.'' . ''.$id.'' . ''.$bukuid.''
        );
        $status = false;
    
        $this->db->transStart();
        $builder = $this->db->table('keranjang');
        $data3 = $builder->insert($data);

        $qty = $data['qty'];
        $idb = $data['barang_id'];

        $qtyesc = $this->db->escapeString($qty);
        $idbesc = $this->db->escapeString($idb);

    
        $stok = $this->db->query("update barang set stok=stok-'$qtyesc' where id='$idbesc'");
        //$escape = $this->db->escapeString($stok);
        $this->db->transComplete();

        // $arr = array('success' => $status, 'data' => '');
        // if($data){
        //    $status = true;
        //    $this->session->setFlashdata('pesan_pembelian', 'Produk berhasil ditambahkan ke keranjang!');
        //    return $arr = array('status' => $status, 'data' => $data);
        // }
        
    }

    public function TambahKeranjangAdminQr(){

        $jenis_kasir = $this->request->getPost('jen_kas');
        $kode_barang = $this->request->getPost('qode_barang');

        $this->db->transStart();
        $builder_barang = $this->db->table('barang');
        if($jenis_kasir != 5){
            $barang= $builder_barang->select('nama as nama_barang, id as id_barang, stok as stok_barang')
                ->select('harga_konsumen as harga')
                ->where('id >', 0)
                ->where('harga_konsumen >', 0)
                ->where('kode', $kode_barang)
                ->get()
                ->getRowArray();
        }else{
            $barang= $builder_barang->select('nama as nama_barang, id as id_barang, stok as stok_barang')
                ->select('harga_anggota as harga')
                ->where('id >', 0)
                ->where('harga_anggota >', 0)
                ->where('kode', $kode_barang)
                ->get()
                ->getRowArray();
        }

        $id = $this->session->get('id_user');
        $qty = 1;
        $barangid = $barang['id_barang'];
        $harga = $barang['harga'];
		$random = rand('1', '1000000000');
		$data = array(
			'barang_id' => $barangid,
            'qty' =>  $qty,
            'harga'=> $harga,
            'user_id' => $id,
			'kode' => ''.$random.'' . ''.$id.'' . ''.$barangid.''
        );
        $status = false;
    

        $builder = $this->db->table('keranjang');
        $data3 = $builder->insert($data);

        $qty = $data['qty'];
        $idb = $data['barang_id'];

        $qtyesc = $this->db->escapeString($qty);
        $idbesc = $this->db->escapeString($idb);

    
        $stok = $this->db->query("update barang set stok=stok-'$qtyesc' where id='$idbesc'");
        $this->db->transComplete();

        $arr = array('success' => $status, 'data' => '');
        if($data){
           $status = true;
           $this->session->setFlashdata('pesan_pembelian', 'Produk berhasil ditambahkan ke keranjang!');
           return $arr = array('status' => $status, 'data' => $data);
        }
        
    }



    public function HapusKeranjangAdmin($kode){

        $this->db->transStart();
        $builder1 = $this->db->table('keranjang');
        $builder1->select('barang_id as k_barang_id, qty as k_qty');
        //$builder1->selectSUM('k_qty');
        $builder1->where('keranjang.kode', $kode);
        $builder1->join('barang', 'barang.id = keranjang.barang_id');
        $builder1->groupBy('keranjang.kode');
        $query = $builder1->get()->getRowArray();
        $qty = $query['k_qty'];
        $idb = $query['k_barang_id'];
        $qtyesc = $this->db->escapeString($qty);
        $idbesc = $this->db->escapeString($idb);

        $stok = $this->db->query("update barang set stok=stok+'$qty' where id='$idb'");

        $builder = $this->db->table('keranjang');
        $builder->where('kode', $kode);
        $builder->delete();

        $this->db->transComplete();
    }

    public function HapusAllKeranjangAdmin(){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $builder1 = $this->db->table('keranjang');
        $builder1->select('barang_id as k_barang_id, qty as k_qty');
        $builder1->where('user_id', $id_user);
        $builder1->join('barang', 'barang.id = keranjang.barang_id');
        //$builder1->groupBy('k_kode_keranjang');
        $query = $builder1->get()->getResultArray();
        //dd($query);
        
        foreach ($query as  $qt2):
            $data[] = array(
                'qty' =>  $qt2['k_qty'],
                'bi' => $qt2['k_barang_id']
            );
            $qty = $qt2['k_qty'];
            $idb = $qt2['k_barang_id'];
            $qtyesc = $this->db->escapeString($qty);
            $idbesc = $this->db->escapeString($idb);
            $stok = $this->db->query("update barang set stok=stok+'$qtyesc' where id='$idbesc'");
        endforeach;

        $builder = $this->db->table('keranjang');
        $builder->where('user_id', $id_user);
        $builder->delete();

        $this->db->transComplete();

        
    }

   
}
?>
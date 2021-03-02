<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_keranjang_retur extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
     }

    protected $table = 'keranjang_retur';
    protected $primaryKey = 'id_keranjang_retur';
    protected $allowedFields = [
        'id_keranjang_retur', 'kr_barang_id', 'kr_qty',
        'kr_harga',	'kr_user_id', 'kr_kode_keranjang'
    
    ];

    public function TambahKeranjangRetur(){

        $id = $this->session->get('id_user');

        $qty = $this->request->getPost('kr_qty');

        $remmin = str_replace("-", "", $qty);
        $remplus = str_replace("+", "", $remmin);
		
        $bukuid = $this->request->getPost('kr_barang_id');
        //$roleid = $this->request->getPost('k_role_id');
        $harga = $this->request->getPost('kr_harga');
		$random = rand('1', '1000000000');
		$data = array(
			'kr_barang_id' => $bukuid,
            'kr_qty' =>  $remplus,
            'kr_harga'=> $harga,
            'kr_user_id' => $id,
			'kr_kode_keranjang' => ''.$random.'' . ''.$id.'' . ''.$bukuid.''
        );
        $status = false;
    
        $this->db->transStart();
        $builder = $this->db->table('keranjang_retur');
        $data3 = $builder->insert($data);

        $qty = $data['kr_qty'];
        $idb = $data['kr_barang_id'];

        $qtyesc = $this->db->escapeString($qty);
        $idbesc = $this->db->escapeString($idb);

    
        $stok = $this->db->query("update barang set stok_barang=stok_barang-'$qtyesc' where id_barang='$idbesc'");
        //$escape = $this->db->escapeString($stok);
        $this->db->transComplete();

        $arr = array('success' => $status, 'data' => '');
        if($data){
           $status = true;
           $this->session->setFlashdata('pesan_pembelian', 'Produk berhasil ditambahkan ke keranjang retur!');
           return $arr = array('status' => $status, 'data' => $data);
        }
        
    }

    public function HapusKeranjangRetur($kode){

        $this->db->transStart();
        $builder1 = $this->db->table('keranjang_retur');
        $builder1->select('kr_barang_id, kr_qty');
        $builder1->where('kr_kode_keranjang', $kode);
        $builder1->join('barang', 'barang.id_barang = keranjang_retur.kr_barang_id');
        $builder1->groupBy('kr_kode_keranjang');
        $query = $builder1->get()->getRowArray();
        $qty = $query['kr_qty'];
        $idb = $query['kr_barang_id'];
        $qtyesc = $this->db->escapeString($qty);
        $idbesc = $this->db->escapeString($idb);

        $stok = $this->db->query("update barang set stok_barang=stok_barang+'$qty' where id_barang='$idb'");

        $builder = $this->db->table('keranjang_retur');
        $builder->where('kr_kode_keranjang', $kode);
        $builder->delete();

        $this->db->transComplete();
    }

    public function HapusAllKeranjangRetur(){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $builder1 = $this->db->table('keranjang_retur');
        $builder1->select('kr_barang_id, kr_qty');
        $builder1->where('kr_user_id', $id_user);
        $builder1->join('barang', 'barang.id_barang = keranjang_retur.kr_barang_id');
        $query = $builder1->get()->getResultArray();
        
        foreach ($query as  $qt2):
            $data[] = array(
                'qty' =>  $qt2['kr_qty'],
                'bi' => $qt2['kr_barang_id']
            );
            $qty = $qt2['kr_qty'];
            $idb = $qt2['kr_barang_id'];
            $qtyesc = $this->db->escapeString($qty);
            $idbesc = $this->db->escapeString($idb);
            $stok = $this->db->query("update barang set stok_barang=stok_barang+'$qtyesc' where id_barang='$idbesc'");
        endforeach;

        $builder = $this->db->table('keranjang_retur');
        $builder->where('kr_user_id', $id_user);
        $builder->delete();

        $this->db->transComplete();

        
    }
    
}
?>
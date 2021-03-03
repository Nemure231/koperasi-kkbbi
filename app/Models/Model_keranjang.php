<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_keranjang extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
     }

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $allowedFields = [
        'k_barang_id', 'k_qty',	'k_harga', 'k_user_id',	'k_kode_keranjang'	
    
    ];

    public function TambahKeranjangAdmin(){

        $id = $this->session->get('id_user');

        $qty = $this->request->getPost('k_qty');

        $remmin = str_replace("-", "", $qty);
        $remplus = str_replace("+", "", $remmin);
		
        $bukuid = $this->request->getPost('k_barang_id');
        //$roleid = $this->request->getPost('k_role_id');
        $harga = $this->request->getPost('k_harga');
		$random = rand('1', '1000000000');
		$data = array(
			'k_barang_id' => $bukuid,
            'k_qty' =>  $remplus,
            'k_harga'=> $harga,
            'k_user_id' => $id,
			'k_kode_keranjang' => ''.$random.'' . ''.$id.'' . ''.$bukuid.''
        );
        $status = false;
    
        $this->db->transStart();
        $builder = $this->db->table('keranjang');
        $data3 = $builder->insert($data);

        $qty = $data['k_qty'];
        $idb = $data['k_barang_id'];

        $qtyesc = $this->db->escapeString($qty);
        $idbesc = $this->db->escapeString($idb);

    
        $stok = $this->db->query("update barang set stok_barang=stok_barang-'$qtyesc' where id_barang='$idbesc'");
        //$escape = $this->db->escapeString($stok);
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
        $builder1->select('k_barang_id, k_qty');
        //$builder1->selectSUM('k_qty');
        $builder1->where('k_kode_keranjang', $kode);
        $builder1->join('barang', 'barang.id_barang = keranjang.k_barang_id');
        $builder1->groupBy('k_kode_keranjang');
        $query = $builder1->get()->getRowArray();
        $qty = $query['k_qty'];
        $idb = $query['k_barang_id'];
        $qtyesc = $this->db->escapeString($qty);
        $idbesc = $this->db->escapeString($idb);

        $stok = $this->db->query("update barang set stok_barang=stok_barang+'$qty' where id_barang='$idb'");

        $builder = $this->db->table('keranjang');
        $builder->where('k_kode_keranjang', $kode);
        $builder->delete();

        $this->db->transComplete();
    }

    public function HapusAllKeranjangAdmin(){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $builder1 = $this->db->table('keranjang');
        $builder1->select('k_barang_id, k_qty');
        $builder1->where('k_user_id', $id_user);
        $builder1->join('barang', 'barang.id_barang = keranjang.k_barang_id');
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
            $stok = $this->db->query("update barang set stok_barang=stok_barang+'$qtyesc' where id_barang='$idbesc'");
        endforeach;

        $builder = $this->db->table('keranjang');
        $builder->where('k_user_id', $id_user);
        $builder->delete();

        $this->db->transComplete();

        
    }

   
}
?>
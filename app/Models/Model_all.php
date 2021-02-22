<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_all extends Model{

    public function __construct(){
       $this->db = \Config\Database::connect();
       $this->request = \Config\Services::request();
       $this->session = \Config\Services::session();
	}
  
    protected $user = 'user';
    protected $user_menu = 'user_menu';
    protected $user_sub_menu = 'user_sub_menu';
    protected $user_access_menu = 'user_access_menu';
    protected $user_role = 'user_role';
    protected $barang = 'barang';
    protected $pengirim_barang = 'pengirim_barang';
    protected $stok = 'stok';
    protected $toko = 'toko';
    protected $merek = 'merek';
    protected $satuan = 'satuan';
    protected $kategori = 'kategori';
    protected $keranjang = 'keranjang';
    protected $keranjang_retur = 'keranjang_retur';
    protected $transaksi = 'transaksi';
    protected $transaksi_retur = 'transaksi_retur';
    protected $barang_masuk = 'barang_masuk';
    protected $transaksi_total = 'transaksi_total';
    protected $transaksi_retur_total = 'transaksi_retur_total';
    protected $transaksi_sementara = 'transaksi_sementara';
    protected $transaksi_sementara_retur = 'transaksi_sementara_retur';
    protected $tb_kode_barang = 'tb_kode_barang';
    protected $tb_kode_transaksi = 'tb_kode_transaksi';
    protected $tb_kode_retur = 'tb_kode_retur';
    protected $jenis_kasir = 'jenis_kasir';
    protected $user_token = 'user_token';



    

    ////////////////////////////////////MODEL LOGIN//////////////////////////////////////////////
    
    
    public function GetUserEmail($email = null){
        
        $builder = $this->db->table($this->user);
        return $query =  $builder->select('id_user, sandi, nama, email, role_id, is_active')->where('email', $email)->get()->getRowArray();
    }

    public function UserLogin(){
        
        $email = $this->session->get('email');
        
        $builder = $this->db->table($this->user);
        return $query = $builder->select('id_user, nama, email, telepon, gambar, alamat, role')
                                ->join('user_role', 'user_role.id_role = user.role_id')
                                ->where(['email' => $email])->get()
                                ->getRowArray();
    }

    public function Tendang(){

        
        $role_id = $this->session->get('role_id');
        
        $uri = $this->request->uri;
        
        $menu = $uri->getSegment(1);
        $builder = $this->db->table($this->user_menu);
        $builder1 = $this->db->table($this->user_access_menu);
        $this->db->transStart();
        $queryMenu = $builder->select('id_menu')->where(['menu' => $menu])->get()->getRowArray();
        $menu_id = $queryMenu['id_menu'];
        return $query = $builder1->select('role_id, menu_id')
                            ->where(['role_id' => $role_id, 'menu_id' => $menu_id])
                            ->countAllResults();
        $this->db->transComplete();

    }

    //////////////////////////////////////MODEL SESSION///////////////////////////////////////////


    /////////////////////////////////MODEL SIDEBAR/////////////////////////////////
    public function MenuAll(){
        
        
        $builder = $this->db->table($this->user_menu);

        $role_id = $this->session->get('role_id');
        
        $builder->select('id_menu')->select('menu');
        $builder->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu');
        $builder->where('user_access_menu.role_id =', $role_id);
        $builder->orderBy('user_access_menu.menu_id', 'ASC');
        $builder->orderBy('user_access_menu.role_id', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    ///////////////////////////////MODEL MENU/////////////////////////////////////
    // public function HitungMenu(){
    //     return $builder = $this->db->table($this->user_menu)->countAllResults();
    // }

    public function GetAllMenu() {
        
        $builder = $this->db->table($this->user_menu);
        return $query= $builder->select('id_menu, menu')->get()->getResultArray();
    }
        
    // public function GetIdMenu($id){
        
    //     $builder = $this->db->table($this->user_menu);
	// 	return $query = $builder->getWhere(['id_menu' => $id])->getRowArray();
	// }

	public function TambahMenu($data){
        
        $builder = $this->db->table($this->user_menu);
        $builder->insert($data);
        
    }

    public function TambahMenu1($mei){
        
        $builder = $this->db->table($this->user_menu);
        $builder->set('menu', $mei);
        $builder->insert();
        $query = $this->db->insertID();
        return $query;
    }

	public function EditMenu($data, $id){
        
		$builder = $this->db->table($this->user_menu);
		$builder->where('id_menu', $id);
		$builder->update($data);
	}

	
    
    public function HapusMenu($id_menu){
        $builder = $this->db->table($this->user_menu);
        $builder->where('id_menu', $id_menu);
        $builder->delete();
    }

	

    /////////////////////////MODEL SUBMENU///////////////////////////////////////


    public function sub_conex($menuId){
        $builder = $this->db->table('user_sub_menu');
        $builder->select('judul, id_submenu, url, icon');
        $builder->join('user_menu', 'user_menu.id_menu = user_sub_menu.menu_id');
        $builder->where('user_sub_menu.menu_id', $menuId);
        $builder->where('user_sub_menu.is_active', 1);
        $query = $builder->get()->getResultArray();
        return $query;
    }

    // public function HitungSubMenu(){
    //     return $builder = $this->db->table($this->user_sub_menu)->countAllResults();
    //  }

    public function GetAllSubMenu() {
        
        $builder = $this->db->table($this->user_sub_menu);
        return $query= $builder->select('id_menu, menu_id,menu, judul, url, icon, is_active, id_submenu')   
            ->join('user_menu', 'user_menu.id_menu = user_sub_menu.menu_id')
                ->get()
                ->getResultArray();
    }
        
    // public function GetIdSubMenu($id){
        
    //     $builder = $this->db->table($this->user_sub_menu);
	// 	return $query = $builder->getWhere(['id_submenu' => $id])->getRowArray();
	// }

	public function TambahSubMenu($data){
        
        $builder = $this->db->table($this->user_sub_menu);
        $builder->insert($data);

    }

	public function EditSubMenu($data, $id){
        
        $builder = $this->db->table($this->user_sub_menu);   
		$builder->where('id_submenu', $id);
		$builder->update($data);
	}

	public function HapusSubMenu($id_submenu){
        
        $builder = $this->db->table($this->user_sub_menu);
        $builder->where('id_submenu', $id_submenu);
        $builder->delete();
	}

    ///////////////////////////////MODEL ROLE/////////////////////////////////////
    // public function HitungRole(){
    //     return $builder = $this->db->table($this->user_role)->countAllResults();
    //  }

    public function GetAllRole() {
        
        $builder = $this->db->table($this->user_role);
        return $query= $builder->select('id_role, role')->where('id_role!=', 4)->where('id_role!=', 5)->get()->getResultArray();
    }
        
    // public function GetIdRole($id){
        
    //     $builder = $this->db->table($this->user_role);
	// 	return $query = $builder->getWhere(['id_role' => $id])->getRowArray();
    // }
    
    public function GetIdRole2($role_id){
        
        $builder = $this->db->table($this->user_role);
		return $query = $builder->getWhere(['id_role' => $role_id])->getRowArray();
    }


	public function TambahRole($data){
        
        $builder = $this->db->table($this->user_role);
        $builder->insert($data);
    }

	public function EditRole($data, $id_role){
        $builder = $this->db->table($this->user_role);
		$builder->where('id_role', $id_role);
		$builder->update($data);
	}

	public function HapusRole($id_role){
        
        $builder = $this->db->table($this->user_role);
        $builder->where('id_role', $id_role);
        $builder->delete();
	}
    ///////////////////////////MODEL Pengguna////////////////////////////

    public function EditPengguna($edit, $id){
        $builder = $this->db->table($this->user);
        $builder->where('id_user', $id);
        $builder->update($edit);
    }
    

    ///////////////////////////////////MODEL KATA SANDI//////////////////


    // public function GetIdKatasandi($id){
        
    //     $builder = $this->db->table('user');
	// 	return $query = $builder->getWhere(['id_user' => $id])->getRowArray();
	// }


	public function EditKatasandi($password_hash){
        $id = $this->session->get('id_user');
        $builder = $this->db->table($this->user);
        $builder->set('sandi', $password_hash);
		$builder->where('id_user', $id);
		$builder->update();
		//return $query = $this->db->affectedRows();
    }

    public function UserLoginSandi(){
        
        $email = $this->session->get('email');
        
        $builder = $this->db->table($this->user);
        return $query = $builder->select('sandi')
                                ->where(['email' => $email])->get()
                                ->getRowArray();
    }

    ////////////////////////////////////////MODEL ROLE AKSES/////////////////////

    public function GetAllMenuNRole(){
        
        $builder = $this->db->table($this->user_menu);
        $builder->select('id_menu, menu');
        $builder->where('id_menu !=', 1)->where('menu !=', 'Role');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function UbahRole($role_id, $menu_id){
        
        
        $builder = $this->db->table($this->user_access_menu);
		$menu_id = $this->request->getPost('menuId');
		$role_id = $this->request->getPost('roleId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];

		$result = $builder->where($data)->countAllResults();

		if($result < 1){
			return $query= $builder->insert($data);
		}else{
			return $queryy = $builder->delete($data);
		}
    }
    

    public function CekAkses($role_id , $menu_id){
        
        $builder1 = $this->db->table('user_access_menu');
        $builder1->select('role_id, menu_id')->where(['role_id' => $role_id, 'menu_id' => $menu_id]);
        return $result = $builder1->countAllResults();
    }
    

    /////////////////////////////////////////MODEL BARANG////////////////////////////////////
    
    public function GetAllBarangForBarangMasuk(){
        $builder = $this->db->table($this->barang);
        $builder->select('nama_barang, id_barang');
        $builder->where('id_barang>', 0);
        $query = $builder->get()->getResultArray();
        return $query;

    }

    public function HapusBarang($barang_id){
        // $buku_id = $this->request->getPost('barang_id');
         $builder2 = $this->db->table($this->barang)->where('id_barang', $barang_id)->delete();
     }
    
    public function GetAllBarang(){
        $builder = $this->db->table($this->barang);
        $builder->select('id_barang, deskripsi_barang, harga_pokok,gambar_barang, nama_barang, nama_pengirim_barang, pengirim_barang_id, nama_kategori, kode_barang, stok_barang, tanggal, tanggal_update,nama_merek, nama_satuan, kategori_id, satuan_id, merek_id, harga_anggota, harga_konsumen');
        $builder->join('kategori', 'kategori.id_kategori = barang.kategori_id');
        $builder->join('satuan', 'satuan.id_satuan = barang.satuan_id');
        $builder->join('merek', 'merek.id_merek = barang.merek_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function TambahBarang($data){
        $builder = $this->db->table($this->barang);
        $builder->insert($data);
    }

    public function EditBarang($data, $id){
        $builder = $this->db->table($this->barang);
        $builder->where('id_barang', $id);
        $builder->update($data);
    }

    

    ////////////////////////////////////////MODEL KARYAWAN//////////////////////////////////
    public function CountUser(){

        $builder = $this->db->table($this->user);
        $query = $builder->countAllResults();
        return $query;
    }

    public function GetAllUser(){
        $builder = $this->db->table($this->user);
        $builder->select('id_user, role_id, nama, email, gambar, alamat, telepon, is_active, role');
        $builder->join('user_role', 'user_role.id_role = user.role_id');
        $query = $builder->get()->getResultArray();
        return $query;

    }
    /////////////////////////////////////////MODEL KODE BUKU ////////////////////////////////

    public function GetRowTbKodeBarang() {
        
        $builder = $this->db->table($this->tb_kode_barang);
        return $query= $builder->select('id_tb_kode_barang, huruf_kode_barang, jumlah_angka')->get()->getRowArray();
    }

    public function UbahKodeBarang($ubah, $id){

        $builder = $this->db->table($this->tb_kode_barang);
        $builder->where('id_tb_kode_barang', $id);
        $query = $builder->update($ubah);
        return $query;

    }

    public function AutoKodeBarang(){

        $this->db->transStart();
        $query = $this->db->table($this->barang)
                        ->select('RIGHT(barang.kode_barang,2) as kode_barang', FALSE)
                        ->orderBy('kode_barang', 'DESC')
                       
                        ->limit(1)->get()->getRowArray();

            if (count($query) <>0) {
                //$query2 = $query->get()->getRowArray();
                $kode= intval($query['kode_barang']) + 1;
            }else{
                $kode =1;
            }
       
        $kode1 = $this->db->table($this->tb_kode_barang)
                            ->select('huruf_kode_barang, jumlah_angka')
                            ->get()->getRowArray();
    
            $batas= str_pad($kode, "".$kode1['jumlah_angka']."","0", STR_PAD_LEFT);
            $kodetampil= "".$kode1['huruf_kode_barang']."" .$batas;
            return $kodetampil;
            
        $this->db->transComplete();
    }

    /////////////////////////////////////MODEL KARYAWAN////////////////////////////////////
    public function TambahKaryawan($tambah){
        $this->db->transStart();
        $builder = $this->db->table($this->user);
        $builder->insert($tambah);
        $id = $this->db->insertID();

        $data = [
            'user_id' => $id,
            'role_id' => 4
        ];


        $builder1 = $this->db->table($this->jenis_kasir);
        $builder1->insert($data);
        $this->db->transComplete();

    }

    public function EditKaryawan($edit, $id_user){
        
        $builder = $this->db->table($this->user);
        $builder->where('id_user', $id_user);
        $builder->update($edit);

    }

    public function HapusKaryawan($id_user){
        $this->db->transStart();
        $user_id = $this->request->getPost('user_id');
        $builder = $this->db->table($this->user);
        $builder->where('id_user', $id_user)->delete();

        $builder1 = $this->db->table($this->jenis_kasir);
        $builder1->where('user_id', $id_user);
        $builder1->delete();
        $this->db->transComplete();

    }


    //////////////////////////////////////////////MODEL CART////////////////////////

    public function GetAllKeranjang(){
        $id_user = $this->session->get('id_user');

        $builder = $this->db->table($this->keranjang);
        $builder->select('id_keranjang, k_qty, k_kode_keranjang,nama_barang, k_barang_id, COUNT(k_qty) as to_qty');
        $builder->select('k_harga as harga');
        $builder->selectSUM('k_qty', 'tt_qty');
        $builder->where('k_user_id', $id_user);
        $builder->join('barang', 'barang.id_barang = keranjang.k_barang_id');
        $builder->groupBy('k_barang_id');
        $query = $builder->get();
        return $query->getResultArray();
      // $this->db->transComplete();
    }
    
   

    // public function TambahKeranjang(){

    //     $id = $this->session->get('id_user');

    //     $qty = $this->request->getPost('k_qty');

    //     $remmin = str_replace("-", "", $qty);
    //     $remplus = str_replace("+", "", $remmin);
		
	// 	$bukuid = $this->request->getPost('k_buku_id');
	// 	$random = rand('1', '1000000000');
	// 	$data = array(
	// 		'k_buku_id' => $bukuid,
	// 		'k_qty' =>  $remplus,
	// 		'k_user_id' => $id,
	// 		'k_kode_keranjang' => ''.$random.'' . ''.$id.'' . ''.$bukuid.''
    //     );
    //     $status = false;
    
    //     $this->db->transStart();
    //     $builder = $this->db->table($this->keranjang);
    //     $data3 = $builder->insert($data);

    //     $qty = $data['k_qty'];
    //     $idb = $data['k_buku_id'];

    //     $qtyesc = $this->db->escapeString($qty);
    //     $idbesc = $this->db->escapeString($idb);

    
    //     $stok = $this->db->query("update buku set stok_buku=stok_buku-'$qtyesc' where id_buku='$idbesc'");
    //     //$escape = $this->db->escapeString($stok);
    //     $this->db->transComplete();

    //     $arr = array('success' => $status, 'data' => '');
    //     if($data){
    //        $status = true;
    //        $this->session->setFlashdata('pesan_pro', 'Produk berhasil ditambahkan ke keranjang!');
    //        return $arr = array('status' => $status, 'data' => $data);
    //     }
        
    // }
    


    public function HapusAllKeranjang(){
        $id_user = $this->session->get('id_user');
        $builder = $this->db->table($this->keranjang);
        $builder->where('k_user_id', $id_user);
        $builder->delete();

    }

   


    //////////////////////////////////////////////////MODEL STOK//////////////////////////////
    public function GetRowStok(){
        
        $builder = $this->db->table($this->stok);
        $builder->select('min_stok, id_stok');
        $builder->where('id_stok', 58);
        $query = $builder->get()->getRowArray();
        return $query;
    }

    public function EditStok($edit, $id_stok){

        $builder = $this->db->table($this->stok);
        $builder->where('id_stok', $id_stok);
        $query = $builder->update($edit);
    }

    public function GetAllStokHampirHabis() {

        $queryB ="SELECT `jb`,`mins`,`sb`, `kd`
                  FROM
                    (SELECT `stok_barang` AS `sb`,
                      `nama_barang` AS `jb`, 
                      `min_stok` AS `mins`,
                      `kode_barang` AS `kd`
                     
                      FROM `barang`
                      JOIN `stok` ON `barang`.`stok_id` = `stok`.`id_stok`
                      WHERE `id_barang` > '0')
                    AS `S`
                  WHERE `sb` < `mins`

                  GROUP BY `jb`";
        $menu = $this->db->query($queryB)->getResultArray();
        return $escape = $this->db->escapeString($menu);

        // $this->db->transStart();

        // $builder = $this->db->table($this->stok);
        // $builder->select('min_stok');
        // $builder->where('id_stok', 58);
        // $query = $builder->get()->getRowArray();
        

        // $builder1 = $this->db->table($this->buku);
        // $builder1->select('judul_buku, min_stok as `ms` ');
        // $builder1->join('stok', 'stok.id_stok = buku.stok_id');
        // $builder1->where('ms=', $query['min_stok']);
        // return $builder1->get()->getResultArray();

        // $this->db->transComplete();
    }


    ///////////////////////////////////MODEL REGISTRASI //////////////////////////////

    public function TambahRegis($tambah){
        $builder = $this->db->table($this->user);
        $builder->insert($tambah);
    }

    public function TambahToken($tambah){
        $builder = $this->db->table($this->user_token);
        $builder->insert($tambah);
    }

    public function GetUserEmailForVerify($email){
        $builder = $this->db->table($this->user);
        $query = $builder->getWhere(['email' => $email])->getRowArray();
        return $query;

    }
    
    public function GetUserTokenForVerify($token){
        
        $builder = $this->db->table($this->user_token);
        $query = $builder->getWhere(['kode_token' => $token])->getRowArray();
        return $query;
    }
    
    public function UpdateToken1($email){
        $builder = $this->db->table($this->user);
		$builder->set('is_active', 1);
    	$builder->where('email', $email);
    	$builder->update();
    }
    
    public function DeleteToken($email){
        $builder = $this->db->table($this->user_token);
        $builder->where('email_token', $email);
        $builder->delete();
    }
    
    public function DeleteUser($email){
        $builder = $this->db->table($this->user);
        $builder->where('email', $email);
        $builder->delete();
    }
    
    //////////////////////////////////MODEL PROFIL USER////////////////

    public function EditProfil($edit, $id){
        $builder = $this->db->table($this->user);
        $builder->where('id_user', $id);
        $builder->update($edit);
    }



    ///////////////////////////////MODEL TRANSAKSI//////////////////////////////////
    public function AutoKodeTransaksi(){
        date_default_timezone_set("Asia/Jakarta");
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $query = $this->db->table($this->transaksi_total)
                        ->select('RIGHT(transaksi_total.tt_kode_transaksi,2) as tt_kode_transaksi', FALSE)
                        ->orderBy('tt_kode_transaksi', 'DESC')
                        ->limit(1)->get()->getRowArray();

            if (count($query) <> 0) {
                //$query2 = $query->get()->getRowArray();
                $kode= intval($query['tt_kode_transaksi']) + 1;
            }else{
                $kode =1;
            }
       
        $kode1 = $this->db->table($this->tb_kode_transaksi)
                            ->select('huruf_kode_transaksi, jumlah_angka')
                            ->get()->getRowArray();
    
            $batas= str_pad($kode, "".$kode1['jumlah_angka']."","0", STR_PAD_LEFT);
            $bulan = date('my');
            $random = rand(1, 1000);
            $kodetampil= "".$kode1['huruf_kode_transaksi']."" .$random.$bulan.$id_user.$batas;
            return $kodetampil;
            
        $this->db->transComplete();
    }


    public function GetRowTbKodeTransaksi() {
        
        $builder = $this->db->table($this->tb_kode_transaksi);
        return $query= $builder->select('id_tb_kode_transaksi, huruf_kode_transaksi, jumlah_angka')->get()->getRowArray();
    }

    public function UbahKodeTransaksi($ubah, $id){

        $builder = $this->db->table($this->tb_kode_transaksi);
        $builder->where('id_tb_kode_transaksi', $id);
        $query = $builder->update($ubah);
        return $query;

    }

     ///////////////////////////////MODEL RETUR//////////////////////////////////
     public function AutoKodeRetur(){
        date_default_timezone_set("Asia/Jakarta");
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $query = $this->db->table($this->transaksi_retur_total)
                        ->select('RIGHT(transaksi_retur_total.trt_kode_retur,2) as trt_kode_retur', FALSE)
                        ->orderBy('trt_kode_retur', 'DESC')
                        ->limit(1)->get()->getRowArray();

            if (count($query) <> 0) {
                //$query2 = $query->get()->getRowArray();
                $kode= intval($query['trt_kode_retur']) + 1;
            }else{
                $kode =1;
            }
       
        $kode1 = $this->db->table($this->tb_kode_retur)
                            ->select('huruf_kode_retur, jumlah_angka')
                            ->get()->getRowArray();
    
            $batas= str_pad($kode, "".$kode1['jumlah_angka']."","0", STR_PAD_LEFT);
            $bulan = date('dmy');
            $kodetampil= "".$kode1['huruf_kode_retur']."" .$bulan.$id_user.$batas;
            return $kodetampil;
            
        $this->db->transComplete();
    }


    public function GetRowTbKodeRetur() {
        
        $builder = $this->db->table($this->tb_kode_retur);
        return $query= $builder->select('id_tb_kode_retur, huruf_kode_retur, jumlah_angka')->get()->getRowArray();
    }

    public function UbahKodeRetur($ubah, $id){

        $builder = $this->db->table($this->tb_kode_retur);
        $builder->where('id_tb_kode_retur', $id);
        $query = $builder->update($ubah);
        return $query;

    }


    /////////////////////////////////////MODEL INVOICE ADMIN/////////////////////////////////

    
    public function GetAllTransaksiSementaraAdmin($kod){

        $id = $this->session->get('id_user');
        $builder = $this->db->table($this->transaksi_sementara);
        $builder->select('nama_barang, ts_harga, ts_qty, ts_role_id');
        $builder->select('harga_konsumen, harga_anggota');
        $builder->join('barang', 'barang.id_barang = transaksi_sementara.ts_barang_id');
        $builder->where('ts_user_id', $id);
        $builder->where('ts_status_transaksi', 1);
        $builder->where('ts_kode_transaksi', $kod);
        $query = $builder->get()->getResultArray();
        return $query;
        
    }

    public function GetRowTransaksiSementaraAdmin($kod){
        $id = $this->session->get('id_user');
        $builder = $this->db->table($this->transaksi_sementara);
        $builder->select('ts_kode_transaksi, telepon, ts_uri, ts_jumlah_uang, ts_kembalian, nama, alamat, ts_harga');
        $builder->where('ts_kode_transaksi', $kod);
        $builder->join('barang', 'barang.id_barang = transaksi_sementara.ts_barang_id');
        $builder->join('user', 'user.id_user = transaksi_sementara.ts_user_id');
        $builder->groupBy('ts_kode_transaksi');
        $query = $builder->get()->getRowArray();
        return $query;

    }

    public function GetAllTransaksiSemantaraForInsertAdmin($kod){
        $id = $this->session->get('id_user');
        $this->db->transStart();
        $builder = $this->db->table($this->transaksi_sementara);
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
        
        $builder1 = $this->db->table($this->transaksi_total);
        $builder1->insert($data);
        $lastID = $this->db->insertID();
       

        $builder2 = $this->db->table($this->transaksi_sementara);
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
        $builder3 = $this->db->table($this->transaksi);
        $builder3->insertBatch($data1);
        $this->db->transComplete();
    }

    public function HapusTransaksiSementaraAdmin($uri){
        $id_session = $this->session->get('id_user');
        $builder = $this->db->table($this->transaksi_sementara);
        $builder->where('ts_uri', $uri);
        $builder->delete();

    }


    public function HapusAllInvoiceAdmin($kod, $uri){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $builder1 = $this->db->table($this->transaksi_sementara);
        $builder1->select('ts_barang_id, ts_qty');
        $builder1->where('ts_kode_transaksi', $kod);
        $builder1->join('barang', 'barang.id_barang = transaksi_sementara.ts_barang_id');
        //$builder1->groupBy('k_kode_keranjang');
        $query = $builder1->get()->getResultArray();
        //dd($query);
        
        foreach ($query as  $qt2):
            $data[] = array(
                'qty' =>  $qt2['ts_qty'],
                'bi' => $qt2['ts_barang_id']
            );
            $qty = $qt2['ts_qty'];
            $idb = $qt2['ts_barang_id'];
            $qtyesc = $this->db->escapeString($qty);
            $idbesc = $this->db->escapeString($idb);
            $stok = $this->db->query("update barang set stok_barang=stok_barang+'$qtyesc' where id_barang='$idbesc'");
        endforeach;

        $builder = $this->db->table($this->transaksi_sementara);
        $builder->where('ts_status_transaksi', 1);
        $builder->where('ts_uri', $uri);
        $builder->delete();

        $this->db->transComplete();

        
    }


    /////////////////////////////////////MODEL INVOICE RETUR/////////////////////////////////

    
    public function GetAllReturSementaraRiwayat(){

        $id = $this->session->get('id_user');
        $builder = $this->db->table($this->transaksi_sementara_retur);
        $builder->select('nama_barang, tsr_role_id, tsr_r_qty, tsr_r_subtotal, tsr_r_barang_id');
        $builder->select('harga_konsumen, harga_anggota');
        $builder->where('tsr_r_barang_id >', 0);
        $builder->join('barang', 'barang.id_barang = transaksi_sementara_retur.tsr_r_barang_id');
        //$builder->join('barang', 'barang.id_barang = transaksi_sementara_retur.tsr_r_barang_id');
        $builder->where('tsr_user_id', $id);
        $query = $builder->get()->getResultArray();
        return $query;
        
    }

    public function GetAllReturSementaraNew(){

        $id = $this->session->get('id_user');
        $builder = $this->db->table($this->transaksi_sementara_retur);
        $builder->select('nama_barang, tsr_role_id, tsr_n_qty, tsr_n_subtotal, tsr_n_barang_id');
        $builder->select('harga_konsumen, harga_anggota');
        $builder->where('tsr_n_barang_id >', 0);
        $builder->join('barang', 'barang.id_barang = transaksi_sementara_retur.tsr_n_barang_id');
        //$builder->join('barang', 'barang.id_barang = transaksi_sementara_retur.tsr_r_barang_id');
        $builder->where('tsr_user_id', $id);
        $query = $builder->get()->getResultArray();
        return $query;
        
    }

    public function GetRowReturSementara(){
        $id = $this->session->get('id_user');
        $builder = $this->db->table($this->transaksi_sementara_retur);
        $builder->select('tsr_kode_retur, tsr_kembalian_pl, tsr_total_bayar_k, tsr_jumlah_uang_k, tsr_kembalian_k, nama');
        $builder->where('tsr_user_id', $id);
        $builder->join('user', 'user.id_user = transaksi_sementara_retur.tsr_user_id');
        $builder->groupBy('tsr_kode_retur');
        $query = $builder->get()->getRowArray();
        return $query;

    }

    // public function GetAllTransaksiSemantaraForInsertAdmin(){
    //     $id_session = $this->session->get('id_user');
    //     $this->db->transStart();
    //     $builder = $this->db->table($this->transaksi_sementara);
    //     $builder->select('ts_kode_transaksi, ts_user_id, ts_kembalian, ts_jumlah_uang, ts_role_id');
    //     $builder->selectSUM('ts_qty');
    //     $builder->selectSUM('ts_harga');
    //     $builder->where('ts_user_id', $id_session);
    //     $builder->groupBy('ts_kode_transaksi');
    //     $query = $builder->get()->getRowArray();

    //         $data = array(
    //             'tt_kode_transaksi' => $query['ts_kode_transaksi'],
    //             'tt_total_qty' => $query['ts_qty'],
    //             'tt_user_id' => $query['ts_user_id'],
    //             'tt_role_id' => $query['ts_role_id'],
    //             'tt_total_harga' => $query['ts_harga'],
    //             'tt_kembalian' => $query['ts_kembalian'],
    //             'tt_nama_penerima' => htmlspecialchars($this->request->getPost('tt_nama_penerima'), ENT_QUOTES),
    //             'tt_alamat_penerima' =>  htmlspecialchars($this->request->getPost('tt_alamat_penerima'), ENT_QUOTES),
    //             'tt_keterangan' =>  htmlspecialchars($this->request->getPost('tt_keterangan'), ENT_QUOTES),
    //             'tt_jumlah_uang' => $query['ts_jumlah_uang'],
    //             'tt_tanggal_beli' => $this->request->getPost('tt_tanggal_beli'),
    //         );
        
    //     $builder1 = $this->db->table($this->transaksi_total);
    //     $builder1->insert($data);
    //     $lastID = $this->db->insertID();
       

    //     $builder2 = $this->db->table($this->transaksi_sementara);
    //     $builder2->select('ts_barang_id, ts_qty, ts_harga');
    //     $builder2->where('ts_user_id', $id_session);
    //     $query2 = $builder2->get()->getResultArray();

    //     foreach ($query2 as  $qt2):
    //         $data1[] = array(
    //             't_transaksi_total_id' => $lastID,
    //             't_barang_id' => $qt2['ts_barang_id'],
    //             't_qty' => $qt2['ts_qty'],
    //             't_harga' => $qt2['ts_harga']
    //         );
    //     endforeach;
    //     $builder3 = $this->db->table($this->transaksi);
    //     $builder3->insertBatch($data1);
    //     $this->db->transComplete();
    // }

    // public function HapusTransaksiSementaraAdmin(){
    //     $id_session = $this->session->get('id_user');
    //     $builder = $this->db->table($this->transaksi_sementara);
    //     $builder->where('ts_user_id', $id_session);
    //     $builder->delete();

    // }


    public function HapusAllInvoiceRetur(){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $builder1 = $this->db->table($this->transaksi_sementara_retur);
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

        $builder = $this->db->table($this->transaksi_sementara_retur);
        $builder->where('tsr_user_id', $id_user);
        $builder->delete();

        $this->db->transComplete();

        
    }

    

    ////////////////////////////////////MODEL TOKO/////////////////////////////////////////



    public function GetRowToko(){
        $builder = $this->db->table($this->toko);
        $builder->select('id_toko, nama_toko, telepon_toko, email_toko, alamat_toko, deskripsi_toko, logo_toko');
        $builder->where('id_toko', 1);
        $query = $builder->get()->getRowArray();
        return $query;

    }

    public function GetRowTokoForLaporan(){
        $builder = $this->db->table($this->toko);
        $builder->select('nama_toko, telepon_toko, alamat_toko, logo_toko, logo_koperasi_inter');
        $builder->where('id_toko', 1);
        $query = $builder->get()->getRowArray();
        return $query;

    }

    public function EditToko($edit, $id_toko){
        $builder = $this->db->table($this->toko);
        $builder->where('id_toko', $id_toko);
        $builder->update($edit);
    }

    ///////////////////////////////MODEL KERANJANAG ADMIN////////////////////////////////////

    public function GetAllBarangAdminForPembelianKonsumen(){
        $builder = $this->db->table($this->barang);
        $builder->select('nama_barang, id_barang, stok_barang, kode_barang, nama_satuan');
        $builder->select('harga_konsumen as harga');
        $builder->where('id_barang >', 0);
        $builder->where('harga_konsumen >', 0);
        $builder->join('satuan', 'satuan.id_satuan = barang.satuan_id');
        $query= $builder->get()->getResultArray();
        return $query;
    }

    // public function GetAllBarangAdminForReturSupplier(){
    //     $builder = $this->db->table($this->barang);
    //     $builder->select('nama_barang, id_barang, stok_barang, kode_barang, nama_satuan');
    //     $builder->select('harga_pokok as harga');
    //     $builder->where('id_barang >', 0);
    //     $builder->where('harga_konsumen >', 0);
    //     $builder->join('satuan', 'satuan.id_satuan = barang.satuan_id');
    //     $query= $builder->get()->getResultArray();
    //     return $query;
    // }

    public function GetAllBarangAdminForPembelianAnggota(){
        $builder = $this->db->table($this->barang);
        $builder->select('nama_barang, id_barang, stok_barang, kode_barang, nama_satuan');
        $builder->select('harga_anggota as harga');
        $builder->where('id_barang >', 0);
        $builder->where('harga_anggota >', 0);
        $builder->join('satuan', 'satuan.id_satuan = barang.satuan_id');
        $query= $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllRoleForPembelian() {
        $builder = $this->db->table($this->user_role);
        $query= $builder->select('id_role, role')->where('id_role!=', 1)->where('id_role!=', 2)->where('id_role!=', 3)->where('id_role!=', 6)->get()->getResultArray();
        return $query;
    }

    public function GetRowJenisKasir(){
        $id = $this->session->get('id_user');
        $builder = $this->db->table($this->jenis_kasir);
        $builder->select('id_jenis_kasir, role_id, role');
        $builder->where('user_id', $id);
        $builder->join('user_role', 'user_role.id_role = jenis_kasir.role_id');
        $query = $builder->get()->getRowArray();
        return $query;
    }

    public function EditJenisKasir($data, $id_sess){
        $builder = $this->db->table($this->jenis_kasir);
        $builder->where('user_id', $id_sess);
        $builder->update($data);
    }


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
        $builder = $this->db->table($this->keranjang);
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
        $builder1 = $this->db->table($this->keranjang);
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

        $builder = $this->db->table($this->keranjang);
        $builder->where('k_kode_keranjang', $kode);
        $builder->delete();

        $this->db->transComplete();
    }

    public function TambahTransaksiSementara($data){
        $builder = $this->db->table($this->transaksi_sementara);
        $builder->insertBatch($data);
    }


    public function HapusAllKeranjangAdmin(){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $builder1 = $this->db->table($this->keranjang);
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

        $builder = $this->db->table($this->keranjang);
        $builder->where('k_user_id', $id_user);
        $builder->delete();

        $this->db->transComplete();

        
    }


    ////////////////////////////////////////////MODEL SATUAN/////////////////////

    public function GetAllSatuan(){
        $builder = $this->db->table($this->satuan);
        $builder->select('id_satuan, nama_satuan');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function TambahSatuan($data){
        $builder = $this->db->table($this->satuan);
        $builder->insert($data);
       // return $this->db->insertID();
    }

    public function TambahSatuan1($sap){
        $builder = $this->db->table($this->satuan);
        $builder->set('nama_satuan', $sap);
        $builder->insert();
        $query = $this->db->insertID();
        return $query;

    }

    

    public function EditSatuan($data, $id){
        $builder = $this->db->table($this->satuan);
        $builder->where('id_satuan', $id);
        $builder->update($data);
    }

    public function HapusSatuan($id_satuan){
        $builder = $this->db->table($this->satuan);
        $builder->where('id_satuan', $id_satuan);
        $builder->delete();
    }

    ////////////////////////////////////////////MODEL KATEGORI/////////////////////

    public function GetAllKategori(){
        $builder = $this->db->table($this->kategori);
        $builder->select('id_kategori, nama_kategori, kode_kategori');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function TambahKategori($data){
        $builder = $this->db->table($this->kategori);
        $builder->insert($data);
    }

    public function TambahKategori1($kat){
        $builder = $this->db->table($this->kategori);
        $builder->set('nama_kategori', $kat);
        $builder->insert();
        $query = $this->db->insertID();
        return $query;
    }

    public function EditKategori($data, $id){
        $builder = $this->db->table($this->kategori);
        $builder->where('id_kategori', $id);
        $builder->update($data);
    }

    public function HapusKategori($id_kategori){
        $builder = $this->db->table($this->kategori);
        $builder->where('id_kategori', $id_kategori);
        $builder->delete();
    }

    /////////////////////////////////////////////MODEL SUPPLIER///////////////////

    public function GetAllSupplier(){
        $builder = $this->db->table($this->pengirim_barang);
        $builder->select('id_pengirim_barang, nama_pengirim_barang');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function TambahSupplier($data){
        $builder = $this->db->table($this->pengirim_barang);
        $builder->insert($data);
    }


    public function TambahSupplier1($sop){
        $builder = $this->db->table($this->pengirim_barang);
        $builder->set('nama_pengirim_barang', $sop);
        $builder->insert();
        $query = $this->db->insertID();
        return $query;
    }

    public function EditSupplier($data, $id){
        $builder = $this->db->table($this->pengirim_barang);
        $builder->where('id_pengirim_barang', $id);
        $builder->update($data);
    }

    public function HapusSupplier($id_supplier){
        $builder = $this->db->table($this->pengirim_barang);
        $builder->where('id_pengirim_barang', $id_supplier);
        $builder->delete();
    }

    ////////////////////////////////////////////MODEL MEREK/////////////////////

    public function GetAllMerek(){
        $builder = $this->db->table($this->merek);
        $builder->select('id_merek, nama_merek');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function TambahMerek($data){
        $builder = $this->db->table($this->merek);
        $builder->insert($data);
    }

    public function TambahMerek1($mer){
        $builder = $this->db->table($this->merek);
        $builder->set('nama_merek', $mer);
        $builder->insert();
        $query = $this->db->insertID();
        return $query;
    }

    public function EditMerek($data, $id){
        $builder = $this->db->table($this->merek);
        $builder->where('id_merek', $id);
        $builder->update($data);
    }

    public function HapusMerek($id_merek){
        $builder = $this->db->table($this->merek);
        $builder->where('id_merek', $id_merek);
        $builder->delete();
    }


    public function GetAllBarangMasukHariCari($tanggal = null) {

        date_default_timezone_set("Asia/Jakarta");
        
        if(!$tanggal){
        $tanggal= date('Y-m-d');
        }
        $builder = $this->db->table($this->barang_masuk);
        $builder->select('jumlah_barang_masuk,nama_barang, total_harga_pokok ,harga_pokok_pb, nama_pengirim_barang, tanggal_masuk, tanggal_masuk as jam');
        //$builder->selectSum('total_harga_pokok')->where('pengirim_barang_id', 'pengirim_barang_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang_masuk.pengirim_barang_id');
        $builder->join('barang', 'barang.id_barang = barang_masuk.barang_id');
        $builder->where('DATE(tanggal_masuk)', $tanggal);
        $builder->orderBy('tanggal_masuk', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    public function GetAllBarangMasukMingguCari($awal_minggu, $akhir_minggu) {

        $builder = $this->db->table($this->barang_masuk);
        $builder->select('jumlah_barang_masuk,nama_barang, total_harga_pokok ,harga_pokok_pb, nama_pengirim_barang, tanggal_masuk, tanggal_masuk as jam');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang_masuk.pengirim_barang_id');
        $builder->join('barang', 'barang.id_barang = barang_masuk.barang_id');
        $builder->where('DATE(tanggal_masuk)>=', $awal_minggu);
        $builder->where('DATE(tanggal_masuk)<=', $akhir_minggu);
        $query = $builder->get()->getResultArray();
        return $query;
    }



    public function GetAllBarangMasukBulanCari($bulan = null, $tahun = null) {

        date_default_timezone_set("Asia/Jakarta");
        
        if(!$bulan && !$tahun){
        $bulan= date('m');
        $tahun= date('Y');
        }

        $builder = $this->db->table($this->barang_masuk);
        $builder->select('jumlah_barang_masuk, total_harga_pokok, nama_barang, harga_pokok_pb, nama_pengirim_barang, tanggal_masuk as bulan');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang_masuk.pengirim_barang_id');
        $builder->join('barang', 'barang.id_barang = barang_masuk.barang_id');
        //$builder->where('DAY(tanggal_masuk)', $day);
        $builder->where('MONTH(tanggal_masuk)', $bulan);
        $builder->where('YEAR(tanggal_masuk)', $tahun);
        $builder->orderBy('tanggal_masuk', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllBarangMasukTahunCari($cari_tahun = null) {

        date_default_timezone_set("Asia/Jakarta");
        if(!$cari_tahun){
            $cari_tahun = date('Y');
        }

        $builder = $this->db->table($this->barang_masuk);
        $builder->select('jumlah_barang_masuk, total_harga_pokok, nama_barang, harga_pokok_pb, nama_pengirim_barang, tanggal_masuk');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang_masuk.pengirim_barang_id');
        $builder->join('barang', 'barang.id_barang = barang_masuk.barang_id');
        //$builder->where('DAY(tanggal_masuk)', $day);
        // $builder->where('MONTH(tanggal_masuk)', $month);
        $builder->where('YEAR(tanggal_masuk)', $cari_tahun);
        $builder->orderBy('tanggal_masuk', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    ////////////////////////////MODEL BARANG KELUAR /////////////////////////////

    public function GetAllBarangKeluarHariCari($tanggal = null) {

        date_default_timezone_set("Asia/Jakarta");
    
        if(!$tanggal){
            $tanggal = date('Y-m-d');
        }
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('tt_tanggal_beli as jam, tt_role_id, stok_barang ,nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('DATE(tt_tanggal_beli)', $tanggal);
        //$builder->groupBy('tt_kode_transaksi');
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    public function GetAllBarangKeluarHariCariTambah($tanggal = null) {

        date_default_timezone_set("Asia/Jakarta");
    
        if(!$tanggal){
            $tanggal = date('Y-m-d');
        }
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('tt_tanggal_beli as jam, tt_role_id, stok_barang, nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->selectSUM('t_qty');
        $builder->selectSUM('t_harga');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('DATE(tt_tanggal_beli)', $tanggal);
        $builder->groupBy('id_barang');
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }

   

    public function GetAllBarangKeluarMingguCari($awal_minggu, $akhir_minggu) {

        date_default_timezone_set("Asia/Jakarta");
        // $day= date('d');
        // $month= date('m');
        // $years= date('Y');
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('tt_tanggal_beli as tanggal, tt_role_id, nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('DATE(tt_tanggal_beli)>=', $awal_minggu);
        $builder->where('DATE(tt_tanggal_beli)<=', $akhir_minggu);
        $builder->orderBy('tt_kode_transaksi', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllBarangKeluarMingguCariTambah($awal_minggu, $akhir_minggu) {

        date_default_timezone_set("Asia/Jakarta");
        // $day= date('d');
        // $month= date('m');
        // $years= date('Y');
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('tt_tanggal_beli as tanggal, tt_role_id, stok_barang,nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima,  nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->selectSUM('t_qty');
        $builder->selectSUM('t_harga');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('DATE(tt_tanggal_beli)>=', $awal_minggu);
        $builder->where('DATE(tt_tanggal_beli)<=', $akhir_minggu);
        $builder->orderBy('tt_kode_transaksi', 'ASC');
        $builder->groupBy('id_barang');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    public function GetAllBarangKeluarBulanCari($month = null, $year = null) {


        date_default_timezone_set("Asia/Jakarta");
        if(!$month && !$year){
            $month= date('m');
            $year= date('Y');
        }
       
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('tt_tanggal_beli as tanggal, nama_pengirim_barang,tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('MONTH(tt_tanggal_beli)', $month);
        $builder->where('YEAR(tt_tanggal_beli)', $year);
        //$builder->like('YEAR(tt_tanggal_beli)', $year);
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }



    public function GetAllBarangKeluarBulanCariTambah($month = null, $year = null) {


        date_default_timezone_set("Asia/Jakarta");
        if(!$month && !$year){
            $month= date('m');
            $year= date('Y');
        }
       
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('tt_tanggal_beli as tanggal, stok_barang,nama_pengirim_barang,tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->selectSUM('t_qty');
        $builder->selectSUM('t_harga');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('MONTH(tt_tanggal_beli)', $month);
        $builder->where('YEAR(tt_tanggal_beli)', $year);
        $builder->groupBy('id_barang');
        //$builder->like('YEAR(tt_tanggal_beli)', $year);
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    public function GetAllBarangKeluarTahunCari($cari_tahun = null) {

        date_default_timezone_set("Asia/Jakarta");
        if(!$cari_tahun){
            $cari_tahun = date('Y');
        }
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('tt_tanggal_beli as tanggal,nama_pengirim_barang, tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('YEAR(tt_tanggal_beli)', $cari_tahun);
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    public function GetAllBarangKeluarTahunCariTambah($cari_tahun = null) {

        date_default_timezone_set("Asia/Jakarta");
        if(!$cari_tahun){
            $cari_tahun = date('Y');
        }
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('tt_tanggal_beli as tanggal,nama_pengirim_barang, stok_barang, tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->selectSUM('t_qty');
        $builder->selectSUM('t_harga');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('YEAR(tt_tanggal_beli)', $cari_tahun);
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $builder->groupBy('id_barang');
        $query = $builder->get()->getResultArray();
        return $query;
    }


   



   
    ///////////////////////////////////MODEL PENGIRIM//////////////////////////////

    public function TambahPengirim($data){
        $builder = $this->db->table($this->pengirim_barang);
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function GetIdPengirim($id){
        
        $builder = $this->db->table($this->pengirim_barang);
		return $query = $builder->select('id_pengirim_barang, nama_pengirim_barang')->where(['id_pengirim_barang' => $id])->get()->getRowArray();
    }
    
    public function TambahBarangForMasuk($data){
        $builder = $this->db->table($this->barang);
        $builder->insert($data);
        
    }


    //////////////////////////////////MODEL BARANG MASUK ADMIN//////////////////////

    public function GetAllBarangMasuk(){
        $builder = $this->db->table($this->barang_masuk);
        $builder->select('nama_barang, tanggal_masuk');
        $builder->join('barang', 'barang.id_barang = barang_masuk.barang_id');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllPengirimBarang(){
        $builder = $this->db->table($this->pengirim_barang);
        $builder->select('id_pengirim_barang, nama_pengirim_barang');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllBarangForLaporanMasuk(){
        $builder = $this->db->table($this->barang);
        $builder->select('id_barang, nama_barang');
        $builder->where('id_barang>', 0);
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function TambahBarangMasuk($data, $data2){
        $this->db->transStart();
        $builder = $this->db->table($this->barang_masuk);
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
            $this->db->table($this->barang)->set('harga_pokok', $hpesc)
            ->set('harga_konsumen', $hkesc)->set('harga_anggota', $haesc)
            ->set('pengirim_barang_id', $pbiesc)
            ->where('id_barang', $idbesc)->update();
        endforeach;

        $this->db->transComplete();

    }

    public function GetHargaPokokForBarangMasuk($id_barang){
        $builder = $this->db->table($this->barang);
        $builder->select('harga_pokok, harga_anggota, harga_konsumen');
        $builder->where('id_barang', $id_barang);
        $query = $builder->get()->getResultArray();
        return $query;
        
    }


    //////////////////////////////////////FORM RETUR/////////////////////////

    public function GetAllTransaksiForRetur($kode_cari){
        $builder = $this->db->table($this->transaksi);
        $builder->select('id_transaksi_total,t_harga, nama_barang, t_barang_id, t_qty, tt_total_harga, tt_total_qty, tt_role_id, harga_konsumen, harga_anggota');
        $builder->where('tt_kode_transaksi', $kode_cari);
        $builder->join('transaksi_total', 'transaksi_total.id_transaksi_total = transaksi.t_transaksi_total_id');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $query = $builder->get()->getResultArray();
        return $query;
        
    }

    public function GetRowRoleIdTransaksiForRetur($kode_cari){
        $id_user = $this->session->get('id_user');
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('tt_role_id, role');
        $builder->where('tt_kode_transaksi', $kode_cari);
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $query = $builder->get()->getRowArray();
        return $query;
        
    }

    


    public function GetAllKeranjangRetur(){
        $id_user = $this->session->get('id_user');
        $builder = $this->db->table($this->keranjang_retur);
        $builder->select('id_keranjang_retur, kr_qty, kr_kode_keranjang,nama_barang, kr_barang_id, COUNT(kr_qty) as to_qty');
        $builder->select('kr_harga as harga');
        $builder->selectSUM('kr_qty', 'tt_qty');
        $builder->where('kr_user_id', $id_user);
        $builder->join('barang', 'barang.id_barang = keranjang_retur.kr_barang_id');
        $builder->groupBy('kr_barang_id');
        $query = $builder->get();
        return $query->getResultArray();
      // $this->db->transComplete();
    }

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
        $builder = $this->db->table($this->keranjang_retur);
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
        $builder1 = $this->db->table($this->keranjang_retur);
        $builder1->select('kr_barang_id, kr_qty');
        //$builder1->selectSUM('k_qty');
        $builder1->where('kr_kode_keranjang', $kode);
        $builder1->join('barang', 'barang.id_barang = keranjang_retur.kr_barang_id');
        $builder1->groupBy('kr_kode_keranjang');
        $query = $builder1->get()->getRowArray();
        $qty = $query['kr_qty'];
        $idb = $query['kr_barang_id'];
        $qtyesc = $this->db->escapeString($qty);
        $idbesc = $this->db->escapeString($idb);

        $stok = $this->db->query("update barang set stok_barang=stok_barang+'$qty' where id_barang='$idb'");

        $builder = $this->db->table($this->keranjang_retur);
        $builder->where('kr_kode_keranjang', $kode);
        $builder->delete();

        $this->db->transComplete();
    }

    public function HapusAllKeranjangRetur(){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $builder1 = $this->db->table($this->keranjang_retur);
        $builder1->select('kr_barang_id, kr_qty');
        $builder1->where('kr_user_id', $id_user);
        $builder1->join('barang', 'barang.id_barang = keranjang_retur.kr_barang_id');
        //$builder1->groupBy('k_kode_keranjang');
        $query = $builder1->get()->getResultArray();
        //dd($query);
        
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

        $builder = $this->db->table($this->keranjang_retur);
        $builder->where('kr_user_id', $id_user);
        $builder->delete();

        $this->db->transComplete();

        
    }

    public function TambahTransaksiSementararRetur($data, $data1){
        //$this->db->transStart();
        $builder = $this->db->table($this->transaksi_sementara_retur);
        $builder->insertBatch($data);
        //$builder1 = $this->db->table($this->transaksi_sementara_retur);
        $builder->insertBatch($data1);
        //$this->db->transComplete();
    }

    public function HapusKeranjangReturSemua(){
        $id_session = $this->session->get('id_user');
        $builder = $this->db->table($this->keranjang_retur);
        $builder->where('kr_user_id', $id_session);
        $builder->delete();

    }


    public function GetAllTransaksiSemantaraReturForInsertRetur(){
        $id_session = $this->session->get('id_user');
        $this->db->transStart();

        $builderrm = $this->db->table($this->transaksi_sementara_retur);
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


        


        $builder = $this->db->table($this->transaksi_sementara_retur);
        $builder->selectSUM('tsr_r_qty');
        $builder->selectSUM('tsr_r_subtotal');
        $builder->where('tsr_user_id', $id_session);
        $builder->groupBy('tsr_kode_retur');
        $query = $builder->get()->getRowArray();

        $buildern = $this->db->table($this->transaksi_sementara_retur);
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
        $builder1 = $this->db->table($this->transaksi_retur_total);
        $builder1->insert($data);
        $lastID = $this->db->insertID();
       

        $builder2 = $this->db->table($this->transaksi_sementara_retur);
        $builder2->select('tsr_r_barang_id, tsr_r_qty, tsr_r_subtotal');
        $builder2->where('tsr_r_barang_id>', 0);
        $builder2->where('tsr_user_id', $id_session);
        $query2 = $builder2->get()->getResultArray();


        $builder2n = $this->db->table($this->transaksi_sementara_retur);
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


        $builder3 = $this->db->table($this->transaksi_retur);
        $builder3->insertBatch($data1);
        $builder3->insertBatch($data2);
        $this->db->transComplete();
    }

    public function HapusTransaksiSementaraRetur(){
        $id_session = $this->session->get('id_user');
        $builder = $this->db->table($this->transaksi_sementara_retur);
        $builder->where('tsr_user_id', $id_session);
        $builder->delete();

    }

    /////////////////////////////////////////////LAPORAN RETUR//////////////////////////////////

    public function Trop(){
        $builder = $this->db->table($this->transaksi_retur);
        $builder->select('barang_r.nama_barang as r_nama, barang_n.nama_barang as n_nama, r_qty, r_subtotal, n_qty, n_subtotal');
        $builder->join('barang as barang_r', 'barang_r.id_barang = transaksi_retur.r_barang_id');
        $builder->join('barang as barang_n', 'barang_n.id_barang = transaksi_retur.n_barang_id');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllReturCari($awal, $akhir) {

        date_default_timezone_set("Asia/Jakarta");
        
        $builder = $this->db->table($this->transaksi_retur);
        $builder->select('barang_r.nama_barang as r_nama, barang_n.nama_barang as n_nama, r_qty, 
        r_subtotal, n_qty, n_subtotal, trt_kode_retur, role, nama, trt_r_total_harga, trt_n_qty,
        trt_n_total_harga, trt_role_id,trt_r_qty, trt_hp_kembalian, trt_hk_kembalian, trt_hk_total_bayar, 
        trt_hk_jumlah_uang, trt_tanggal, ,tt_kode_transaksi, tt_nama_penerima, barang_r.harga_konsumen as r_harga_konsumen, barang_r.harga_anggota as r_harga_anggota, barang_n.harga_konsumen as n_harga_konsumen, barang_n.harga_anggota as n_harga_anggota');
        $builder->join('transaksi_retur_total', 'transaksi_retur_total.id_transaksi_retur_total = transaksi_retur.transaksi_total_retur_id');
        $builder->join('transaksi_total', 'transaksi_total.id_transaksi_total = transaksi_retur_total.trt_transaksi_total_id');
        $builder->join('barang as barang_r', 'barang_r.id_barang = transaksi_retur.r_barang_id');
        $builder->join('barang as barang_n', 'barang_n.id_barang = transaksi_retur.n_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_retur_total.trt_role_id');
        $builder->join('user', 'user.id_user = transaksi_retur_total.trt_user_id');
        // $builder->where('barang_r.id_barang!=', 0);
        //$builder->where('barang_n.id_barang>', 0);
        $builder->where('DATE(trt_tanggal)>=', $awal);
        $builder->where('DATE(trt_tanggal)<=', $akhir);
        //$builder->orderBy('n_nama', 'DESC');
        $query = $builder->get()->getResultArray();
        return $query;
    }
    ////////////////////////////////////////////////////MODEL SUMMARY////////////////////////
    
    // public function GetAllSummaryTanggal($awal, $akhir){
    //     $builder = $this->db->table($this->transaksi_total);
    //     $builder->select('DATE(tt_tanggal_beli) as nama_tanggal, DATE(tanggal_masuk) as nama_tanggal2');
    //     $builder->selectSUM('tt_total_harga', 'hargasum');
    //     $builder->selectSUM('total_harga_pokok', 'hargasum2');
    //     $builder->join('barang_masuk', 'DATE(barang_masuk.tanggal_masuk) = DATE(transaksi_total.tt_tanggal_beli)', 'left');
    //     $builder->where('DATE(tt_tanggal_beli)>=', $awal);
    //     $builder->where('DATE(tt_tanggal_beli)<=', $akhir);
    //     $builder->groupBy('DATE(tt_tanggal_beli)');
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }



    public function GetAllSummaryTanggalKeluar($bulan = null, $tahun = null){

        date_default_timezone_set("Asia/Jakarta");
        if(!$bulan && !$tahun){
            $bulan= date('m');
            $tahun= date('Y');
        }
        
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('DATE(tt_tanggal_beli) as nama_tanggal');
        $builder->selectSUM('tt_total_harga', 'hargasum');
        $builder->where('tt_total_harga>', 0);
        $builder->where('MONTH(tt_tanggal_beli)', $bulan);
        $builder->where('YEAR(tt_tanggal_beli)', $tahun);
        $builder->groupBy('DATE(tt_tanggal_beli)');
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }
    
    public function GetAllSummaryTanggalMasuk($bulan = null, $tahun = null){

        date_default_timezone_set("Asia/Jakarta");
        if(!$bulan && !$tahun){
            $bulan= date('m');
            $tahun= date('Y');
        }
        
        $builder = $this->db->table($this->barang_masuk);
        $builder->select('DATE(tanggal_masuk) as nama_tanggal');
        $builder->selectSUM('total_harga_pokok', 'hargasum');
        $builder->where('MONTH(tanggal_masuk)', $bulan);
        $builder->where('YEAR(tanggal_masuk)', $tahun);
        $builder->groupBy('DATE(tanggal_masuk)');
        $builder->orderBy('tanggal_masuk', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    public function GetAllSummaryBulanKeluar($tahun = null){

        date_default_timezone_set("Asia/Jakarta");
        if(!$tahun){
            $tahun= date('Y');
        }
        
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('MONTHNAME(tt_tanggal_beli) as nama_bulan');
        $builder->selectSUM('tt_total_harga', 'hargasum');
        $builder->where('tt_total_harga>', 0);
        $builder->where('YEAR(tt_tanggal_beli)', $tahun);
        $builder->groupBy('MONTH(tt_tanggal_beli)');
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }
    
    public function GetAllSummaryBulanMasuk($tahun = null){

        date_default_timezone_set("Asia/Jakarta");
        if(!$tahun){
            $tahun= date('Y');
        }
        
        $builder = $this->db->table($this->barang_masuk);
        $builder->select('MONTHNAME(tanggal_masuk) as nama_bulan');
        $builder->selectSUM('total_harga_pokok', 'hargasum');
        $builder->where('YEAR(tanggal_masuk)', $tahun);
        $builder->groupBy('MONTH(tanggal_masuk)');
        $builder->orderBy('tanggal_masuk', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }



    // public function Man(){
    //     $builder = $this->db->table($this->transaksi_total);
    //     $builder->select('MONTHNAME(tt_tanggal_beli) as nama_bulan, MONTHNAME(tanggal_masuk) as nama_bulan2');
    //     $builder->selectSUM('tt_total_harga', 'hargasum');
    //     $builder->selectSUM('total_harga_pokok', 'hargasum2');
    //     $builder->join('barang_masuk', 'MONTH(barang_masuk.tanggal_masuk) = MONTH(transaksi_total.tt_tanggal_beli)', 'left');
    //     $builder->where('YEAR(tt_tanggal_beli)', 2020);
    //     $builder->groupBy('MONTH(tt_tanggal_beli)');
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }


    public function GetAllSummaryTahunKeluar($awal, $akhir){
        
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('YEAR(tt_tanggal_beli) as nama_tahun');
        $builder->selectSUM('tt_total_harga', 'hargasum');
        $builder->where('tt_total_harga>', 0);
        $builder->where('YEAR(tt_tanggal_beli)>=', $awal);
        $builder->where('YEAR(tt_tanggal_beli)<=', $akhir);
        $builder->groupBy('YEAR(tt_tanggal_beli)');
        $builder->orderBy('YEAR(tt_tanggal_beli)', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }
    
    public function GetAllSummaryTahunMasuk($awal, $akhir){

        $builder = $this->db->table($this->barang_masuk);
        $builder->select('YEAR(tanggal_masuk) as nama_tahun');
        $builder->selectSUM('total_harga_pokok', 'hargasum');
        $builder->where('YEAR(tanggal_masuk)>=', $awal);
        $builder->where('YEAR(tanggal_masuk)<=', $akhir);
        $builder->groupBy('YEAR(tanggal_masuk)');
        $builder->orderBy('YEAR(tanggal_masuk)', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    ///////////////////////////////////MODEL DASHBOARD/////////////////////////////////////////

    public function GetRowBarangMasukHari() {

        date_default_timezone_set("Asia/Jakarta");
        $day= date('d');
        $month= date('m');
        $years= date('Y');
        $builder = $this->db->table($this->barang_masuk);
        $builder->selectSUM('total_harga_pokok', 'total_bmh');
        $builder->selectSUM('jumlah_barang_masuk', 'total_jbm');
        $builder->groupBy('DAY(tanggal_masuk)');
        $builder->where('DAY(tanggal_masuk)', $day);
        $builder->where('MONTH(tanggal_masuk)', $month);
        $builder->where('YEAR(tanggal_masuk)', $years);
        $query = $builder->get()->getRowArray();
        return $query;
    
    }

    public function GetRowBarangMasukBulan() {

        date_default_timezone_set("Asia/Jakarta");
        $month= date('m');
        $years= date('Y');
        $builder = $this->db->table($this->barang_masuk);
        $builder->selectSUM('total_harga_pokok', 'total_bmb');
        $builder->selectSUM('jumlah_barang_masuk', 'total_jbm');
        $builder->groupBy('MONTH(tanggal_masuk)');
        $builder->where('MONTH(tanggal_masuk)', $month);
        $builder->where('YEAR(tanggal_masuk)', $years);
        $query = $builder->get()->getRowArray();
        return $query;
    
    }

    public function GetRowBarangMasukTahun() {

        date_default_timezone_set("Asia/Jakarta");
        $years= date('Y');
        $builder = $this->db->table($this->barang_masuk);
        $builder->selectSUM('total_harga_pokok', 'total_bmt');
        $builder->selectSUM('jumlah_barang_masuk', 'total_jbm');
        $builder->groupBy('YEAR(tanggal_masuk)');
        $builder->where('YEAR(tanggal_masuk)', $years);
        $query = $builder->get()->getRowArray();
        return $query;
    
    }


    public function GetRowBarangKeluarHari() {

        date_default_timezone_set("Asia/Jakarta");
        $day= date('d');
        $month= date('m');
        $years= date('Y');
        $builder = $this->db->table($this->transaksi_total);
        $builder->selectSUM('tt_total_harga', 'total_bkh');
        $builder->selectSUM('tt_total_qty', 'total_ttq');
        $builder->groupBy('DAY(tt_tanggal_beli)');
        //$builder->where('id_transaksi_total>', 0);
        $builder->where('id_transaksi_total>', 1);
        $builder->where('DAY(tt_tanggal_beli)', $day);
        $builder->where('MONTH(tt_tanggal_beli)', $month);
        $builder->where('YEAR(tt_tanggal_beli)', $years);
        $query = $builder->get()->getRowArray();
        return $query;
    
    }

    public function GetRowBarangKeluarBulan() {

        date_default_timezone_set("Asia/Jakarta");
        $month= date('m');
        $years= date('Y');
        $builder = $this->db->table($this->transaksi_total);
        $builder->selectSUM('tt_total_harga', 'total_bkb');
        $builder->selectSUM('tt_total_qty', 'total_ttq');
        $builder->groupBy('MONTH(tt_tanggal_beli)');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('MONTH(tt_tanggal_beli)', $month);
        $builder->where('YEAR(tt_tanggal_beli)', $years);
        $query = $builder->get()->getRowArray();
        return $query;
    
    }

    public function GetRowBarangKeluarTahun() {

        date_default_timezone_set("Asia/Jakarta");
        $years= date('Y');
        $builder = $this->db->table($this->transaksi_total);
        $builder->selectSUM('tt_total_harga', 'total_bkt');
        $builder->selectSUM('tt_total_qty', 'total_ttq');
        $builder->groupBy('YEAR(tt_tanggal_beli)');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('YEAR(tt_tanggal_beli)', $years);
        $query = $builder->get()->getRowArray();
        return $query;
    
    }


    public function GetChartMasukTanggal() {
        date_default_timezone_set("Asia/Jakarta");
        $day= date('d');
        $month= date('m');
        $years= date('Y');
        $builder = $this->db->table($this->barang_masuk);
        $builder->select('DATE(tanggal_masuk) AS tanggal');
        $builder->selectSUM('total_harga_pokok', 'thp');
        $builder->where('MONTH(tanggal_masuk)', $month);
        $builder->where('YEAR(tanggal_masuk)', $years);
        $builder->groupBy('DATE(tanggal_masuk)');
        $builder->orderBy('tanggal', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
  
    }

    public function GetChartMasukBulan() {
        date_default_timezone_set("Asia/Jakarta");
        $years= date('Y');
        $builder = $this->db->table($this->barang_masuk);
        $builder->select('MONTHNAME(tanggal_masuk) AS bulan');
        $builder->selectSUM('total_harga_pokok', 'tmb');
        $builder->where('YEAR(tanggal_masuk)', $years);
        $builder->groupBy('MONTH(tanggal_masuk)');
        $builder->orderBy('MONTH(tanggal_masuk)', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
  
    }

    public function GetChartMasukTahun() {
        date_default_timezone_set("Asia/Jakarta");
        $years= date('Y');
        $builder = $this->db->table($this->barang_masuk);
        $builder->select('YEAR(tanggal_masuk) AS tahun');
        $builder->selectSUM('total_harga_pokok', 'thm');
        $builder->groupBy('YEAR(tanggal_masuk)');
        $builder->orderBy('YEAR(tanggal_masuk)', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
  
    }


    public function GetChartKeluarTanggal() {
        date_default_timezone_set("Asia/Jakarta");
        $day= date('d');
        $month= date('m');
        $years= date('Y');
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('DATE(tt_tanggal_beli) AS tanggal');
        $builder->selectSUM('tt_total_harga', 'tck');
        $builder->where('id_transaksi_total>', 0);
        $builder->where('MONTH(tt_tanggal_beli)', $month);
        $builder->where('YEAR(tt_tanggal_beli)', $years);
        $builder->groupBy('DATE(tt_tanggal_beli)');
        $builder->orderBy('tanggal', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
  
    }

    public function GetChartKeluarBulan() {
        date_default_timezone_set("Asia/Jakarta");
        $years= date('Y');
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('MONTHNAME(tt_tanggal_beli) AS bulan');
        $builder->selectSUM('tt_total_harga', 'tkb');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('YEAR(tt_tanggal_beli)', $years);
        $builder->groupBy('MONTH(tt_tanggal_beli)');
        $builder->orderBy('MONTH(tt_tanggal_beli)', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
  
    }

    public function GetChartKeluarTahun() {
        date_default_timezone_set("Asia/Jakarta");
        $years= date('Y');
        $builder = $this->db->table($this->transaksi_total);
        $builder->select('YEAR(tt_tanggal_beli) AS tahun');
        $builder->selectSUM('tt_total_harga', 'tkt');
        $builder->where('id_transaksi_total>', 1);
        $builder->groupBy('YEAR(tt_tanggal_beli)');
        $builder->orderBy('YEAR(tt_tanggal_beli)', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
  
    }

    //////////////////////////////////////DAFTAR UTANG///////////////////////////////////////////

    public function GetAllUtang(){
        $builder = $this->db->table($this->transaksi_sementara);
        $builder->select('ts_kode_transaksi, DATEDIFF(CURDATE(), ts_tanggal_sementara)  as waktu,ts_uri ,ts_nama_pengutang, ts_nomor_pengutang, ts_tanggal_sementara');
        $builder->where('ts_status_transaksi', 2);
        $builder->groupBy('ts_kode_transaksi');
        $builder->orderBy('ts_tanggal_sementara');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    public function GetRowDetailUtangSementara($kod){
        $builder = $this->db->table($this->transaksi_sementara);
        $builder->select('ts_kode_transaksi, ts_uri, telepon, nama, alamat, ts_jumlah_uang, ts_kembalian, ts_nama_pengutang, ts_nomor_pengutang, ts_tanggal_sementara');
        $builder->where('ts_kode_transaksi', $kod);
        $builder->where('ts_status_transaksi', 2);
        $builder->join('user', 'user.id_user = transaksi_sementara.ts_user_id');
        $builder->groupBy('ts_kode_transaksi');
        $query = $builder->get()->getRowArray();
        return $query;

    }

    public function GetAllDetailUtangSementara($kod){
        $builder = $this->db->table($this->transaksi_sementara);
        $builder->select('nama_barang, ts_kode_transaksi, harga_konsumen, harga_anggota, ts_qty, ts_harga, ts_role_id');
        $builder->where('ts_kode_transaksi', $kod);
        $builder->where('ts_status_transaksi', 2);
        $builder->join('barang', 'barang.id_barang = transaksi_sementara.ts_barang_id');
        $query = $builder->get()->getResultArray();
        return $query;

    }


    public function HapusAllInvoiceUtang($kod, $uri){
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $builder1 = $this->db->table($this->transaksi_sementara);
        $builder1->select('ts_barang_id, ts_qty');
        $builder1->where('ts_status_transaksi', 2);
        $builder1->where('ts_kode_transaksi', $kod);
        $builder1->join('barang', 'barang.id_barang = transaksi_sementara.ts_barang_id');
        //$builder1->groupBy('k_kode_keranjang');
        $query = $builder1->get()->getResultArray();
        //dd($query);
        
        foreach ($query as  $qt2):
            $data[] = array(
                'qty' =>  $qt2['ts_qty'],
                'bi' => $qt2['ts_barang_id']
            );
            $qty = $qt2['ts_qty'];
            $idb = $qt2['ts_barang_id'];
            $qtyesc = $this->db->escapeString($qty);
            $idbesc = $this->db->escapeString($idb);
            $stok = $this->db->query("update barang set stok_barang=stok_barang+'$qtyesc' where id_barang='$idbesc'");
        endforeach;

        $builder = $this->db->table($this->transaksi_sementara);
        //$builder->where('ts_status_transaksi', 2);
        $builder->where('ts_uri', $uri);
        $builder->delete();

        $this->db->transComplete();

        
    }

    public function GetAllTransaksiSemantaraForInsertUtang($kod){
        $id_session = $this->session->get('id_user');
        $this->db->transStart();
        $builder = $this->db->table($this->transaksi_sementara);
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
        
        $builder1 = $this->db->table($this->transaksi_total);
        $builder1->insert($data);
        $lastID = $this->db->insertID();

        $builder2 = $this->db->table($this->transaksi_sementara);
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
        $builder3 = $this->db->table($this->transaksi);
        $builder3->insertBatch($data1);
        $this->db->transComplete();
    }

    public function HapusTransaksiSementaraUtang($uri){
        $id_session = $this->session->get('id_user');
        $builder = $this->db->table($this->transaksi_sementara);
        $builder->where('ts_uri', $uri);
        $builder->delete();

    }








}

?>

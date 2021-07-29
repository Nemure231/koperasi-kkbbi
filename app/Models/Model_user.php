<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_user extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
    }


    protected $table = 'user';
    protected $allowedFields = ['nama', 'surel', 'sandi', 'telepon', 'alamat', 'role_id', 'status', 'tanggal'];
    
    public function TambahKaryawan($tambah){
        $this->db->transStart();
        $builder = $this->db->table('user');
        $builder->insert($tambah);
        $id = $this->db->insertID();

        $data = [
            'user_id' => $id,
            'role_id' => 4
        ];

        $builder1 = $this->db->table('jenis_kasir');
        $builder1->insert($data);
        $this->db->transComplete();

    }

    public function HapusKaryawan($id_user){
        $this->db->transStart();
        $user_id = $this->request->getPost('user_id');
        $builder = $this->db->table('user');
        $builder->where('id_user', $id_user)->delete();

        $builder1 = $this->db->table('jenis_kasir');
        $builder1->where('user_id', $id_user);
        $builder1->delete();
        $this->db->transComplete();

    }
}

?>
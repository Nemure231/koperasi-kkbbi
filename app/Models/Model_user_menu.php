<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_user_menu extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
     }

    protected $table = 'user_menu';
    protected $primaryKey = 'id_menu';
    protected $allowedFields = ['menu'];


    public function Tendang(){

        $role_id = $this->session->get('role_id');        
        $uri = $this->request->uri;
        $menu = $uri->getSegment(1);
        $builder = $this->db->table('user_menu');
        $builder1 = $this->db->table('user_access_menu');
        $this->db->transStart();
        $queryMenu = $builder->select('id_menu')->where(['menu' => $menu])->get()->getRowArray();
        $menu_id = $queryMenu['id_menu'];
        return $query = $builder1->select('role_id, menu_id')
                            ->where(['role_id' => $role_id, 'menu_id' => $menu_id])
                            ->countAllResults();
        $this->db->transComplete();
    
    }

    
}
?>
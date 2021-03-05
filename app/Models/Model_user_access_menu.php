<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_user_access_menu extends Model
{
	public function __construct(){
		$this->db = \Config\Database::connect();
    $this->request = \Config\Services::request();
	 }

	protected $table                = 'user_access_menu';
	protected $primaryKey           = 'id_user_access_menu';
	protected $allowedFields        = ['menu_id', 'role_id'];

  public function UbahRole($role_id, $menu_id){
        
        
    $builder = $this->db->table('user_access_menu');
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



}

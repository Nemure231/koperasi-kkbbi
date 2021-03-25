<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_stok extends Model
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	 }

	protected $table                = 'stok';
	protected $primaryKey           = 'id_stok';
	protected $allowedFields        = ['min_stok'];

	public function GetAllStokHampirHabis($min_stok) {

        $queryB ="SELECT `nama_barang`, `stok_barang`, `kode_barang`
                  FROM `barang`
                  WHERE `stok_barang` <= $min_stok

                  GROUP BY `nama_barang`";
        return $this->db->query($queryB)->getResultArray();
  }


}

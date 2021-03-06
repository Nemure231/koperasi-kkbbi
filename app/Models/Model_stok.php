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


}

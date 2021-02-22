<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_barang extends Model{

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['gambar_barang', 'nama_barang'];


    // public function cariBuku($kunci){

    //     return $this->db->table('buku')->select('id_buku, sampul_buku, blurb, nama_jenis_buku, harga_buku, jenis_buku_id, penulis_id, id_penerbit,judul_buku, kode_buku, COUNT(penulis.id_penulis) AS jml, COUNT(penerbit.id_penerbit) AS pen, COUNT(genre.id_genre) AS gen')
	// 		->select('GROUP_CONCAT(penulis.nama_penulis SEPARATOR ",") AS nama_penulisB')
	// 		->select('GROUP_CONCAT(penerbit.nama_penerbit SEPARATOR ",") AS nama_penerbitB')
    //         ->select('GROUP_CONCAT(genre.nama_genre SEPARATOR ",") AS nama_genreB')
    //         ->like('judul_buku', $kunci)
	// 		->join('buku_genre_penulis_penerbit', 'buku_genre_penulis_penerbit.buku_id = buku.id_buku', 'left')
	// 		->join('genre', 'genre.id_genre = buku_genre_penulis_penerbit.genre_id', 'left')
	// 		->join('penulis', 'penulis.id_penulis = buku_genre_penulis_penerbit.penulis_id', 'left')
	// 		->join('penerbit', 'penerbit.id_penerbit = buku_genre_penulis_penerbit.penerbit_id', 'left')
	// 		->join('jenis_buku', 'jenis_buku.id_jenis_buku = buku.jenis_buku_id')
    //         ->groupBy('judul_buku')->get()->getResultArray();
            
    // //    $builder = $this->db->table('buku');
    // //    $query = $builder->like('judul_buku', $kunci);
    // //    return $query;

    // }


    
}
?>
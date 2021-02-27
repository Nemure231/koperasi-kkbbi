<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_barang extends Model{

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['gambar_barang', 'nama_barang', 'kode_barang', 'kategori_id', 'satuan_id', 'merek_id', 'pengirim_barang_id', 'harga_pokok', 'harga_konsumen', 'harga_anggota', 'stok_id', 'stok_barang', 'deskripsi_barang', 'gambar_barang', 'tanggal', 'tanggal_update'];

    
}
?>
<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'id_kategori',
        'nama_produk',
        'harga_produk',
        'stok',
        'satuan',
        'tanggal_kadaluarsa',
        'foto',
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Helper query join kategori
    public function withKategori()
    {
        return $this->select('products.*, categories.nama_kategori')
                    ->join('categories', 'categories.id = products.id_kategori');
    }

    // Kurangi stok setelah transaksi
    public function reduceStock($id_produk, $qty)
    {
        return $this->set('stok', "stok - $qty", false)
                    ->where('id', $id_produk)
                    ->update();
    }
}
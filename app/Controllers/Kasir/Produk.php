<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\KategoriModel;

class Produk extends BaseController
{
   public function index()
{
    $produkModel = new \App\Models\ProdukModel();

    $keyword  = $this->request->getGet('q');
    $kategori = $this->request->getGet('kategori');

    $builder = $produkModel->withKategori()
                           ->orderBy('products.nama_produk', 'ASC');

    if (!empty($keyword)) {
        $builder->like('products.nama_produk', $keyword);
    }

    if (!empty($kategori)) {
        $builder->where('products.id_kategori', $kategori);
    }

    $produk = $builder->findAll();

    return view('kasir/produk/index', [
        'title'           => 'Pilih Produk',
        'produk'          => $produk,
        'keyword'         => $keyword,
        'kategori_filter' => $kategori,
        'kategori'        => (new \App\Models\KategoriModel())->findAll(),
    ]);
}
}
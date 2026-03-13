<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $builder = $this->produkModel
            ->select('products.*, categories.nama_kategori')
            ->join('categories', 'categories.id = products.id_kategori', 'left');

        $produk = $builder->findAll();

        return view('owner/produk/index', [
            'title'  => 'Monitoring Produk',
            'produk' => $produk
        ]);
    }
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ProdukModel;

class Kategori extends BaseController
{
    protected $kategoriModel;
    protected $produkModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->produkModel  = new ProdukModel();
    }

    public function index()
    {
        return view('admin/kategori/index', [
            'kategori' => $this->kategoriModel->findAll()
        ]);
    }

    public function create()
    {
        return view('admin/kategori/create');
    }

    public function store()
    {
        $this->kategoriModel->insert([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            return redirect()->to('/admin/kategori')->with('error', 'Kategori tidak ditemukan');
        }

        return view('admin/kategori/edit', compact('kategori'));
    }

    public function update($id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diperbarui');
    }

    public function delete($id)
    {
        // ✅ CEK RELASI KE PRODUK
        $produkPakaiKategori = $this->produkModel
            ->where('id_kategori', $id)
            ->countAllResults();

        if ($produkPakaiKategori > 0) {
            return redirect()->to('/admin/kategori')
                ->with('error', 'Kategori tidak bisa dihapus karena masih ada stok obat menggunakan kategori tersebut.');
        }

        $this->kategoriModel->delete($id);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
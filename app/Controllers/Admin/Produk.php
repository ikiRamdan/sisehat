<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\KategoriModel;

class Produk extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;

    public function __construct()
    {
        helper('log'); // aktifkan helper log

        $this->produkModel   = new ProdukModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $keyword  = $this->request->getGet('q');
        $kategori = $this->request->getGet('kategori');

        $builder = $this->produkModel->withKategori();

        if (!empty($keyword)) {
            $builder->like('products.nama_produk', $keyword);
        }

        if (!empty($kategori)) {
            $builder->where('products.id_kategori', $kategori);
        }

        $produk = $builder->findAll();

        return view('admin/produk/index', [
            'title'           => 'Data Produk',
            'produk'          => $produk,
            'keyword'         => $keyword,
            'kategori_filter' => $kategori,
            'kategori'        => $this->kategoriModel->findAll()
        ]);
    }

    public function create()
    {
        return view('admin/produk/create', [
            'title'    => 'Tambah Produk',
            'kategori' => $this->kategoriModel->findAll()
        ]);
    }

    public function store()
    {
        $rules = [
            'nama_produk'  => 'required|min_length[3]',
            'harga_produk' => 'required|decimal|greater_than_equal_to[0]',
            'stok'         => 'required|is_natural',
            'id_kategori'  => 'required|is_natural_no_zero',
            'foto'         => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(WRITEPATH . '../public/uploads/produk', $namaFoto);
        }

        $data = [
            'nama_produk'        => $this->request->getPost('nama_produk'),
            'harga_produk'       => $this->request->getPost('harga_produk'),
            'stok'               => $this->request->getPost('stok'),
            'deskripsi'          => $this->request->getPost('deskripsi'),
            'tanggal_kadaluarsa' => $this->request->getPost('tanggal_kadaluarsa'),
            'id_kategori'        => $this->request->getPost('id_kategori'),
            'foto'               => $namaFoto,
        ];

        $this->produkModel->save($data);

        // log aktivitas
        save_log("Admin menambahkan produk: " . $data['nama_produk']);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('admin/produk/edit', [
            'title'    => 'Edit Produk',
            'produk'   => $this->produkModel->find($id),
            'kategori' => $this->kategoriModel->findAll()
        ]);
    }

    public function update($id)
    {
        $rules = [
            'nama_produk'  => 'required|min_length[3]',
            'harga_produk' => 'required|decimal|greater_than_equal_to[0]',
            'id_kategori'  => 'required|is_natural_no_zero',
            'foto'         => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $produkLama = $this->produkModel->find($id);

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $produkLama['foto'] ?? null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {

            if (!empty($produkLama['foto'])) {
                $pathLama = WRITEPATH . '../public/uploads/produk/' . $produkLama['foto'];
                if (is_file($pathLama)) {
                    unlink($pathLama);
                }
            }

            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(WRITEPATH . '../public/uploads/produk', $namaFoto);
        }

        $data = [
            'nama_produk'        => $this->request->getPost('nama_produk'),
            'harga_produk'       => $this->request->getPost('harga_produk'),
            'deskripsi'          => $this->request->getPost('deskripsi'),
            'tanggal_kadaluarsa' => $this->request->getPost('tanggal_kadaluarsa'),
            'id_kategori'        => $this->request->getPost('id_kategori'),
            'foto'               => $namaFoto,
        ];

        $this->produkModel->update($id, $data);

        // log aktivitas
        save_log("Admin mengubah produk: " . $data['nama_produk']);

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil diupdate');
    }

    public function delete($id)
    {
        $produk = $this->produkModel->find($id);

        if (!empty($produk['foto'])) {
            $path = WRITEPATH . '../public/uploads/produk/' . $produk['foto'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->produkModel->delete($id);

        // log aktivitas
        save_log("Admin menghapus produk: " . $produk['nama_produk']);

        return redirect()->back()->with('success', 'Produk & foto berhasil dihapus');
    }
}
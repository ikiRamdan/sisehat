<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Pengguna extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->findAll();
        return view('admin/pengguna/index', compact('users'));
    }

    public function create()
    {
        return view('admin/pengguna/create');
    }

   public function store()
{
    $this->userModel->insert([
        'username'  => $this->request->getPost('username'),
        'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'nama'      => $this->request->getPost('nama'),
        'role'      => $this->request->getPost('role'),
        'is_active' => $this->request->getPost('is_active'),
    ]);

    return redirect()->to('/admin/pengguna')->with('success', 'User berhasil ditambahkan');
}

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/pengguna')->with('error', 'User tidak ditemukan');
        }

        return view('admin/pengguna/edit', compact('user'));
    }

    public function update($id)
{
    $data = [
        'username'  => $this->request->getPost('username'),
        'nama'      => $this->request->getPost('nama'),
        'role'      => $this->request->getPost('role'),
        'is_active' => $this->request->getPost('is_active'),
    ];

    if ($this->request->getPost('password')) {
        $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
    }

    $this->userModel->update($id, $data);

    return redirect()->to('/admin/pengguna')->with('success', 'User berhasil diupdate');
}

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/admin/pengguna')->with('success', 'User berhasil dihapus');
    }

    public function toggle($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/pengguna')->with('error', 'User tidak ditemukan');
        }

        $this->userModel->update($id, [
            'is_active' => $user['is_active'] ? 0 : 1
        ]);

        return redirect()->to('/admin/pengguna')->with('success', 'Status user diperbarui');
    }
}
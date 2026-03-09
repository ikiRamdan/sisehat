<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LogModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole();
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        if ((int) $user['is_active'] !== 1) {
            return redirect()->back()->with('error', 'Akun nonaktif. Hubungi admin.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        session()->set([
            'id_user'    => $user['id'],
            'username'   => $user['username'],
            'nama'       => $user['nama'],
            'role'       => $user['role'],
            'isLoggedIn' => true
        ]);

        (new LogModel())->insert([
            'id_user'  => $user['id'],
            'activity' => 'Login berhasil'
        ]);

        return $this->redirectByRole();
    }

    private function redirectByRole()
    {
        return match (session('role')) {
            'admin' => redirect()->to('/admin/dashboard'),
            'kasir' => redirect()->to('/kasir/dashboard'),
            'owner' => redirect()->to('/owner/dashboard'),
            default => redirect()->to('/login'),
        };
    }

    public function logout()
    {
        if (session()->get('id_user')) {
            (new LogModel())->insert([
                'id_user'  => session('id_user'),
                'activity' => 'Logout'
            ]);
        }

        session()->destroy();
        return redirect()->to('/login');
    }
}
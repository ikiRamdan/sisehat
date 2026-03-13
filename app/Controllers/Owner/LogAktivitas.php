<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;

class LogAktivitas extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('logs');
        $builder->select('logs.*, users.nama, users.username, users.role');
        $builder->join('users', 'users.id = logs.id_user');

        if ($this->request->getGet('role')) {
            $builder->where('users.role', $this->request->getGet('role'));
        }

        $builder->orderBy('logs.created_at', 'DESC');

        $logs = $builder->get()->getResultArray();

        return view('owner/log/index', [
            'title' => 'Log Aktivitas',
            'logs'  => $logs
        ]);
    }
}
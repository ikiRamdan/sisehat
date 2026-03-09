<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\LogModel;

class LogAktivitas extends BaseController
{
    public function index()
    {
        $role = $this->request->getGet('role');
        $q    = $this->request->getGet('q');

        $logModel = (new LogModel())->withUser();

        if ($role) {
            $logModel->where('users.role', $role);
        }

        if ($q) {
            $logModel->like('activity', $q);
        }

        $logs = $logModel->orderBy('logs.created_at', 'DESC')->findAll();

        return view('owner/log/index', compact('logs', 'role', 'q'));
    }
}
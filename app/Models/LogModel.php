<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table            = 'logs';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'id_user',
        'activity',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Join log dengan user (untuk owner)
    public function withUser()
    {
        return $this->select('logs.*, users.username, users.nama, users.role')
                    ->join('users', 'users.id = logs.id_user')
                    ->orderBy('logs.created_at', 'DESC');
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'id_user',
        'nama_pelanggan',
        'nomor_unik',
        'total_harga',
        'uang_bayar',
        'uang_kembali',
        'created_at',
    ];

    protected $useTimestamps    = false; // karena hanya ada created_at

    // Ambil laporan dengan user (join)
    public function withUser()
    {
        return $this->select('transactions.*, users.nama, users.role')
                    ->join('users', 'users.id = transactions.id_user');
    }

    // Filter laporan by tanggal
    public function filterByDate($awal, $akhir)
    {
        return $this->where('created_at >=', $awal)
                    ->where('created_at <=', $akhir);
    }
}
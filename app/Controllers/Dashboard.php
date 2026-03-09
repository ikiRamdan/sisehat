<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\TransaksiModel;
use App\Models\LogModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $produkModel;
    protected $kategoriModel;
    protected $transaksiModel;
    protected $logModel;

    public function __construct()
    {
        $this->userModel      = new UserModel();
        $this->produkModel    = new ProdukModel();
        $this->kategoriModel  = new KategoriModel();
        $this->transaksiModel = new TransaksiModel();
        $this->logModel       = new LogModel();
        $this->db             = \Config\Database::connect();
    }

    // Redirect otomatis sesuai role
    public function index()
    {
        $role = session()->get('role');

        if (!$role) {
            return redirect()->to('/login');
        }

        return match ($role) {
            'admin' => redirect()->to('/admin/dashboard'),
            'kasir' => redirect()->to('/kasir/dashboard'),
            'owner' => redirect()->to('/owner/dashboard'),
            default => redirect()->to('/login'),
        };
    }

    // =========================
    // DASHBOARD ADMIN
    // =========================
    public function admin()
    {
        $totalProduk   = $this->produkModel->countAllResults();
        $totalKategori = $this->kategoriModel->countAllResults();
        $totalUser     = $this->userModel->countAllResults();

        $stokMenipis = $this->produkModel
            ->where('stok <=', 5)
            ->countAllResults();

        $produkMenipis = $this->produkModel
            ->where('stok <=', 5)
            ->orderBy('stok', 'ASC')
            ->findAll(10);

        return view('admin/dashboard', [
            'totalProduk'   => $totalProduk,
            'totalKategori' => $totalKategori,
            'totalUser'     => $totalUser,
            'stokMenipis'   => $stokMenipis,
            'produkMenipis' => $produkMenipis,
        ]);
    }

    // =========================
    // DASHBOARD KASIR
    // =========================
    public function kasir()
    {
        $today = date('Y-m-d');

        $totalProduk = $this->produkModel->countAllResults();

        $transaksiHariIni = $this->transaksiModel
            ->where('DATE(created_at)', $today)
            ->countAllResults();

        $omzetHariIni = $this->transaksiModel
            ->selectSum('total_harga')
            ->where('DATE(created_at)', $today)
            ->first()['total_harga'] ?? 0;

        $transaksiTerakhir = $this->transaksiModel
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        return view('kasir/dashboard', [
            'totalProduk'       => $totalProduk,
            'transaksiHariIni'  => $transaksiHariIni,
            'omzetHariIni'      => $omzetHariIni,
            'transaksiTerakhir' => $transaksiTerakhir,
        ]);
    }

   // =========================
// DASHBOARD OWNER (FINAL)
// =========================
public function owner()
{
    $bulanIni = date('Y-m');

    // KPI utama
    $totalTransaksi = $this->transaksiModel->countAllResults();

    $omzetBulanIni = $this->transaksiModel
        ->selectSum('total_harga')
        ->where('DATE_FORMAT(created_at, "%Y-%m")', $bulanIni)
        ->first()['total_harga'] ?? 0;

    $userAktif = $this->userModel
        ->where('is_active', 1)
        ->countAllResults();

    // =========================
    // DATA GRAFIK OMZET HARIAN (BULAN INI)
    // =========================
    $grafikOmzet = $this->db->query("
        SELECT 
            DATE(created_at) as tanggal, 
            SUM(total_harga) as omzet
        FROM transactions
        WHERE DATE_FORMAT(created_at, '%Y-%m') = ?
        GROUP BY DATE(created_at)
        ORDER BY tanggal ASC
    ", [$bulanIni])->getResultArray();

    // =========================
    // TOP PRODUK BULAN INI
    // =========================
    $topProduk = $this->db->table('transaction_details td')
        ->select('products.nama_produk, SUM(td.qty) as total_qty')
        ->join('products', 'products.id = td.id_produk')
        ->join('transactions', 'transactions.id = td.id_transaksi')
        ->where('DATE_FORMAT(transactions.created_at, "%Y-%m")', $bulanIni)
        ->groupBy('td.id_produk')
        ->orderBy('total_qty', 'DESC')
        ->limit(5)
        ->get()
        ->getResultArray();

    // =========================
    // LOG AKTIVITAS TERBARU
    // =========================
    $logTerbaru = $this->db->table('logs')
        ->select('logs.activity, logs.created_at, users.nama, users.role')
        ->join('users', 'users.id = logs.id_user')
        ->orderBy('logs.created_at', 'DESC')
        ->limit(10)
        ->get()
        ->getResultArray();

    // =========================
    // (OPSIONAL) STOK KRITIS UNTUK OWNER
    // =========================
    $stokKritis = $this->produkModel
        ->select('nama_produk, stok')
        ->where('stok <=', 5)
        ->orderBy('stok', 'ASC')
        ->findAll(5);

    return view('owner/dashboard', [
        'totalTransaksi' => $totalTransaksi,
        'omzetBulanIni'  => $omzetBulanIni,
        'userAktif'      => $userAktif,
        'grafikOmzet'    => $grafikOmzet,   // 👉 untuk Chart.js
        'topProduk'      => $topProduk,
        'logTerbaru'     => $logTerbaru,
        'stokKritis'     => $stokKritis,     // 👉 opsional ditampilkan
    ]);
}
}
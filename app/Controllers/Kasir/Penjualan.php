<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\TransaksiModel;
use Dompdf\Dompdf;

class Penjualan extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];

        return view('kasir/penjualan/index', [
            'title' => 'Transaksi Penjualan',
            'cart'  => $cart
        ]);
    }

    // =========================
    // TAMBAH KE KERANJANG
    // =========================
    public function addToCart()
    {
        $id_produk = (int) $this->request->getPost('id_produk');
        $qty       = (int) $this->request->getPost('qty');

        $produkModel = new ProdukModel();
        $produk = $produkModel->find($id_produk);

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        if ($qty < 1) {
            return redirect()->back()->with('error', 'Qty tidak valid');
        }

        if ($qty > $produk['stok']) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id_produk])) {
            $cart[$id_produk]['qty'] += $qty;

            if ($cart[$id_produk]['qty'] > $produk['stok']) {
                return redirect()->back()->with('error', 'Total qty melebihi stok tersedia');
            }

            $cart[$id_produk]['subtotal'] =
                $cart[$id_produk]['qty'] * $cart[$id_produk]['harga_produk'];
        } else {
            $cart[$id_produk] = [
                'id_produk'    => $produk['id'],
                'nama_produk'  => $produk['nama_produk'],
                'harga_produk' => (int) $produk['harga_produk'],
                'qty'          => $qty,
                'subtotal'     => (int) $produk['harga_produk'] * $qty,
            ];
        }

        session()->set('cart', $cart);

        return redirect()->to('/kasir/penjualan')->with('success', 'Produk masuk keranjang');
    }

    // =========================
    // HAPUS ITEM CART
    // =========================
    public function removeCart($id)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->set('cart', $cart);
        }

        return redirect()->to('/kasir/penjualan')->with('success', 'Item dihapus dari keranjang');
    }

    // =========================
    // SIMPAN TRANSAKSI
    // =========================
    public function store()
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) === 0) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        $total = array_sum(array_column($cart, 'subtotal'));
        $uangBayar = (int) $this->request->getPost('uang_bayar');

        if ($uangBayar < $total) {
            return redirect()->back()->with('error', 'Uang bayar kurang');
        }

        $db = db_connect();
        $db->transStart();

        $transaksiModel = new TransaksiModel();
        $produkModel    = new ProdukModel();

        $transaksiId = $transaksiModel->insert([
            'id_user'        => session('id_user'),
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'nomor_unik'     => 'TRX-' . date('YmdHis'),
            'total_harga'   => $total,
            'uang_bayar'    => $uangBayar,
            'uang_kembali'  => $uangBayar - $total,
        ]);

        foreach ($cart as $item) {
            $db->table('transaction_details')->insert([
                'id_transaksi' => $transaksiId,
                'id_produk'    => $item['id_produk'],
                'qty'          => $item['qty'],
                'harga_satuan' => $item['harga_produk'],
                'subtotal'     => $item['subtotal'],
            ]);

            // Proteksi stok
            $produkModel->reduceStock($item['id_produk'], $item['qty']);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Transaksi gagal, silakan ulangi');
        }

        session()->remove('cart');

        return redirect()->to('/kasir/penjualan/struk/' . $transaksiId)
            ->with('success', 'Transaksi berhasil');
    }

    // =========================
    // RIWAYAT TRANSAKSI KASIR
    // =========================
    public function riwayat()
    {
        $db = db_connect();

        $data['riwayat'] = $db->table('transactions t')
            ->select('t.*, u.nama')
            ->join('users u', 'u.id = t.id_user')
            ->where('t.id_user', session('id_user')) // kasir hanya lihat miliknya
            ->orderBy('t.id', 'DESC')
            ->get()
            ->getResultArray();

        return view('kasir/penjualan/riwayat', $data);
    }

    // =========================
    // STRUK HTML
    // =========================
    public function struk($id)
    {
        $db = db_connect();

        $transaksi = $db->table('transactions')->where('id', $id)->get()->getRowArray();

        if (!$transaksi) {
            return redirect()->to('/kasir/penjualan')->with('error', 'Transaksi tidak ditemukan');
        }

        $detail = $db->table('transaction_details td')
            ->select('td.*, products.nama_produk')
            ->join('products', 'products.id = td.id_produk')
            ->where('td.id_transaksi', $id)
            ->get()
            ->getResultArray();

        return view('kasir/penjualan/struk', compact('transaksi', 'detail'));
    }

    // =========================
    // STRUK PDF
    // =========================
    public function strukPdf($id)
    {
        $db = db_connect();

        $transaksi = $db->table('transactions')->where('id', $id)->get()->getRowArray();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        $detail = $db->table('transaction_details td')
            ->select('td.*, products.nama_produk')
            ->join('products', 'products.id = td.id_produk')
            ->where('td.id_transaksi', $id)
            ->get()
            ->getResultArray();

        $html = view('kasir/penjualan/struk_pdf', compact('transaksi', 'detail'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A6', 'portrait');
        $dompdf->render();

        return $dompdf->stream('struk-' . $transaksi['nomor_unik'] . '.pdf', ['Attachment' => true]);
    }
}
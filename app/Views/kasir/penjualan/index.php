<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4>Keranjang & Checkout</h4>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (empty($cart)): ?>
    <div class="alert alert-info">Keranjang masih kosong</div>
<?php else: ?>

<table class="table table-bordered">
<tr>
    <th>Produk</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Subtotal</th>
    <th>Aksi</th>
</tr>
<?php $total = 0; ?>
<?php foreach ($cart as $c): ?>
<?php $total += $c['subtotal']; ?>
<tr>
    <td><?= esc($c['nama_produk']) ?></td>
    <td>Rp <?= number_format($c['harga_produk'], 0, ',', '.') ?></td>
    <td><?= $c['qty'] ?></td>
    <td>Rp <?= number_format($c['subtotal'], 0, ',', '.') ?></td>
    <td>
        <a href="/kasir/penjualan/remove/<?= $c['id_produk'] ?>" class="btn btn-danger btn-sm">🗑️</a>
    </td>
</tr>
<?php endforeach; ?>
<tr>
    <th colspan="3">Total</th>
    <th colspan="2">Rp <?= number_format($total, 0, ',', '.') ?></th>
</tr>
</table>

<form method="post" action="/kasir/penjualan/store" class="card p-3 col-md-5">
    <?= csrf_field() ?>
    <input type="text" name="nama_pelanggan" class="form-control mb-2" placeholder="Nama pelanggan">
    <input type="number" name="uang_bayar" class="form-control mb-2" placeholder="Uang bayar" required>
    <button class="btn btn-success">💾 Simpan Transaksi</button>
</form>

<?php endif ?>

<?= $this->endSection() ?>
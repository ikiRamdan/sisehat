<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
<div class="card-body">

<table class="table table-bordered table-striped align-middle">

<thead>
<tr>
<th>Produk</th>
<th>Kategori</th>
<th>Stok</th>
<th>Harga</th>
<th>Kadaluarsa</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php foreach ($produk as $p): ?>

<tr>

<td><?= esc($p['nama_produk']) ?></td>

<td><?= esc($p['nama_kategori']) ?></td>

<td>
<?php if ($p['stok'] <= 10): ?>
<span class="badge bg-danger"><?= $p['stok'] ?></span>
<?php else: ?>
<span class="badge bg-success"><?= $p['stok'] ?></span>
<?php endif ?>
</td>

<td>
Rp <?= number_format($p['harga_produk'],0,',','.') ?>
</td>

<td>
<?= $p['tanggal_kadaluarsa'] ?? '-' ?>
</td>

<td>

<?php
$status = "Aman";
$badge = "bg-success";

if ($p['stok'] <= 10) {
    $status = "Stok Rendah";
    $badge = "bg-danger";
}

if (!empty($p['tanggal_kadaluarsa']) && strtotime($p['tanggal_kadaluarsa']) < strtotime('+30 days')) {
    $status = "Hampir Expired";
    $badge = "bg-warning text-dark";
}
?>

<span class="badge <?= $badge ?>">
<?= $status ?>
</span>

</td>

</tr>

<?php endforeach ?>

</tbody>
</table>

</div>
</div>

<?= $this->endSection() ?>
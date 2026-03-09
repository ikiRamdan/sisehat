<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4>Pilih Produk</h4>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form method="get" class="row g-2 mb-3">
    <div class="col-md-5">
        <input 
            type="text" 
            name="q" 
            class="form-control" 
            placeholder="Cari nama produk..." 
            value="<?= esc($keyword ?? '') ?>">
    </div>

    <div class="col-md-4">
        <select name="kategori" class="form-control">
            <option value="">-- Semua Kategori --</option>
            <?php foreach ($kategori as $k): ?>
                <option 
                    value="<?= $k['id'] ?>"
                    <?= ($kategori_filter == $k['id']) ? 'selected' : '' ?>>
                    <?= esc($k['nama_kategori']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">🔎 Cari</button>
        <a href="/kasir/produk" class="btn btn-secondary">♻ Reset</a>
    </div>
</form>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width:80px">Foto</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th style="width:170px">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($produk as $p): ?>
    <tr>
        <td>
            <?php if (!empty($p['foto'])): ?>
                <img src="/uploads/produk/<?= esc($p['foto']) ?>" 
                     width="60" height="60" 
                     style="object-fit:cover" 
                     class="rounded border">
            <?php else: ?>
                <span class="text-muted">—</span>
            <?php endif; ?>
        </td>
        <td><?= esc($p['nama_produk']) ?></td>
        <td><?= esc($p['nama_kategori']) ?></td>
        <td>Rp <?= number_format($p['harga_produk'], 0, ',', '.') ?></td>
        <td>
            <?php if ($p['stok'] <= 0): ?>
                <span class="badge bg-secondary">Habis</span>
            <?php else: ?>
                <?= $p['stok'] ?>
            <?php endif; ?>
        </td>
        <td>
            <?php if ($p['stok'] > 0): ?>
                <form method="post" action="/kasir/penjualan/add" class="d-flex gap-1">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
                    <input type="number" name="qty" value="1" min="1" max="<?= $p['stok'] ?>" 
                           class="form-control form-control-sm" style="width:70px">
                    <button class="btn btn-sm btn-primary">➕ Keranjang</button>
                </form>
            <?php else: ?>
                <button class="btn btn-sm btn-secondary" disabled>Stok Habis</button>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach ?>
    </tbody>
</table>

<a href="/kasir/penjualan" class="btn btn-success">🧾 Lihat Keranjang</a>

<?= $this->endSection() ?>
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<a href="/admin/produk/create" class="btn btn-primary mb-3">+ Tambah Produk</a>

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
        <button type="submit" class="btn btn-primary">🔍 Cari</button>
        <a href="/admin/produk" class="btn btn-secondary">♻ Reset</a>
    </div>
</form>

<table class="table table-bordered table-striped align-middle">
    <thead>
        <tr>
            <th style="width:80px">Foto</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
            <th style="width:110px">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($produk as $p): ?>
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
            <td>
                <?php if ($p['stok'] < 10): ?>
                    <span class="badge bg-danger"><?= $p['stok'] ?></span>
                <?php else: ?>
                    <span class="badge bg-success"><?= $p['stok'] ?></span>
                <?php endif ?>
            </td>
            <td>Rp <?= number_format($p['harga_produk'] ?? 0, 0, ',', '.') ?></td>
            <td>
                <a href="/admin/produk/edit/<?= $p['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                <a href="/admin/produk/delete/<?= $p['id'] ?>" 
                   onclick="return confirm('Yakin hapus produk ini?')" 
                   class="btn btn-sm btn-danger">🗑️</a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
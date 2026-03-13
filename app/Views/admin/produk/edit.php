<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4>Edit Produk</h4>

<form method="post" action="/admin/produk/update/<?= $produk['id'] ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <input type="text" name="nama_produk" value="<?= esc($produk['nama_produk']) ?>" class="form-control mb-2" required>

    <select name="id_kategori" class="form-control mb-2" required>
        <?php foreach($kategori as $k): ?>
            <option value="<?= $k['id'] ?>" <?= $produk['id_kategori']==$k['id']?'selected':'' ?>>
                <?= esc($k['nama_kategori']) ?>
            </option>
        <?php endforeach ?>
    </select>

    <input type="number" name="harga_produk" value="<?= esc($produk['harga_produk']) ?>" class="form-control mb-2" required>

    <textarea name="deskripsi" class="form-control mb-2"><?= esc($produk['deskripsi']) ?></textarea>

    <input type="date" name="tanggal_kadaluarsa" value="<?= esc($produk['tanggal_kadaluarsa']) ?>" class="form-control mb-2">

    <div class="mb-3">
        <label class="form-label">Foto Produk</label><br>

        <?php if (!empty($produk['foto'])): ?>
            <img src="/uploads/produk/<?= esc($produk['foto']) ?>" width="120" class="rounded border mb-2">
        <?php else: ?>
            <div class="text-muted mb-2">Belum ada foto</div>
        <?php endif; ?>

        <input type="file" name="foto" class="form-control" accept="image/*">
        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
    </div>

    <button class="btn btn-primary">Update</button>
</form>

<?= $this->endSection() ?>
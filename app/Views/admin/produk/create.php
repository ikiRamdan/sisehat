<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4>Tambah Produk</h4>

<form method="post" action="/admin/produk/store" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <input type="text" name="nama_produk" class="form-control mb-2" placeholder="Nama Produk" required>

    <select name="id_kategori" class="form-control mb-2" required>
        <?php foreach($kategori as $k): ?>
            <option value="<?= $k['id'] ?>"><?= esc($k['nama_kategori']) ?></option>
        <?php endforeach ?>
    </select>

    <input type="number" name="harga_produk" class="form-control mb-2" placeholder="Harga" required>
    <input type="number" name="stok" class="form-control mb-2" placeholder="Stok" required>

    <textarea name="deskripsi" class="form-control mb-2" placeholder="Deskripsi Produk"></textarea>

    <input type="date" name="tanggal_kadaluarsa" class="form-control mb-2">

    <div class="mb-3">
        <label class="form-label">Foto Produk</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
        <small class="text-muted">Format: JPG/PNG/WebP, maks 2MB</small>
    </div>

    <button class="btn btn-primary">Simpan</button>
</form>

<?= $this->endSection() ?>
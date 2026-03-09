<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Tambah Kategori</h4>

<form method="post" action="/admin/kategori/store" class="card p-3 col-md-6">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Simpan</button>
        <a href="/admin/kategori" class="btn btn-secondary">Kembali</a>
    </div>
</form>

<?= $this->endSection() ?>
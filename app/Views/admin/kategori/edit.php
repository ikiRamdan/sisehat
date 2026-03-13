<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4>Edit Kategori</h4>

<form method="post" action="/admin/kategori/update/<?= $kategori['id'] ?>" class="card p-3 col-md-6">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control"
               value="<?= esc($kategori['nama_kategori']) ?>" required>
    </div>


    <div class="d-flex gap-2">
        <button class="btn btn-primary">Update</button>
        <a href="/admin/kategori" class="btn btn-secondary">Kembali</a>
    </div>
</form>

<?= $this->endSection() ?>
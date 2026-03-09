<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Tambah Pengguna</h4>

<form method="post" action="/admin/pengguna/store" class="card p-3 col-md-6">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Username</label>
        <input name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input name="password" type="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Nama</label>
        <input name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="admin">Admin</option>
            <option value="kasir">Kasir</option>
            <option value="owner">Owner</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Status Akun</label>
        <select name="is_active" class="form-control" required>
            <option value="1" selected>Aktif</option>
            <option value="0">Nonaktif</option>
        </select>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Simpan</button>
        <a href="/admin/pengguna" class="btn btn-secondary">Kembali</a>
    </div>
</form>

<?= $this->endSection() ?>
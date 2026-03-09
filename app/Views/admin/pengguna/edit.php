<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4>Edit Pengguna</h4>

<form method="post" action="/admin/pengguna/update/<?= $user['id'] ?>" class="row g-2">

    <div class="col-md-4">
        <label>Username</label>
        <input type="text" name="username" class="form-control"
               value="<?= esc($user['username']) ?>" required>
    </div>

    <div class="col-md-4">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control"
               value="<?= esc($user['nama']) ?>" required>
    </div>

    <div class="col-md-4">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="kasir" <?= $user['role'] === 'kasir' ? 'selected' : '' ?>>Kasir</option>
            <option value="owner" <?= $user['role'] === 'owner' ? 'selected' : '' ?>>Owner</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>Status Akun</label>
        <select name="is_active" class="form-control" required>
            <option value="1" <?= $user['is_active'] == 1 ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= $user['is_active'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>Password (kosongkan jika tidak diganti)</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/admin/pengguna" class="btn btn-secondary">Kembali</a>
    </div>

</form>

<?= $this->endSection() ?>
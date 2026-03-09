<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<a href="/admin/pengguna/create" class="btn btn-primary mb-3">
    ➕ Tambah Pengguna
</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Username</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Status</th>
            <th width="220">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= esc($u['username']) ?></td>
            <td><?= esc($u['nama']) ?></td>
            <td>
                <span class="badge bg-secondary"><?= esc($u['role']) ?></span>
            </td>
            <td>
                <?= $u['is_active'] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>' ?>
            </td>
            <td>
                <a href="/admin/pengguna/edit/<?= $u['id'] ?>" class="btn btn-sm btn-warning">
                    ✏️ Edit
                </a>

                <a href="/admin/pengguna/delete/<?= $u['id'] ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Yakin hapus user ini?')">
                    🗑️ Hapus
                </a>

                
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
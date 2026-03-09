<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<a href="/admin/kategori/create" class="btn btn-primary mb-3">
    ➕ Tambah Kategori
</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th width="180">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($kategori as $k): ?>
        <tr>
            <td><?= esc($k['nama_kategori']) ?></td>
            <td><?= esc($k['deskripsi']) ?></td>
            <td>
                <a href="/admin/kategori/edit/<?= $k['id'] ?>" class="btn btn-sm btn-warning">
                    ✏️ Edit
                </a>
                <a href="/admin/kategori/delete/<?= $k['id'] ?>"
                   onclick="return confirm('Yakin hapus kategori ini?')"
                   class="btn btn-sm btn-danger">
                    🗑️ Hapus
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
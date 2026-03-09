<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Log Aktivitas Sistem</h4>

    <form action="" method="get" class="row g-3 mb-4">
        <div class="col-md-4">
            <select name="role" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Role --</option>
                <option value="admin" <?= (isset($_GET['role']) && $_GET['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="kasir" <?= (isset($_GET['role']) && $_GET['role'] == 'kasir') ? 'selected' : '' ?>>Kasir</option>
                 <option value="owner" <?= (isset($_GET['role']) && $_GET['role'] == 'owner') ? 'selected' : '' ?>>owner</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="<?= base_url('owner/log') ?>" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($logs)): ?>
                    <tr><td colspan="4" class="text-center">Tidak ada data aktivitas.</td></tr>
                <?php endif; ?>
                
                <?php foreach($logs as $l): ?>
                <tr>
                    <td><?= date('d M Y, H:i', strtotime($l['created_at'])) ?></td>
                    <td>
                        <strong><?= esc($l['nama']) ?></strong><br>
                        <small class="text-muted">@<?= esc($l['username']) ?></small>
                    </td>
                    <td>
                        <span class="badge <?= $l['role'] == 'admin' ? 'bg-primary' : 'bg-success' ?>">
                            <?= strtoupper($l['role']) ?>
                        </span>
                    </td>
                    <td><?= esc($l['activity']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
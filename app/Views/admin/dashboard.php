<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-dashboard shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-soft-primary">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="ms-3">
                    <small class="text-muted d-block">Total Produk</small>
                    <h4 class="fw-bold mb-0"><?= $totalProduk ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-soft-success">
                    <i class="bi bi-tags"></i>
                </div>
                <div class="ms-3">
                    <small class="text-muted d-block">Total Kategori</small>
                    <h4 class="fw-bold mb-0"><?= $totalKategori ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-soft-warning">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ms-3">
                    <small class="text-muted d-block">Total User</small>
                    <h4 class="fw-bold mb-0"><?= $totalUser ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-soft-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="ms-3">
                    <small class="text-muted d-block">Stok Kritis</small>
                    <h4 class="fw-bold mb-0 text-danger"><?= $stokMenipis ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-dashboard shadow-sm overflow-hidden">
    <div class="card-header bg-white py-3 border-0">
        <h6 class="fw-bold mb-0"><i class="bi bi-list-stars me-2"></i>Produk Stok Menipis</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th class="text-center">Sisa Stok</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produkMenipis as $p): ?>
                <tr>
                    <td><span class="fw-medium"><?= esc($p['nama_produk']) ?></span></td>
                    <td class="text-center fw-bold text-danger"><?= $p['stok'] ?></td>
                    <td class="text-center">
                        <span class="badge rounded-pill bg-danger-subtle text-danger px-3">Restock Segera</span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-dashboard shadow-sm p-4 border-start border-primary border-4">
            <p class="text-muted small text-uppercase fw-bold mb-1">Produk Aktif</p>
            <h3 class="fw-bold"><?= $totalProduk ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-dashboard shadow-sm p-4 border-start border-success border-4">
            <p class="text-muted small text-uppercase fw-bold mb-1">Transaksi Hari Ini</p>
            <h3 class="fw-bold"><?= $transaksiHariIni ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-dashboard shadow-sm p-4 border-start border-warning border-4">
            <p class="text-muted small text-uppercase fw-bold mb-1">Omzet Hari Ini</p>
            <h3 class="fw-bold">Rp <?= number_format($omzetHariIni, 0, ',', '.') ?></h3>
        </div>
    </div>
</div>

<div class="card card-dashboard shadow-sm overflow-hidden">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Transaksi Terakhir</h6>
        <a href="/kasir/penjualan/riwayat" class="btn btn-sm btn-light text-primary fw-bold">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Pelanggan</th>
                    <th>Total Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksiTerakhir as $t): ?>
                <tr>
                    <td class="small text-muted"><?= date('H:i', strtotime($t['created_at'])) ?> WIB</td>
                    <td><span class="fw-bold"><?= esc($t['nama_pelanggan']) ?></span></td>
                    <td class="fw-bold text-teal">Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
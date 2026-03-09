<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid p-0">
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-dashboard shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-soft-primary"><i class="bi bi-receipt"></i></div>
                    <div class="ms-3">
                        <small class="text-muted">Total Transaksi</small>
                        <h4 class="fw-bold mb-0"><?= number_format($totalTransaksi) ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dashboard shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-soft-success"><i class="bi bi-wallet2"></i></div>
                    <div class="ms-3">
                        <small class="text-muted">Omzet Bulan Ini</small>
                        <h4 class="fw-bold mb-0">Rp <?= number_format($omzetBulanIni) ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dashboard shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-soft-warning"><i class="bi bi-person-check"></i></div>
                    <div class="ms-3">
                        <small class="text-muted">User Aktif</small>
                        <h4 class="fw-bold mb-0"><?= number_format($userAktif) ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-dashboard shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="fw-bold mb-0">Laporan Pertumbuhan Omzet</h6>
        </div>
        <div class="card-body">
            <canvas id="chartOmzet" height="100"></canvas>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card card-dashboard shadow-sm h-100 overflow-hidden">
                <div class="card-header bg-white border-0 py-3"><h6 class="fw-bold mb-0">Top Produk Terlaris</h6></div>
                <table class="table table-custom mb-0">
                    <thead><tr><th>Produk</th><th class="text-center">Terjual</th></tr></thead>
                    <tbody>
                        <?php foreach ($topProduk as $row): ?>
                        <tr>
                            <td><?= esc($row['nama_produk']) ?></td>
                            <td class="text-center fw-bold"><span class="badge bg-teal-soft text-teal"><?= $row['total_qty'] ?> Unit</span></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-dashboard shadow-sm h-100 overflow-hidden">
                <div class="card-header bg-white border-0 py-3"><h6 class="fw-bold mb-0">Log Aktivitas Petugas</h6></div>
                <div class="px-3 pb-3">
                    <?php foreach ($logTerbaru as $log): ?>
                    <div class="d-flex align-items-start mb-3 border-bottom pb-2">
                        <div class="avatar-circle small me-3" style="width:35px; height:35px; font-size: 0.8rem;">
                            <?= strtoupper(substr($log['nama'],0,1)) ?>
                        </div>
                        <div>
                            <p class="mb-0 small fw-bold text-dark"><?= esc($log['nama']) ?> <span class="fw-normal text-muted">(<?= $log['role'] ?>)</span></p>
                            <p class="mb-0 text-muted" style="font-size: 0.75rem;"><?= esc($log['activity']) ?></p>
                            <small class="text-muted italic" style="font-size: 0.65rem;"><?= date('H:i', strtotime($log['created_at'])) ?> WIB</small>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartOmzet').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(110, 176, 180, 0.4)');
    gradient.addColorStop(1, 'rgba(110, 176, 180, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($grafikOmzet, 'tanggal')) ?>,
            datasets: [{
                label: 'Omzet (Rp)',
                data: <?= json_encode(array_column($grafikOmzet, 'omzet')) ?>,
                borderColor: '#6eb0b4',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6eb0b4',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { display: false }, ticks: { callback: v => 'Rp ' + v.toLocaleString() } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
<?= $this->endSection() ?>
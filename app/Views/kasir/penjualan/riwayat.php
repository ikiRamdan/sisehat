<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4>Riwayat Transaksi Kasir</h4>

<table class="table table-bordered table-striped">
    <tr>
        <th>No</th>
        <th>No Transaksi</th>
        <th>Kasir</th>
        <th>Total</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($riwayat as $i => $r): ?>
    <tr>
        <td><?= $i+1 ?></td>
        <td><?= esc($r['nomor_unik']) ?></td>
        <td><?= esc($r['nama']) ?></td>
        <td>Rp <?= number_format($r['total_harga'],0,',','.') ?></td>
        <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
        <td>
            <a href="/kasir/penjualan/struk/<?= $r['id'] ?>" class="btn btn-sm btn-info">Detail</a>
            <a href="/kasir/penjualan/struk-pdf/<?= $r['id'] ?>" class="btn btn-sm btn-danger">PDF</a>
        </td>
    </tr>
    <?php endforeach ?>
</table>

<?= $this->endSection() ?>
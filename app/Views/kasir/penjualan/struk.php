<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card p-4 mx-auto" style="max-width: 420px" id="struk-area">

    <h4 class="text-center mb-1">APOTEK SEJAHTERA</h4>
    <p class="text-center mb-1">Jl. Contoh No. 123</p>
    <hr>

    <small>No. Transaksi: <b><?= esc($transaksi['nomor_unik']) ?></b></small><br>
    <small>Tanggal: <?= date('d/m/Y H:i', strtotime($transaksi['created_at'])) ?></small>
    <hr>

    <table class="table table-sm">
        <?php foreach ($detail as $d): ?>
        <tr>
            <td>
                <?= esc($d['nama_produk']) ?><br>
                <small><?= $d['qty'] ?> x Rp <?= number_format($d['harga_satuan'], 0, ',', '.') ?></small>
            </td>
            <td class="text-end">
                Rp <?= number_format($d['subtotal'], 0, ',', '.') ?>
            </td>
        </tr>
        <?php endforeach ?>
    </table>

    <hr>

    <div class="d-flex justify-content-between">
        <b>Total</b>
        <b>Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></b>
    </div>
    <div class="d-flex justify-content-between">
        <span>Bayar</span>
        <span>Rp <?= number_format($transaksi['uang_bayar'], 0, ',', '.') ?></span>
    </div>
    <div class="d-flex justify-content-between">
        <span>Kembali</span>
        <span>Rp <?= number_format($transaksi['uang_kembali'], 0, ',', '.') ?></span>
    </div>

    <hr>

    <p class="text-center mb-1">Terima kasih 🙏</p>
    <p class="text-center mb-3">Semoga lekas sembuh</p>

    <div class="d-grid gap-2">
        <a href="/kasir/penjualan/struk-pdf/<?= $transaksi['id'] ?>" class="btn btn-danger">📄 Cetak PDF</a>
<a href="/kasir/penjualan" class="btn btn-secondary">⬅️ Transaksi Baru</a>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #struk-area, #struk-area * { visibility: visible; }
    #struk-area { position: absolute; left: 0; top: 0; width: 100%; }
}
</style>

<?= $this->endSection() ?>
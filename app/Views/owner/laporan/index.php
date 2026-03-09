<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Laporan Transaksi</h4>

<form method="get" class="row g-2 mb-3">
  <div class="col-md-3">
    <input type="date" name="start" class="form-control" value="<?= esc($start) ?>">
  </div>
  <div class="col-md-3">
    <input type="date" name="end" class="form-control" value="<?= esc($end) ?>">
  </div>
  <div class="col-md-3">
    <select name="kasir" class="form-control">
      <option value="">-- Semua Kasir --</option>
      <?php foreach ($kasirList as $k): ?>
        <option value="<?= $k['id'] ?>" <?= $kasir == $k['id'] ? 'selected' : '' ?>>
          <?= esc($k['nama']) ?>
        </option>
      <?php endforeach ?>
    </select>
  </div>
  <div class="col-md-3 d-grid">
    <button class="btn btn-primary">Filter</button>
  </div>
</form>

<div class="mb-3 d-flex gap-2">
  <a class="btn btn-danger"
     href="/owner/laporan/pdf?start=<?= esc($start) ?>&end=<?= esc($end) ?>&kasir=<?= esc($kasir) ?>">
     Export PDF
  </a>
  <a class="btn btn-success"
     href="/owner/laporan/excel?start=<?= esc($start) ?>&end=<?= esc($end) ?>&kasir=<?= esc($kasir) ?>">
     Export Excel
  </a>
</div>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>No Transaksi</th>
      <th>Tanggal</th>
      <th>Kasir</th>
      <th>Pelanggan</th>
      <th>Total</th>
      <th>Bayar</th>
      <th>Kembali</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($laporan)): ?>
      <tr><td colspan="8" class="text-center text-muted">Tidak ada data</td></tr>
    <?php else: $no=1; foreach ($laporan as $r): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= esc($r['nomor_unik']) ?></td>
        <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
        <td><?= esc($r['nama_kasir']) ?></td>
        <td><?= esc($r['nama_pelanggan']) ?></td>
        <td>Rp <?= number_format($r['total_harga']) ?></td>
        <td>Rp <?= number_format($r['uang_bayar']) ?></td>
        <td>Rp <?= number_format($r['uang_kembali']) ?></td>
      </tr>
    <?php endforeach; endif ?>
  </tbody>
</table>

<?= $this->endSection() ?>
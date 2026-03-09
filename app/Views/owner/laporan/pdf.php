<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Transaksi</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    table { width:100%; border-collapse: collapse; }
    th, td { border:1px solid #000; padding:6px; }
    th { background:#eee; }
  </style>
</head>
<body>
  <h3>Laporan Transaksi Owner</h3>
  <table>
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
      <?php $no=1; foreach ($laporan as $r): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= esc($r['nomor_unik']) ?></td>
        <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
        <td><?= esc($r['nama_kasir']) ?></td>
        <td><?= esc($r['nama_pelanggan']) ?></td>
        <td><?= number_format($r['total_harga']) ?></td>
        <td><?= number_format($r['uang_bayar']) ?></td>
        <td><?= number_format($r['uang_kembali']) ?></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</body>
</html>
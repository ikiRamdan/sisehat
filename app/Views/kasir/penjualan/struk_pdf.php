<style>
body { font-family: sans-serif; font-size: 12px }
h4 { text-align: center; margin-bottom: 5px }
table { width:100%; border-collapse: collapse }
td { padding: 3px 0 }
hr { border: none; border-top: 1px dashed #000 }
</style>

<h4>APOTEK SEJAHTERA</h4>
<p style="text-align:center">Jl. Contoh No. 123</p>
<hr>

No: <?= $transaksi['nomor_unik'] ?><br>
Tanggal: <?= date('d/m/Y H:i', strtotime($transaksi['created_at'])) ?>
<hr>

<table>
<?php foreach($detail as $d): ?>
<tr>
    <td><?= $d['nama_produk'] ?> (<?= $d['qty'] ?>x)</td>
    <td align="right">Rp <?= number_format($d['subtotal'],0,',','.') ?></td>
</tr>
<?php endforeach ?>
</table>

<hr>

Total: Rp <?= number_format($transaksi['total_harga'],0,',','.') ?><br>
Bayar: Rp <?= number_format($transaksi['uang_bayar'],0,',','.') ?><br>
Kembali: Rp <?= number_format($transaksi['uang_kembali'],0,',','.') ?><br>

<hr>
Terima kasih 🙏
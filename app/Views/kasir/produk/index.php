<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="mb-0">🛍️ Pilih Produk</h4>
        </div>
        <a href="/kasir/penjualan" class="btn btn-success btn-lg shadow-sm px-2">
            <i class="fas fa-shopping-basket me-2"></i>
            <span>Keranjang</span>
            <span class="badge bg-white text-success ms-2 rounded-pill">
                <?= count(session()->get('cart') ?? []) ?>
            </span>
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="get" action="/kasir/produk" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="q" class="form-control border-0 bg-light" 
                               placeholder="Cari nama produk atau barcode..." value="<?= esc($keyword ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-tag text-muted"></i></span>
                        <select name="kategori" class="form-select border-0 bg-light">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= (isset($kategori_filter) && $kategori_filter == $k['id']) ? 'selected' : '' ?>>
                                    <?= esc($k['nama_kategori']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <a href="/kasir/produk" class="btn btn-outline-secondary border-0" title="Reset">
                        <i class="fas fa-undo-alt"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-3 fa-lg"></i>
            <div><?= session()->getFlashdata('error') ?></div>
        </div>
    <?php endif; ?>

    <?php if (empty($produk)): ?>
        <div class="text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 120px; opacity: 0.5" alt="Empty">
            <h5 class="mt-3 text-muted">Produk tidak ditemukan</h5>
            <p class="small text-secondary">Coba gunakan kata kunci lain atau ganti kategori</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
            <?php foreach($produk as $p): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm product-card position-relative overflow-hidden">
                        
                        <div class="position-absolute top-0 end-0 m-2 z-index-2">
                            <?php if ($p['stok'] <= 0): ?>
                                <span class="badge bg-danger shadow-sm px-3 py-2 rounded-pill">Habis</span>
                            <?php elseif ($p['stok'] <= 5): ?>
                                <span class="badge bg-warning text-dark shadow-sm px-3 py-2 rounded-pill">Sisa <?= $p['stok'] ?></span>
                            <?php else: ?>
                                <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill border">Stok: <?= $p['stok'] ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="img-container">
                            <?php if (!empty($p['foto'])): ?>
                                <img src="/uploads/produk/<?= esc($p['foto']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= esc($p['nama_produk']) ?>">
                            <?php else: ?>
                                <div class="bg-light-subtle d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                                    <i class="fas fa-box-open fa-3x mb-2 opacity-25"></i>
                                    <span class="small">No Image</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body p-3">
                            <div class="mb-1">
                                <span class="badge bg-primary-subtle text-primary border-0 small fw-normal">
                                    <i class="fas fa-bookmark me-1"></i><?= esc($p['nama_kategori']) ?>
                                </span>
                            </div>
                            <h6 class="fw-bold text-dark text-truncate mb-1" title="<?= esc($p['nama_produk']) ?>">
                                <?= esc($p['nama_produk']) ?>
                            </h6>
                            <p class="text-muted small text-truncate-2 mb-3" style="font-size: 0.75rem; height: 32px;">
                                <?= esc($p['deskripsi'] ?: 'Tidak ada deskripsi produk.') ?>
                            </p>
                            <div class="mt-auto">
                                <div class="text-primary fw-bold fs-5">
                                    <span class="fs-6 fw-normal">Rp</span> <?= number_format($p['harga_produk'], 0, ',', '.') ?>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 p-3 pt-0">
                            <?php if ($p['stok'] > 0): ?>
                                <form method="post" action="/kasir/penjualan/add">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
                                    <div class="input-group">
                                        <input type="number" name="qty" value="1" min="1" max="<?= $p['stok'] ?>" 
                                               class="form-control form-control-sm text-center border-light-subtle bg-light shadow-none" 
                                               style="width: 50px;">
                                        <button type="submit" class="btn btn-primary btn-sm px-3 flex-grow-1 shadow-none">
                                            <i class="fas fa-plus-circle me-1"></i> Transaksi
                                        </button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-sm btn-light w-100 text-muted border-0 py-2" disabled>
                                    <i class="fas fa-times-circle me-1"></i> Stok Kosong
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Animasi Kartu */
    .product-card {
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        border-radius: 15px;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    /* Container Gambar agar Seragam */
    .img-container {
        height: 160px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .img-container img {
        transform: scale(1.1);
    }

    /* Teks Pembatas (Clamp) */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Custom Input Number */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        opacity: 1;
    }

    /* Warna Badge Custom */
    .bg-primary-subtle {
        background-color: #e7f1ff;
    }
</style>
<?= $this->endSection() ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Dashboard' ?> | SiSehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-dashboard">

<div class="container-fluid p-3">
    <div class="d-flex" style="gap: 20px;">
        
        <aside class="sidebar-floating shadow-sm">
            <div class="sidebar-header text-center p-4">
                <img src="<?= base_url('assets/img/logo_sisehat.png') ?>" alt="Logo" class="img-fluid mb-2" width="100">
                <h6 class="fw-bold text-teal m-0">SiSehat App</h6>
            </div>

            <div class="sidebar-menu px-3">
                <small class="text-muted text-uppercase fw-bold mb-3 d-block" style="font-size: 10px;">Menu Utama</small>
                
                <a href="/dashboard" class="menu-item <?= (url_is('/dashboard*')) ? 'active' : '' ?>">
                    <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard
                </a>

                <?php if (session('role') === 'admin'): ?>
                    <a href="/admin/produk" class="menu-item <?= (url_is('/admin/produk*')) ? 'active' : '' ?>">
                        <i class="bi bi-box-seam me-2"></i> Produk
                    </a>
                    <a href="/admin/kategori" class="menu-item <?= (url_is('/admin/kategori*')) ? 'active' : '' ?>">
                        <i class="bi bi-tags me-2"></i> Kategori
                    </a>
                    <a href="/admin/pengguna" class="menu-item <?= (url_is('/admin/pengguna*')) ? 'active' : '' ?>">
                        <i class="bi bi-people me-2"></i> Pengguna</a>

                <?php elseif (session('role') === 'kasir'): ?>
                    <a href="/kasir/produk" class="menu-item <?= (url_is('/kasir/produk*')) ? 'active' : '' ?>">
                        <i class="bi bi-box-seam me-2"></i> Produk</a>
                    <a href="/kasir/penjualan" class="menu-item <?= (url_is('/kasir/penjualan*')) ? 'active' : '' ?>">
                        <i class="bi bi-cart-check me-2"></i> Penjualan</a>
                    <a href="/kasir/penjualan/riwayat" class="menu-item <?= (url_is('/kasir/penjualan/riwayat*')) ? 'active' : '' ?>">
                        <i class="bi bi-clock-history me-2"></i> Riwayat</a>

                <?php elseif (session('role') === 'owner'): ?>
                    <a href="/owner/laporan" class="menu-item <?= (url_is('/owner/laporan*')) ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan</a>
                    <a href="/owner/log" class="menu-item <?= (url_is('/owner/log*')) ? 'active' : '' ?>">
                        <i class="bi bi-journal-text me-2"></i> Log Aktivitas</a>
                <?php endif; ?>
            </div>

            <div class="sidebar-footer px-3 mt-auto mb-4">
                <hr class="text-muted">
                <a href="/logout" class="menu-item logout">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </div>
        </aside>

        <main class="content-area shadow-sm">
            <header class="content-header mb-4 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold m-0"><?= $title ?? 'Dashboard' ?></h4>
                <div class="user-profile">
                    <span class="badge bg-teal-soft text-teal p-2"><?= session('role') ?></span>
                </div>
            </header>
            
            <section class="page-content">
                <?= $this->renderSection('content') ?>
            </section>
        </main>
        
    </div>
</div>

</body>
</html>
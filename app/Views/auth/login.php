<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | SiSehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>
<body>
<div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="login-container d-flex shadow-lg">
        
        <div class="login-illustration d-none d-md-flex align-items-center justify-content-center">
            <div class="logo-top-left">
                <img src="<?= base_url('assets/img/logo_sisehat.png') ?>" alt="Logo" width="150">
            </div>
            <img src="<?= base_url('assets/img/illustration.png') ?>" alt="Illustration" class="img-fluid main-img">
        </div>

        <div class="login-form-section p-5">
            <h2 class="mb-4 fw-bold">Login</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif ?>

            <form method="post" action="/login">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control custom-input" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control custom-input" placeholder="Enter your password" required>
        
                </div>

                <button class="btn btn-teal w-100 py-2 mb-3 mt-3">Login</button>

                
            </form>
            
        
        </div>
    </div>
</div>
</body>
</html>
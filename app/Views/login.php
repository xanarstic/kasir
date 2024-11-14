<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - <?= $settings['nama_logo'] ?></title>
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Additional Custom CSS */
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #fb8d0b 0%, #fb0b0b 100%);
        color: #ffffff;
    }

    .login-container {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
        color: #495057;
    }

    .login-container h2 {
        color: #343a40;
    }

    .form-control {
        border-radius: 5px;
    }

    .btn-primary {
        width: 100%;
        padding: 0.75rem;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #fb8d0b;
        border-color: #495057;
    }

    .logo img {
        width: 80px;
        height: auto;
        margin-bottom: 20px;
    }
</style>

<div class="login-container text-center">
    <div class="logo">
        <img src="<?= base_url('public/img/' . $settings['logos']) ?>" alt="App Logo" width="100">
    </div>
    <h2 class="text-center"><?= $settings['nama_logo'] ?></h2>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= base_url('home/aksi_login') ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
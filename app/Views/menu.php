<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><?= $settings['nama_menu'] ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('home/dashboard') ?>">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('home/pelanggan') ?>">Pelanggan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('home/produk') ?>">Produk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('home/penjualan') ?>">Penjualan</a>
            </li>

            <!-- Hanya tampil jika level adalah admin -->
            <?php if (session()->get('level') === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('home/activity') ?>">Log Activity</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('home/setting') ?>">Setting</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('home/user') ?>">User</a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('home/logout') ?>">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-4">
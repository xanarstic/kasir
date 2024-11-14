<div class="container">
    <h1 class="mt-5">Welcome to the Dashboard</h1>
    <p class="lead">This is the main dashboard page where you can see your aplication details.</p>

    <div class="row">
        <!-- Counter for Total Produk -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <i class="bi bi-box-seam fs-1"></i> <!-- Bootstrap Icon -->
                    <p class="card-text mt-2">
                        <?= $totalProduk ?> Produk
                    </p>
                </div>
            </div>
        </div>

        <!-- Counter for Total Penjualan -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Penjualan</h5>
                    <i class="bi bi-cash-stack fs-1"></i> <!-- Bootstrap Icon -->
                    <p class="card-text mt-2">
                        <?= $totalPenjualan ?> Penjualan
                    </p>
                </div>
            </div>
        </div>
</div>
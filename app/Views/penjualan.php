<div class="container mt-5">
    <h2>Data Penjualan</h2>
    <button class="btn btn-primary mb-3" onclick="showModal('add')">Tambah Penjualan</button>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Tabel Data Penjualan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Penjualan</th>
                <th>Total Harga</th>
                <th>Nama Pelanggan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($penjualan as $index => $p): ?>
                <?php
                $totalHarga = 0;
                foreach ($detailPenjualanModel->where('PenjualanID', $p['PenjualanID'])->findAll() as $detail) {
                    $totalHarga += $detail['Subtotal'];
                }
                ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $p['TanggalPenjualan'] ?></td>
                    <td>Rp <?= number_format($totalHarga, 2, ',', '.') ?></td>
                    <td><?= $pelangganData[$p['PelangganID']]['NamaPelanggan'] ?? 'Pelanggan Tidak Ditemukan' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Add/Edit Sales -->
<div class="modal fade" id="penjualanModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="penjualanForm" action="<?= base_url('home/tambahpenjualan') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="PenjualanID" name="PenjualanID">

                    <div class="mb-3">
                        <label for="NamaPelanggan" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" required>
                    </div>

                    <div class="mb-3">
                        <label for="ProdukID" class="form-label">Produk</label>
                        <select class="form-control" id="ProdukID" name="ProdukID" required>
                            <option value="">Pilih Produk</option>
                            <?php foreach ($produk as $p): ?>
                                <option value="<?= $p['ProdukID'] ?>"><?= $p['NamaProduk'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="JumlahProduk" class="form-label">Jumlah Produk</label>
                        <input type="number" class="form-control" id="JumlahProduk" name="JumlahProduk" required
                            min="1">
                    </div>

                    <div class="mb-3">
                        <label for="TotalHarga" class="form-label">Total Harga</label>
                        <input type="text" class="form-control" id="TotalHarga" name="TotalHarga" readonly>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script for Modal and Price Calculation -->
<script>
    function showModal(action, id = null, pelanggan = '') {
        if (action === 'add') {
            $('#modalLabel').text('Tambah Penjualan');
            $('#penjualanForm').attr('action', '<?= base_url('home/tambahpenjualan') ?>');
            $('#PenjualanID').val('');
            $('#PelangganID').val('');
            $('#ProdukID').val('');
            $('#JumlahProduk').val('');
            $('#TotalHarga').val('');
        }
        $('#penjualanModal').modal('show');
    }

    // Kalkulasi TotalHarga ketika produk atau jumlah diubah
    $(document).ready(function () {
        $('#ProdukID, #JumlahProduk').on('input', function () {
            var produkID = $('#ProdukID').val();
            var jumlahProduk = $('#JumlahProduk').val();

            if (produkID && jumlahProduk > 0) {
                $.ajax({
                    url: '<?= base_url('home/getProductPrice') ?>/' + produkID,
                    method: 'GET',
                    success: function (response) {
                        if (response.harga) {
                            var hargaProduk = parseFloat(response.harga);
                            var totalHarga = hargaProduk * parseInt(jumlahProduk);
                            $('#TotalHarga').val(totalHarga.toFixed(2)); // Update Total Harga
                        } else {
                            $('#TotalHarga').val('');
                            alert("Produk tidak ditemukan.");
                        }
                    },
                    error: function () {
                        $('#TotalHarga').val('');
                        alert("Gagal mengambil harga produk. Silakan coba lagi.");
                    }
                });
            } else {
                $('#TotalHarga').val('');
            }
        });
    });

    function showDetailModal(penjualanID) {
        $.ajax({
            url: '<?= base_url('home/getPenjualanDetail') ?>/' + penjualanID,
            method: 'GET',
            success: function (response) {
                let details = response.details;
                let detailBody = '';
                details.forEach(detail => {
                    detailBody += `
                <tr>
                    <td>${detail.NamaProduk}</td>
                    <td>${detail.JumlahProduk}</td>
                    <td>Rp ${parseFloat(detail.Subtotal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                </tr>`;
                });
                $('#detailPenjualanBody').html(detailBody);
                $('#detailPenjualanModal').modal('show');
            }
        });
    }
</script>
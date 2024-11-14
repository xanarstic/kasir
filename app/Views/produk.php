<div class="container mt-5">
    <h2>Data Produk</h2>
    <button class="btn btn-primary mb-3" onclick="showModal('add')">Tambah Produk</button>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Tabel Data Produk -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk as $index => $p): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $p['NamaProduk'] ?></td>
                    <td><?= number_format($p['Harga'], 2, ',', '.') ?></td>
                    <td><?= $p['Stok'] ?></td>
                    <td>
                        <button class="btn btn-warning"
                            onclick="showModal('edit', <?= $p['ProdukID'] ?>, '<?= $p['NamaProduk'] ?>', <?= $p['Harga'] ?>, <?= $p['Stok'] ?>)">Edit</button>
                        <a href="<?= base_url('home/deleteproduk/' . $p['ProdukID']) ?>" class="btn btn-danger"
                            onclick="return confirm('Hapus produk ini?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Form Tambah/Edit Produk -->
<div class="modal fade" id="produkModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="produkForm" action="<?= base_url('home/tambahproduk') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ProdukID" name="ProdukID">
                    <div class="mb-3">
                        <label for="NamaProduk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" required>
                    </div>
                    <div class="mb-3">
                        <label for="Harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="Harga" name="Harga" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="Stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="Stok" name="Stok" required>
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

<!-- Script untuk Modal -->
<script>
    function showModal(action, id = null, nama = '', harga = '', stok = '') {
        if (action === 'add') {
            $('#modalLabel').text('Tambah Produk');
            $('#produkForm').attr('action', '<?= base_url('home/tambahproduk') ?>');
            $('#ProdukID').val('');
            $('#NamaProduk').val('');
            $('#Harga').val('');
            $('#Stok').val('');
        } else if (action === 'edit') {
            $('#modalLabel').text('Edit Produk');
            $('#produkForm').attr('action', '<?= base_url('home/editproduk') ?>/' + id);
            $('#ProdukID').val(id);
            $('#NamaProduk').val(nama);
            $('#Harga').val(harga);
            $('#Stok').val(stok);
        }
        $('#produkModal').modal('show');
    }
</script>
<div class="container mt-5">
    <h2>Data Pelanggan</h2>
    <button class="btn btn-primary mb-3" onclick="showModal('add')">Tambah Pelanggan</button>
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

    <!-- Tabel Data Pelanggan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pelanggan as $index => $p): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $p['NamaPelanggan'] ?></td>
                    <td><?= $p['Alamat'] ?></td>
                    <td><?= $p['NomorTelepon'] ?></td>
                    <td>
                        <button class="btn btn-warning"
                            onclick="showModal('edit', <?= $p['PelangganID'] ?>, '<?= $p['NamaPelanggan'] ?>', '<?= $p['Alamat'] ?>', '<?= $p['NomorTelepon'] ?>')">Edit</button>
                        <a href="<?= base_url('home/deletep/' . $p['PelangganID']) ?>" class="btn btn-danger"
                            onclick="return confirm('Hapus pelanggan ini?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Form Tambah/Edit Pelanggan -->
<div class="modal fade" id="pelangganModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="pelangganForm" action="<?= base_url('home/tambahp') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="PelangganID" name="PelangganID">
                    <div class="mb-3">
                        <label for="NamaPelanggan" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" required>
                    </div>
                    <div class="mb-3">
                        <label for="Alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="Alamat" name="Alamat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="NomorTelepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="NomorTelepon" name="NomorTelepon">
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
    function showModal(action, id = null, nama = '', alamat = '', telepon = '') {
        if (action === 'add') {
            $('#modalLabel').text('Tambah Pelanggan');
            $('#pelangganForm').attr('action', '<?= base_url('home/tambahp') ?>');
            $('#PelangganID').val('');
            $('#NamaPelanggan').val('');
            $('#Alamat').val('');
            $('#NomorTelepon').val('');
        } else if (action === 'edit') {
            $('#modalLabel').text('Edit Pelanggan');
            $('#pelangganForm').attr('action', '<?= base_url('home/editp') ?>/' + id);
            $('#PelangganID').val(id);
            $('#NamaPelanggan').val(nama);
            $('#Alamat').val(alamat);
            $('#NomorTelepon').val(telepon);
        }
        $('#pelangganModal').modal('show');
    }
</script>
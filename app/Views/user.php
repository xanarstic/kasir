<div class="container mt-5">
    <h2>Data User</h2>
    <button class="btn btn-primary mb-3" onclick="showModal('add')">Tambah User</button>

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

    <!-- Tabel Data User -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $index => $user): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $user['nama'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['level'] ?></td>
                    <td>
                        <button class="btn btn-warning"
                            onclick="showModal('edit', <?= $user['id_user'] ?>, '<?= $user['nama'] ?>', '<?= $user['username'] ?>', '<?= $user['level'] ?>')">Edit</button>
                        <a href="<?= base_url('home/deleteuser/' . $user['id_user']) ?>" class="btn btn-danger"
                            onclick="return confirm('Hapus user ini?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Form Tambah/Edit User -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="userForm" action="<?= base_url('home/tambahuser') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_user" name="id_user">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select class="form-control" id="level" name="level" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
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
    function showModal(action, id = null, nama = '', username = '', level = '') {
        if (action === 'add') {
            $('#modalLabel').text('Tambah User');
            $('#userForm').attr('action', '<?= base_url('home/tambahuser') ?>');
            $('#id_user').val('');
            $('#nama').val('');
            $('#username').val('');
            $('#password').val('');
            $('#level').val('');
        } else if (action === 'edit') {
            $('#modalLabel').text('Edit User');
            $('#userForm').attr('action', '<?= base_url('home/edituser') ?>/' + id);
            $('#id_user').val(id);
            $('#nama').val(nama);
            $('#username').val(username);
            $('#password').val('');
            $('#level').val(level);
        }
        $('#userModal').modal('show');
    }
</script>
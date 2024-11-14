<div class="container mt-5">
    <h2>Application Settings</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('home/updatesetting') ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama_logo" class="form-label">Application Name</label>
            <input type="text" class="form-control" id="nama_logo" name="nama_logo"
                value="<?= $settings['nama_logo'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="logos" class="form-label">Application Logo</label>
            <input type="file" class="form-control" id="logos" name="logos">
            <?php if ($settings['logos']): ?>
                <img src="<?= base_url('public/img/' . $settings['logos']) ?>" alt="Current Logo" width="100" class="mt-3">
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="icon" class="form-label">Application Icon</label>
            <input type="file" class="form-control" id="icon" name="icon">
            <?php if ($settings['icon']): ?>
                <img src="<?= base_url('public/img/' . $settings['icon']) ?>" alt="Current Icon" width="50" class="mt-3">
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="nama_menu" class="form-label">Menu Name</label>
            <input type="text" class="form-control" id="nama_menu" name="nama_menu"
                value="<?= $settings['nama_menu'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>

</div>
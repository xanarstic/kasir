<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($settings['nama_logo']) ? $settings['nama_logo'] : 'App Name' ?> </title>

    <?php if (isset($settings['icon'])): ?>
        <link rel="icon" href="<?= base_url('public/img/' . $settings['icon']) ?>" type="image/png">
    <?php endif; ?>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
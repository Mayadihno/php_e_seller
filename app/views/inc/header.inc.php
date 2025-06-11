<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/styles.css">


    <?php if (isset($title)): ?>
        <title><?= $title; ?></title>
    <?php endif; ?>
</head>

<body>
    <main>
        <?php require '../app/views/inc/nav.inc.php'; ?>
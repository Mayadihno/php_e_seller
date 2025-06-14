<?php

use Auth\Session;

$session = new Session();
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$route = preg_replace('#^' . preg_quote($scriptName) . '#', '', $currentPath);

?>
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
    <style>
        body {
            background-color: #f9f9f9;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            width: 240px;
            top: 0;
            left: 0;
            background-color: #fff;
            border-right: 1px solid #ddd;
            padding-top: 60px;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
        }

        .navbar-brand i {
            color: red;
            margin-right: 8px;
        }

        .top-nav {
            position: fixed;
            width: 100%;
            z-index: 999;
        }

        .active {
            background-color: #f1f1f1;
        }

        .card {
            margin: 10px;
            vertical-align: top;
            min-width: 300px;
        }
    </style>
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm top-nav">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>/">
                <img src="https://cdn.vectorstock.com/i/1000v/43/22/shopping-cart-logo-design-vector-21804322.jpg" alt="Your Logo" width="32" height="32" class="d-inline-block align-text-top me-2">
                <span class="italic fw-4">E-seller</span>
            </a>
            <span class="ms-auto me-3">Welcome, <strong><?= $session->user("first_name") ?></strong></span>
            <a href="<?= BASE_URL ?>/logout" class="btn btn-sm btn-outline-danger me-3">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="text-center">
            <img src="https://cdn.vectorstock.com/i/1000v/43/22/shopping-cart-logo-design-vector-21804322.jpg" width="180" height="180">
            <div class="text-muted pt-2 fs-3">E-Seller</div>

        </a>
        <div style="overflow-y: scroll;max-height: 50vh;">
            <a href="<?= BASE_URL ?>/admin" class="<?= $route == '/admin' ? 'active' : '' ?>"><i class="fas fa-home me-2"></i> Dashboard</a>
            <a class="<?= $route == '/admin/products' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/products"><i class=" fas fa-tv me-2"></i> All Products</a>
            <a class="<?= $route == '/admin/upload-product' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/upload-product"><i class="fas fa-upload me-2"></i> Upload Product</a>
            <a class="<?= $route == '/admin/all-order' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/all-order"><i class="fas fa-film me-2"></i> All order</a>
            <a class="<?= $route == '/admin/create-discount' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/create-discount"><i class="fas fa-chart-bar me-2"></i> Create Discount</a>
            <a class="<?= $route == '/admin/profile/' . $session->user("id") ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/profile/<?= $session->user("id") ?>"><i class="fas fa-user me-2"></i> Profile</a>
            <a class="<?= $route == '/admin/settings' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/settings"><i class="fas fa-cog me-2"></i> Settings</a>
        </div>
    </div>
    <div class="main-content">
        <div class="mt-5">
            <?php echo $contents; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(() => {
            const flash = document.getElementById("flash-message");
            if (flash) {
                flash.style.transition = "opacity 0.5s ease";
                flash.style.opacity = "0";
                setTimeout(() => flash.remove(), 500);
            }
        }, 8000);
    </script>
</body>

</html>
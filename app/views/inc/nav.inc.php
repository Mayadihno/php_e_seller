<?php

use Auth\Session;
use Msc\Cart;

$session = new Session();
$cart = new Cart();

$count = $cart->getCartCount();

?>
<?php require '../app/views/inc/top.inc.php'; ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3 sticky-top shadow-sm">
    <div class="container-fluid px-3">
        <!-- Logo + Brand Name -->
        <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>/">
            <img src="https://cdn.vectorstock.com/i/1000v/43/22/shopping-cart-logo-design-vector-21804322.jpg" alt="Your Logo" width="32" height="32" class="d-inline-block align-text-top me-2">
            <span class="italic fw-4">E-seller</span>
        </a>

        <!-- Mobile toggler -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav links -->

        <div class="collapse navbar-collapse align-items-center ms-5" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0m gap-4 mt-2">
                <li class="nav-item">
                    <a class="nav-link active fw-semibold fs-6" aria-current="page" href="<?= BASE_URL ?>/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold fs-6" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold fs-6" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold fs-6" href="contact.php">Contact</a>
                </li>
                <?php if ($session->access('admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold fs-6" href="<?= BASE_URL ?>/admin">Admin</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class=" w-50 mx-auto">
                <input type="text" class="form-control" placeholder="Search for product">
            </div>


            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/cart">
                        <i class="fas fa-shopping-cart me-1"></i> Cart
                        <?php if ($count > 0): ?>
                            <span class="badge bg-success"><?= $count ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <ul class="ms-auto navbar-nav">
                    <?php if ($session->isLoggedIn()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-uppercase" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $session->user('first_name'); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/profile/<?= $session->user('id'); ?>">Profile</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/profile/edit/<?= $session->user('id'); ?>">Dashboard</a></li>
                                <div class="dropdown-divider"></div>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/login">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>

        </div>
    </div>
</nav>
<?php

use \Core\Router as Router;

$router = new Router;

// Define the routes
//url_path and controller
$router->get('/', '/home.php');
$router->post('/', '/home.php');


//auth login
$router->get('/login', '/auth/login.php');
$router->post('/login', '/auth/login.php');
$router->get('/logout', '/auth/logout.php');

//auth register
$router->get('/register', '/auth/register.php');
$router->post('/register', '/auth/register.php');

//profile
$router->get('/profile/{id}', '/profile.php');
$router->get('/profile/edit/{id}', '/profile.php');
$router->get('/profile/delete/{cat}/{id}', '/profile.php');

//admin
$router->get('/admin', '/admin/admin.php');
$router->get('/admin/upload-product', '/admin/upload_product.php');
$router->post('/admin/upload-product', '/admin/upload_product.php');
$router->get('/admin/products', '/admin/products.php');
$router->get('/admin/products/details/{id}', '/admin/products.php');
$router->get('/admin/products/delete/{id}', '/admin/products.php');
$router->get('/admin/products/edit/{id}', '/admin/products.php');
$router->post('/admin/products/edit/{id}', '/admin/products.php');

//cart
$router->get('/cart', '/cart.php');
$router->post('/cart', '/cart.php');

//shop
$router->get('/shop', '/shop.php');

//product details
$router->get('/product-details/{id}', '/product.php');
$router->post('/product-details/{id}', '/product.php');

//checkout
$router->get('/checkout', '/checkout.php');
$router->post('/checkout', '/checkout.php');

$router->get('/404', '/404.php');

$router->run();

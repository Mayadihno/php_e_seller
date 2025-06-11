<?php

use Msc\Cart;

$cart = new Cart();
$items = $cart->getCartItems();
$totalQty = 0;
$totalPrice = 0;

foreach ($items as $item) {
    $totalQty += $item['quantity'];
    $totalPrice += $item['price'] * $item['quantity'];
}

// Handle quantity update or removal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['increase'])) {
        $cart->increaseCartItem($_POST['product_id']);
        redirect('cart');
    } elseif (isset($_POST['decrease'])) {
        $cart->decreaseCartItem($_POST['product_id']);
        redirect('cart');
    } elseif (isset($_POST['remove'])) {
        $cart->removeFromCart($_POST['product_id']);
        redirect('cart');
    }
}
?>

<div class="container py-4">
    <h2 class="mb-4">Your Cart</h2>

    <?php if (empty($items)): ?>
        <div class="alert alert-warning text-center fs-4 py-5">Your cart is empty.</div>
    <?php else: ?>
        <table class="table align-middle text-center table-responsive table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <a href="<?= BASE_URL . '/product-details/' . $item['id'] ?>">
                                <img src="<?= BASE_URL . '/' . $item['image'] ?>" alt="<?= $item['name'] ?>" style="width: 60px;">
                            </a>
                        </td>
                        <td>
                            <a href="<?= BASE_URL . '/product-details/' . $item['id'] ?>">
                                <?= $item['name'] ?>
                            </a>
                        </td>
                        <td><?= formatPrice($item['price']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= formatPrice($item['price'] * $item['quantity']) ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <button type="submit" name="increase" class="btn btn-sm btn-success">+</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <button type="submit" name="decrease" class="btn btn-sm btn-warning">-</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <button type="submit" name="remove" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4>Total (<?= $totalQty ?> items): <strong><?= formatPrice($totalPrice) ?></strong></h4>
            <a href="<?= BASE_URL ?>/checkout" class="btn btn-primary text-white btn-lg">Proceed to Checkout</a>
        </div>
    <?php endif ?>
</div>
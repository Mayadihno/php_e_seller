<?php

use Msc\Cart;
use Auth\Session;


$ses = new Session();
$cart = new Cart();
$cartItems = $cart->getCartItems();
$totalQty = 0;
$totalPrice = 0;

foreach ($cartItems as $item) {
    $totalQty += $item['quantity'];
    $totalPrice += $item['price'] * $item['quantity'];
}

?>
<div class="container py-5">
    <div class="d-flex justify-content-center">
        <h2 class="fw-bold fs-2 ms-4 mb-4 text-center">Checkout</h2>
    </div>
    <div class="row">
        <div class="col-md-7">
            <form method="post">
                <?php if ($currentStep === 1): ?>

                    <?php include __DIR__ . '/checkout/address.inc.php'; ?>

                <?php elseif ($currentStep === 2): ?>

                    <?php include __DIR__ . '/checkout/dispatch.inc.php'; ?>

                <?php elseif ($currentStep === 3): ?>
                    <!-- Step 3: Payment -->
                    <h4>Review & Payment</h4>
                    <input type="hidden" name="next_step" value="3">
                    <p>Please review your order and choose a payment method.</p>
                    <div class="mb-3">
                        <select class="form-select" name="payment_method">
                            <option value="">Select Payment</option>
                            <option value="card">Card</option>
                            <option value="cash">Pay on Delivery</option>
                        </select>
                    </div>
                    <button type="submit" name="prev_step" class="btn btn-secondary">Back</button>
                    <button type="submit" class="btn btn-success">Place Order</button>
                <?php endif; ?>
            </form>
        </div>

        <!-- Right: Order Summary -->
        <div class="col-md-5">
            <div class="border rounded p-4">
                <h5 class="mb-4">Order Summary</h5>
                <?php foreach ($cartItems as $item): ?>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <div class="d-flex align-items-center">
                                <img width="40" height="40" class=" object-fit-contain me-2 rounded-circle" src="<?= BASE_URL . '/' . $item['image'] ?>" alt="">
                                <strong><?= $item['name'] ?></strong>
                            </div>
                            <small class="text-muted d-block">Qty: <?= $item['quantity'] ?></small>
                        </div>
                        <div><?= formatPrice($item['price'] * $item['quantity']) ?></div>
                    </div>
                <?php endforeach ?>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong><?= formatPrice($totalPrice) ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>
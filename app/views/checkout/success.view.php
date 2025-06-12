<!-- <?= show($orderData); ?> -->

<div class="bg-light d-flex py-5 align-items-center justify-content-center" style="min-height: 70vh;">

    <div class="card shadow-lg p-4 text-center" style="max-width: 550px; width: 100%;">
        <div class="text-success mb-3">
            <i class="fas fa-circle-check fa-3x"></i>
        </div>
        <h3 class="mb-3">Congratulations! Your order has been confirmed.</h3>
        <ul class="list-group list-group-flush mb-4">
            <li class="list-group-item"><strong>Order ID:</strong> <?= esc(substr($orderData->id, 0, 12)) ?></li>
            <li class="list-group-item"><strong>Bill Amount:</strong> <?= formatPrice($orderData->total_price) ?></li>
            <li class="list-group-item"><strong>Payment Method:</strong> <?= esc(ucfirst($orderData->payment_method)) ?></li>
        </ul>
        <p class="text-muted">Thank you for shopping with us.</p>
        <a href="<?= BASE_URL ?>/shop" class="btn btn-success text-white mt-2">Continue Shopping</a>
    </div>

</div>
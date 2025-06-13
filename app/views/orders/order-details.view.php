<?php

use Auth\Session;

$cart_items = json_decode($order->cart_items, true);
$statusColors = [
    'pending'          => 'bg-secondary',
    'processing'       => 'bg-warning text-dark',
    'shipped'          => 'bg-info text-dark',
    'out for delivery' => 'bg-primary',
    'delivered'        => 'bg-success',
    'cancelled'        => 'bg-danger'
];
$badgeClass = $statusColors[$order->order_status] ?? 'bg-dark';
$ses = new Session();
?>



<div class="container py-5">
    <div class="d-flex align-items-center">
        <a href="<?= BASE_URL ?>/order" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back</span>
        </a>
        <h2 class="ms-4 fw-bold">Order Details</h2>
    </div>

    <?= flashMessage(delete: true); ?>

    <!-- Order Summary -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Order Summary
        </div>
        <div class="card-body">
            <p><strong>Order ID:</strong> <?= esc($order->id) ?></p>
            <p><strong>Order Status:</strong>
                <span class="badge <?= $badgeClass ?>">
                    <?= ucfirst($order->order_status) ?>
                </span>
            </p>
            <p><strong>Order Date:</strong> <?= get_date($order->date_created) ?></p>
            <p><strong>Payment Method:</strong> <?= ucfirst($order->payment_method) ?></p>
            <p><strong>Dispatch Method:</strong> <?= ucfirst($order->dispatch_method) ?></p>
        </div>
    </div>

    <!-- Shipping Address -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Shipping Details
        </div>
        <div class="card-body">
            <p><strong>Address:</strong> <?= esc($order->address) ?></p>
            <p><strong>City:</strong> <?= esc($order->city) ?></p>
            <p><strong>State:</strong> <?= esc($order->state) ?></p>
            <p><strong>Zip Code:</strong> <?= esc($order->zip) ?></p>
            <p><strong>Country:</strong> <?= esc($order->country) ?></p>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            Items Ordered
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price (₦)</th>
                        <th>Quantity</th>
                        <th>Total (₦)</th>
                        <?php if ($order->order_status === 'delivered'): ?>
                            <th>Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $subtotal = 0;
                    foreach ($cart_items as $item):
                        $item_total = $item['price'] * $item['quantity'];
                        $subtotal += $item_total;
                    ?>
                        <tr>
                            <td><img src="<?= BASE_URL . '/' . $item['image'] ?>" alt="<?= $item['name'] ?>" width="60"></td>
                            <td><?= esc($item['name']) ?></td>
                            <td><?= formatPrice($item['price']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= formatPrice($item_total) ?></td>
                            <?php if ($order->order_status === 'delivered'): ?>
                                <td>
                                    <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#reviewModal"
                                        data-product-id="<?= $item['id'] ?>"
                                        data-product-name="<?= esc($item['name']) ?>">
                                        Write Review
                                    </button>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Totals -->
    <div class="card">
        <div class="card-header bg-info text-white">
            Billing Summary
        </div>
        <div class="card-body">
            <p><strong>Subtotal:</strong> <?= formatPrice($subtotal) ?></p>
            <p><strong>Dispatch Fee:</strong> <?= formatPrice($order->dispatch_price) ?></p>
            <h5><strong>Total Paid:</strong> <?= formatPrice($order->total_price) ?></h5>
        </div>
    </div>
</div>


<!-- Write Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="product_id" id="modalProductId">

                    <div class="mb-3">
                        <label for="modalProductName" class="form-label">Product</label>
                        <input type="text" name="product_name" id="modalProductName" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="reviewerName" class="form-label">Your Name</label>
                        <input type="text" value="<?= $ses->user('first_name') . ' ' . $ses->user('last_name') ?>" class="form-control" name="reviewer_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select class="form-select" name="rating" required>
                            <option value="">Select rating</option>
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Good</option>
                            <option value="3">3 - Good</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="review" class="form-label">Review</label>
                        <textarea class="form-control" name="review" rows="4" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit Review</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const reviewModal = document.getElementById('reviewModal');
    reviewModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const productId = button.getAttribute('data-product-id');
        const productName = button.getAttribute('data-product-name');

        const modalProductId = reviewModal.querySelector('#modalProductId');
        const modalProductName = reviewModal.querySelector('#modalProductName');

        modalProductId.value = productId;
        modalProductName.value = productName;
    });
</script>
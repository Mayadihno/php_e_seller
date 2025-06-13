<?php
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
?>


<div class="container pb-5">
    <div class="d-flex align-items-center">
        <a href="<?= BASE_URL ?>/admin/all-order" class="btn btn-outline-secondary">
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
                    </tr>
                </thead>
                <tbody>
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

    <!-- Change Order Status Form -->
    <?php if ($order->order_status != 'delivered'): ?>
        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label for="order_status" class="form-label"><strong>Change Order Status</strong></label>
                <select class="form-select" id="order_status" name="order_status" required>
                    <?php
                    $statuses = ['pending', 'processing', 'shipped', 'out for delivery', 'delivered', 'cancelled'];
                    foreach ($statuses as $status):
                    ?>
                        <option value="<?= $status ?>" <?= $order->order_status === $status ? 'selected' : '' ?>>
                            <?= ucfirst($status) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="order_id" value="<?= esc($order->id) ?>">
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
    <?php endif; ?>

</div>
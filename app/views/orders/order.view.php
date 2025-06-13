<div class="container mt-5">
    <h2 class="mb-4">My Orders</h2>
    <table class="table table-bordered table-hover table-responsive table-striped">
        <thead class="table-dark text-white">
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Total Price (₦)</th>
                <th>Total Quantity</th>
                <th>Payment Method</th>
                <th>Dispatch Method</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($orderData as $index => $order): ?>
                <?php
                $cart_items = json_decode($order->cart_items, true);
                $totalQty = array_sum(array_column($cart_items, 'quantity'));
                ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc(substr($order->id, 0, 12)) ?></td>
                    <td><?= formatPrice($order->total_price) ?></td>
                    <td><?= $totalQty ?></td>
                    <td><?= ucfirst($order->payment_method) ?></td>
                    <td><?= ucfirst($order->dispatch_method) ?></td>
                    <td>
                        <span class="badge 
              <?= $order->order_status === 'processing' ? 'bg-warning' : ($order->order_status === 'completed' ? 'bg-success' : 'bg-secondary') ?>">
                            <?= ucfirst($order->order_status) ?>
                        </span>
                    </td>
                    <td><?= get_date($order->date_created) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/order/details/<?= $order->id ?>" class="btn btn-sm btn-primary text-white">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
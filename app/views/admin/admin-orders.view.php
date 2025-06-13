<?php if (!empty($orderData)): ?>
    <div class="container mt-5">
        <h2 class="mb-4 text-center py-2">All Orders</h2>
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
                            <?php
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
                            <span class="badge <?= $badgeClass ?>">
                                <?= ucfirst($order->order_status) ?>
                            </span>
                        </td>
                        <td><?= get_date($order->date_created) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/all-order/details/<?= $order->id ?>" class="btn btn-sm btn-primary text-white">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="container mt-5">
        <h2 class="mb-4">My Orders</h2>
        <p class="text-center fw-bold bg-info text-white py-5">You have no orders yet.</p>
    </div>
<?php endif; ?>
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Welcome, Admin</h2>

    <!-- Summary Cards -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-2x text-primary mb-2"></i>
                    <h5 class="card-title">Total Products</h5>
                    <h3 class="fw-bold"><?= $totalProducts ?? 0 ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Total Orders</h5>
                    <h3 class="fw-bold"><?= $totalOrders ?? 0 ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">Total Users</h5>
                    <h3 class="fw-bold"><?= $totalUsers ?? 0 ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-2x text-danger mb-2"></i>
                    <h5 class="card-title">Total Reviews</h5>
                    <h3 class="fw-bold"><?= $totalReviews ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder for Chart or Recent Orders -->
    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    Sales Overview
                </div>
                <div class="card-body">
                    <!-- Chart.js or custom chart can go here -->
                    <div style="height: 300px;" class="text-muted d-flex align-items-center justify-content-center">
                        Chart placeholder
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-secondary text-white fw-bold">
                    Recent Orders
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($recentOrders ?? [] as $order): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Order #<?= $order->id ?>
                                <span class="badge bg-info"><?= ucfirst($order->order_status) ?></span>
                            </li>
                        <?php endforeach; ?>
                        <?php if (empty($recentOrders)): ?>
                            <li class="list-group-item text-muted">No recent orders.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
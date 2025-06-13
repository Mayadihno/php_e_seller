<?php

use Msc\Cart;

$cartController = new Cart();

$cartItems = $cartController->getCartItems();
$cartProductIds = array_column($cartItems, 'id');

// Toggle add/remove
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];

    // If already in cart, remove it
    if (in_array($productId, $cartProductIds)) {
        $cartController->removeFromCart($productId);
    } else {
        $product_data = [
            'id' => $productId,
            'name' => $_POST['product_name'],
            'price' => $_POST['product_price'],
            'image' => $_POST['product_image'],
        ];
        $cartController->addToCart($product_data);
    }

    redirect('product-details/' . $productId);
}

?>

<div class="container py-5">
    <div class="row">
        <!-- Image gallery -->
        <div class="col-md-6">
            <?php $image = json_decode($product->image); ?>
            <img
                id="mainImage"
                src="<?= BASE_URL ?>/<?= esc($image[0]) ?>"
                alt="Product Image"
                class="img-fluid h-50 object-fit-contain rounded border p-2 mb-3">
            <div class="d-flex gap-2 flex-wrap">
                <?php foreach ($image as $img): ?>
                    <img src="<?= BASE_URL ?>/<?= esc($img) ?>"
                        alt="Thumbnail"
                        class="thumb-img rounded"
                        width="80"
                        style="cursor: pointer"
                        onclick="document.getElementById('mainImage').src=this.src;">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h2 class="fw-bold"><?= $product->product_name ?></h2>
            <p class="text-muted mb-2">Brand: <span class="fw-semibold"><?= ucfirst($product->brand) ?></span></p>
            <p class="text-muted">SKU: <?= $product->sku ?> | Style Code: <?= $product->style_code ?></p>

            <h3 class="text-success fw-bold"><?= formatPrice($product->price) ?></h3>
            <p class="text-muted">Stock: <?= $product->stock ?> pcs available</p>
            <p class="text-warning">Rating: ⭐ <?= $product->ratings ?> / 5</p>

            <hr>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Category:</strong> <?= $product->category ?></li>
                <li class="list-group-item"><strong>Series:</strong> <?= $product->series ?></li>
                <li class="list-group-item"><strong>Color:</strong> <?= ucfirst($product->color) ?></li>
                <li class="list-group-item"><strong>Display Type:</strong> <?= $product->display_type ?: 'N/A' ?></li>
                <li class="list-group-item"><strong>Water Resistant:</strong> <?= $product->water_resistant ? 'Yes' : 'No' ?></li>
                <li class="list-group-item"><strong>Warranty:</strong> <?= $product->warranty ?> year(s)</li>
            </ul>

            <p><?= nl2br($product->description) ?></p>

            <!-- Add to Cart -->
            <form method="POST">
                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                <input type="hidden" name="product_name" value="<?= $product->product_name ?>">
                <input type="hidden" name="product_price" value="<?= $product->price ?>">
                <input type="hidden" name="product_image" value="<?= $image[0] ?>">

                <?php $inCart = in_array($product->id, $cartProductIds); ?>
                <button type="submit" name="add_to_cart" class="btn <?= $inCart ? 'btn-danger' : 'btn-dark' ?> w-100"
                    style="border-bottom-right-radius: 10px; border-bottom-left-radius: 10px;">
                    <?= $inCart ? 'Remove from Cart' : 'Add to Cart' ?>
                </button>
            </form>
        </div>
    </div>

    <?php if (!empty($reviews)): ?>
        <div class="container mt-4">
            <h4 class="mb-4 fw-bold">Product Reviews</h4>
            <div class="row">
                <?php foreach ($reviews as $review): ?>
                    <?php if (!empty($review->review)): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-lg h-100 border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="card-title mb-0"><?= esc($review->product_name) ?></h5>
                                        <small class="text-muted"><?= get_date($review->date_created) ?></small>
                                    </div>

                                    <p class="mb-2"><strong><?= esc($review->reviewer_name) ?>:</strong> <?= esc($review->review) ?></p>

                                    <div class="mb-2">
                                        <strong>Rating:</strong>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa<?= $i <= $review->rating ? 's' : 'r' ?> fa-star text-warning"></i>
                                        <?php endfor; ?>
                                        <span class="ms-2 text-muted">(<?= $review->rating ?>/5)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>


</div>
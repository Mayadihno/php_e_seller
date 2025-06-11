<div class="container">
    <div class="col">
        <h2 class="fw-bold fs-2 ms-4 mb-4 text-center">Product Details</h2>
    </div>
    <div class="card shadow-lg p-4">
        <div class="d-flex justify-content-start align-items-center pb-5">
            <span class="text-muted small"><strong>Product ID:</strong> <?= esc(substr($product->id, 0, 12)) ?></span>
            <a href="<?= BASE_URL ?>/admin/products" class=" ms-auto">
                <button class="btn btn-outline-secondary">Back</button>
            </a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php $image = json_decode($product->image); ?>
                <img
                    id="mainImage"
                    src="<?= BASE_URL ?>/<?= esc($image[0]) ?>"
                    alt="Product Image"
                    class="img-fluid h-50 rounded border p-2 mb-3">
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
            <div class="col-md-6">
                <h2 class="fw-bold"><?= esc($product->product_name) ?></h2>
                <p class="text-muted mb-1"><strong>Brand:</strong> <?= esc(ucfirst($product->brand)) ?></p>
                <p class="text-muted mb-1"><strong>Category:</strong> <?= esc($product->category) ?> | Series: <?= esc($product->series) ?></p>
                <p class="text-muted mb-1"><strong>Color:</strong> <?= esc($product->color) ?> | SKU: <?= esc($product->sku) ?></p>
                <p class="text-muted mb-1">strong>Style Code:</strong> <?= esc($product->style_code) ?></p>
                <p class="text-muted mb-1"><strong>Display:</strong> <?= $product->display_type !== 'none' ? esc($product->display_type) : 'N/A' ?></p>
                <p class="text-muted mb-1"><strong>Water Resistant:</strong> <?= $product->water_resistant == 1 ? 'Yes' : 'No' ?></p>
                <p class="text-muted mb-1"><strong>Warranty:</strong> <?= esc($product->warranty) ?> year(s)</p>

                <h4 class="text-success mt-3">₦<?= number_format($product->price, 2) ?></h4>
                <p class="text-muted"><strong>Stock:</strong> <?= esc($product->stock) ?> | <strong>Ratings</strong> ⭐ <?= esc($product->ratings) ?></p>

                <div class="mt-4">
                    <h6>Description</h6>
                    <p><?= esc($product->description) ?></p>
                </div>

                <p class="text-muted small mt-4"><strong>Date Created:</strong> <?= get_date($product->date_created) ?></p>
            </div>
        </div>
    </div>
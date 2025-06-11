<?php
$categories = json_decode(file_get_contents(__DIR__ . '/../../data/categories.json'));
?>
<div class="container py-5 d-flex align-items-center justify-content-center">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 1000px;">
        <h2 class="mb-4 text-center fw-bold">Upload New Product</h2>
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger text-center" id="flash-message">
                <?= implode('<br>', $errors['general']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="form-section">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?= oldValue('product_name') ?>" placeholder="Enter product name" />
                    <?= showError($errors, 'product_name') ?>
                </div>
                <div class="col-md-6">
                    <label for="brand" class="form-label">Brand</label>
                    <input type="text" class="form-control" id="brand" name="brand" value="<?= oldValue('brand') ?>" placeholder="e.g. AeroTech" />
                    <?= showError($errors, 'brand') ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="price" class="form-label">Price (₦)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= oldValue('price') ?>" placeholder="49.99" />
                    <?= showError($errors, 'price') ?>
                </div>
                <div class="col-md-6">
                    <label for="stock" class="form-label">Stock Quantity</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?= oldValue('stock') ?>" placeholder="150" />
                    <?= showError($errors, 'stock') ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ratings" class="form-label">Ratings</label>
                    <input type="number" step="0.1" class="form-control" id="ratings" name="ratings" value="<?= oldValue('ratings') ?>" placeholder="e.g. 4.5" />
                    <?= showError($errors, 'ratings') ?>
                </div>
                <div class="col-md-6">
                    <label for="style_code" class="form-label">Style Code</label>
                    <input type="text" class="form-control" id="style_code" name="style_code" value="<?= oldValue('style_code') ?>" placeholder="AT-EAR-21" />
                    <?= showError($errors, 'style_code') ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Select Category</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->name ?>" <?= oldSelect('category', $category->name) ?>><?= $category->name ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?= showError($errors, 'category') ?>
                </div>
                <div class="col-md-6">
                    <label for="series" class="form-label">Series</label>
                    <input type="text" class="form-control" id="series" name="series" value="<?= oldValue('series') ?>" placeholder="X2" />
                    <?= showError($errors, 'series') ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control" id="color" name="color" value="<?= oldValue('color') ?>" placeholder="Black" />
                    <?= showError($errors, 'color') ?>
                </div>
                <div class="col-md-6">
                    <label for="warranty" class="form-label">Warranty</label>
                    <input type="text" class="form-control" id="warranty" name="warranty" value="<?= oldValue('warranty') ?>" placeholder="e.g. 1 Year" />
                    <?= showError($errors, 'warranty') ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="water_resistant" class="form-label">Water Resistant</label>
                    <select class="form-select" id="water_resistant" name="water_resistant">
                        <option value="1" <?= oldSelect('water_resistant', '1') ?>>No</option>
                        <option value="2" <?= oldSelect('water_resistant', '2') ?>>Yes</option>
                    </select>
                    <?= showError($errors, 'water_resistant') ?>
                </div>
                <div class="col-md-6">
                    <label for="display_type" class="form-label">Display Type</label>
                    <input type="text" class="form-control" id="display_type" name="display_type" value="<?= oldValue('display_type') ?>" placeholder="None" />
                    <?= showError($errors, 'display_type') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter product details..."><?= oldValue('description') ?></textarea>
                <?= showError($errors, 'description') ?>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input class="form-control" type="file" id="image" name="image[]" multiple />
                <?= showError($errors, 'image') ?>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4 py-2">Upload Product</button>
            </div>
        </form>

    </div>
</div>
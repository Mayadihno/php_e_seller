<div class="">
    <div class="">
        <h2 class="fw-bold fs-2 ms-4 mb-4 text-center">All Products</h2>
    </div>
    <div class="container px-5">
        <div class="d-flex justify-content-between align-items-center mb-3 w-100">
            <nav class="navbar bg-body-tertiary" style="width: 70%;">
                <form class="w-100">
                    <div class="input-group">
                        <button class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></button>
                        <input name="find" value="<?= isset($_GET['find']) && !empty($_GET['find']) ? $_GET['find'] : '' ?>" type="text" class="form-control" placeholder="Serach" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                </form>
            </nav>
            <div class="d-flex align-items-center">
                <form method="get">
                    <select name="sort" class="form-select" aria-label=".form-select-sm example" onchange="this.form.submit()">
                        <option <?= oldSelect('sort', '') ?> value="">Filter product by</option>
                        <option <?= oldSelect('sort', 'most_popular') ?> value="most_polular"> Most Popular</option>
                        <option <?= oldSelect('sort', 'most_recent') ?> value="most_recent">Most Recent</option>
                        <option <?= oldSelect('sort', 'price_low') ?> value="price_low">Price: Low to High</option>
                        <option <?= oldSelect('sort', 'price_high') ?> value="price_high">Price: High to Low</option>
                        <option <?= oldSelect('sort', 'a_z') ?> value="a_z">A to Z</option>
                        <option <?= oldSelect('sort', 'z_a') ?> value="z_a">Z to A</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div class=" px-4">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4">
                <?php foreach ($products as $product): ?>
                    <div class="col">
                        <div class="card w-100 border-0 shadow h-100" style="border-top-right-radius: 11px; border-top-left-radius: 11px; background-color: #FAFAFA;">
                            <div class="card-img-top img-fluid position-relative">
                                <?php $images = json_decode($product->image) ?>
                                <img src="<?= BASE_URL ?>/<?= $images[0] ?>"
                                    class="w-100 object-fit-contain pt-3"
                                    style="height: 200px; border-top-right-radius: 10px; border-top-left-radius: 10px;"
                                    alt="<?= $product->product_name ?>">
                                <span class="position-absolute top-0 start-0 p-2 text-white fw-semibold fs-6"
                                    style="background-color: <?= $product->stock < 0 ? '#FF0000' : '#525252' ?>; border-top-left-radius: 10px;">
                                    <?php if ($product->stock < 0): ?>
                                        Out of Stock
                                    <?php else: ?>
                                        In Stock
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-semibold fs-6 mb-1"><?= $product->product_name ?></h5>
                                    <p class="fw-medium fs-6 mb-1"><?= $product->category ?></p>
                                </div>
                                <h3 class="fw-medium fs-6"><?= formatPrice($product->price) ?></h3>
                            </div>
                            <div class="card-footer border-0 d-flex justify-content-between align-items-center">
                                <a href="<?= BASE_URL ?>/admin/products/details/<?= $product->id ?>">
                                    <button class=" btn btn-primary w-100">
                                        View
                                    </button>
                                </a>
                                <a class="w-100 mx-3" href="<?= BASE_URL ?>/admin/products/edit/<?= $product->id ?>">
                                    <button class="btn btn-info text-white w-100">
                                        Edit
                                    </button>
                                </a>
                                <a
                                    class="w-100" href="<?= BASE_URL ?>/admin/products/delete/<?= $product->id ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteProductModal"
                                    onclick="event.preventDefault(); document.getElementById('deleteProductModalConfirm').setAttribute('href', this.href);">

                                    <button class="btn btn-danger">
                                        Delete
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../inc/pagination.inc.php'; ?>


<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="submitTestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitTestModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <!-- This is the real submission link triggered after confirmation -->
                <a id="deleteProductModalConfirm" href="#" class="btn btn-danger text-white">Yes, Delete</a>
            </div>
        </div>
    </div>
</div>
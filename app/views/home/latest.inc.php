<div class="my-5" style="padding-top: 50px;">
    <div class="product_bg">
        <div class="container position-absolute top-50 start-50 translate-middle">
            <h3 class="yel" style="width: 43%;">Go Anywhere, Pro Everything Starting At ​Just 9,999</h3>
            <h1 class="text-white fw-bolder fs-1 py-3">Save Up To 60%</h1>
            <button class="button mt-3 fw-semibold">Shop Now</button>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold fs-2 ms-4">Latest Products</h2>
            <div class="d-flex align-items-center me-5">
                <a href="" class="text-primary">
                    <span>View all</span>
                    <i class="fa-solid fa-greater-than" style="font-size: 14px;"></i>
                </a>
            </div>
        </div>
        <?php
        // $products = json_decode(file_get_contents(__DIR__ . '/../../data/products.json'));
        // $products = array_slice($products, 2, 15);
        $products = $latest
        ?>
        <?php include __DIR__ . '../../inc/product.inc.php'; ?>
    </div>
</div>
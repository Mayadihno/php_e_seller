<div class="my-5 container-fluid">
    <h2 class="fw-bold fs-2 ms-4 mb-4">Shop By Category</h2>
    <?php $categories = json_decode(file_get_contents(__DIR__ . '/../../data/categories.json')); ?>
    <div class="d-flex justify-content-between align-items-center">
        <?php foreach ($categories as $category):  ?>
            <a href="<?= BASE_URL ?>/category?<?= http_build_query(['category' => $category->name]) ?>">
                <div class="d-flex flex-column align-items-center" style="cursor: pointer">
                    <img src="<?= BASE_URL  ?>/assets/categories/<?= $category->image ?>" class="w-50" alt="<?= $category->name ?>">
                    <h5 class="fs-6"><?= $category->name ?></h5>
                </div>
            </a>
        <?php endforeach  ?>
    </div>
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold fs-2 ms-4 mb-4">Top Picks For You</h2>
            <div class="d-flex align-items-center me-5">
                <a href="" class="text-primary">
                    <span>View all</span>
                    <i class="fa-solid fa-greater-than" style="font-size: 14px;"></i>
                </a>
            </div>
        </div>
        <?php
        // $products = json_decode(file_get_contents(__DIR__ . '/../../data/products.json'));
        // $products = array_slice($products, 0, 4);
        $products = $top_pick
        ?>
        <?php include __DIR__ . '../../inc/product.inc.php'; ?>
    </div>
</div>
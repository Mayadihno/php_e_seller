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
            $product = [
                'id' => $productId,
                'name' => $_POST['product_name'],
                'price' => $_POST['product_price'],
                'image' => $_POST['product_image'],
            ];
            $cartController->addToCart($product);
        }

        redirect('category/?category=' . $slug);
    }

    ?>
 <div class="container py-5">
     <div class="">
         <h2 class="fw-bold fs-2 ms-4 mb-4 text-center">Shop Products by category</h2>
     </div>
     <div class="container px-5 pb-3">
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
     <?php include __DIR__ .  '/inc/product.inc.php'; ?>
 </div>
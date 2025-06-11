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

        redirect('');
    }

    ?>

 <div class=" px-4">
     <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
         <?php foreach ($products as $product): ?>
             <div class="col">
                 <div class="card border-0 shadow h-100" style="border-top-right-radius: 11px; border-top-left-radius: 11px; background-color: #FAFAFA;">
                     <div class="card-img-top img-fluid position-relative">
                         <?php $image = json_decode($product->image) ?>
                         <img src="<?= BASE_URL ?>/<?= $image[0] ?>""
                             class=" w-100 object-fit-contain"
                             style="height: 300px; border-top-right-radius: 10px; border-top-left-radius: 10px;"
                             alt="<?= $product->product_name ?>">
                         <span class="position-absolute top-0 start-0 p-2 text-white fw-semibold fs-6"
                             style="background-color: #525252; border-top-left-radius: 10px;">
                             Sales
                         </span>
                     </div>
                     <div class="card-body">
                         <div class="d-flex justify-content-between">
                             <h5 class="fw-semibold fs-6 mb-1"><?= $product->product_name ?></h5>
                             <p class="fw-medium fs-6 mb-1"><?= $product->category ?></p>
                         </div>
                         <h3 class="fw-medium fs-6"><?= formatPrice($product->price) ?></h3>
                     </div>
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
         <?php endforeach ?>
     </div>
 </div>
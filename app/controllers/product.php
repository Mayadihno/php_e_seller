<?php

use Core\Render;
use Msc\Product as MscProduct;

class Product extends Render
{
    public function index($id)
    {
        $product = new MscProduct();
        $prod = $product->get_product($id);

        $reviews = $product->get_product_reviews($id);

        $this->render(path: 'product-details', data: [
            'title' => "Product Details - " . $prod->product_name,
            'product' => $prod,
            'reviews' => $reviews
        ]);
    }
}

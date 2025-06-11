<?php

use Core\Render;
use Msc\Product as MscProduct;

class Product extends Render
{
    public function index($id)
    {
        $product = new MscProduct();
        $product = $product->get_product($id);

        $this->render(path: 'product-details', data: [
            'title' => "Product Details - " . $product->product_name,
            'product' => $product
        ]);
    }
}

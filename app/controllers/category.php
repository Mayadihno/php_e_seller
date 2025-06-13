<?php

use Core\Render;
use Msc\Product;

class Category extends Render
{

    public function index()
    {
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $slug = $_GET['category'];
        }

        $products = new Product();
        $product = $products->get_products_by_category($slug);

        $this->render(path: 'category', data: [
            'title' => 'Category' . ' - ' . $slug,
            'products' => $product,
            'slug' => $slug
        ]);
    }
}

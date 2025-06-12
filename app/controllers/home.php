<?php

use Core\Render;
use Msc\Product;


class Home extends Render
{
    public function index()
    {
        $product = new Product();
        $top_pick = $product->fetchAll(table: 'products', limit: 4);
        $latest = $product->fetchAll(table: 'products', limit: 8);
        $this->render(path: 'home', data: [
            'title' => 'Home',
            'top_pick' => $top_pick,
            'latest' => $latest
        ]);
    }
}

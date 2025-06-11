<?php

use Core\Render;
use Msc\Product;

class Shop extends Render
{

    public function index()
    {
        $product = new Product();
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;
        $total = $product->count_product();
        $totalPages = ceil($total / $limit);
        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
        }
        if ($offset < 0) {
            $offset = 0;
        }
        $products = [];
        $products = $product->get_all_product($limit, $offset);
        if (isset($_GET['find']) && !empty($_GET['find'])) {
            $find = '%' . $_GET['find'] . '%';
            $products = $product->query("select * from products where product_name like :find order by date_created desc limit $limit offset $offset", ['find' => $find])->fetchAll(PDO::FETCH_OBJ);
        }

        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort =  $_GET['sort'];
            switch ($sort) {
                case 'most_popular':
                    $products = $product->get_sorted_by_popularity();
                    break;
                case 'most_recent':
                    $products = $product->get_sorted_by_recent();
                    break;
                case 'price_low':
                    $products = $product->get_sorted_by_price_low();
                    break;
                case 'price_high':
                    $products = $product->get_sorted_by_price_high();
                    break;
                case 'a_z':
                    $products = $product->get_sorted_by_name_asc();
                    break;
                case 'z_a':
                    $products = $product->get_sorted_by_name_desc();
                    break;
                default:
                    $products = $product->get_all_product($limit, $offset);
            }
        }
        $this->render(path: 'shop', data: [
            'title' => 'Shop',
            'products' => $products,
            'totalPages' => $totalPages,
            'page' => $page,
            'uri' => strtok($_SERVER['REQUEST_URI'], '?')
        ]);
    }
}

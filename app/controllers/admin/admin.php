<?php

use Core\Render;

use Auth\Session;
use Msc\Product;

class Admin extends Render
{

    private function auth()
    {
        $session = new Session();
        if (!$session->isLoggedIn()) redirect('login');
        if (!$session->access('admin')) redirect('');
    }
    public function index()
    {
        $this->auth();

        $product = new Product();
        $totalProducts = $product->query('select COUNT(*) as `count` from products', [])->fetchAll(\PDO::FETCH_OBJ);
        $totalOrders = $product->query('select COUNT(*) as `count` from orders', [])->fetchAll(\PDO::FETCH_OBJ);
        $totalUsers = $product->query('select COUNT(*) as `count` from users', [])->fetchAll(\PDO::FETCH_OBJ);
        $totalReviews = $product->query('select COUNT(*) as `count` from reviews', [])->fetchAll(\PDO::FETCH_OBJ);
        $recentOrders = $product->query('select * from orders order by date_created desc limit 5', [])->fetchAll(\PDO::FETCH_OBJ);


        $this->setLayout('admin');
        $this->render(path: 'admin.admin', data: [
            'title' => 'Admin',
            'totalProducts' => $totalProducts[0]->count,
            'totalOrders' => $totalOrders[0]->count,
            'totalUsers' => $totalUsers[0]->count,
            'totalReviews' => $totalReviews[0]->count,
            'recentOrders' => $recentOrders
        ]);
    }
}

<?php

use Core\Render;
use Auth\Session;
use Msc\Product;
use Core\Validator;

class Products extends Render
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

        $this->setLayout('admin');
        $this->render(path: 'admin.products', data: [
            'title' => 'Products',
            'products' => $products,
            'totalPages' => $totalPages,
            'page' => $page,
            'uri' => strtok($_SERVER['REQUEST_URI'], '?')

        ]);
    }

    public function details($id)
    {
        $this->auth();
        $product = new Product();
        $product = $product->get_product($id);

        $this->setLayout('admin');
        $this->render(path: 'admin/product-details', data: [
            'title' => 'Products Details - ' . $product->product_name,
            'product' => $product
        ]);
    }

    public function edit($id)
    {
        $errors = [];
        $this->auth();
        $product = new Product();
        $product = $product->get_product($id);

        if (isset($_POST) && !empty($_POST)) {
            $val = new Validator($_POST);
            $val->setRules([
                'product_name' => ['Product Name', ['required', 'min:3', 'max:50', 'alpha_numeric',]],
                'brand' => ['Brand Name', ['required', 'min:3', 'max:20', 'alpha_numeric',]],
                'price' => ['Product Price', ['required', 'is_numeric']],
                'stock' => ['Product Stock', ['required', 'numeric']],
                'ratings' => ["Rating", ['required',  'min:1', 'max:5', 'no_space', 'is_numeric']],
                'style_code' => ["Style Code", ['required']],
                'category' => ["Category", ['required', 'alpha']],
                'description' => ["Description", ['required']],
                'series' => ["Series", ['required', 'alpha_numeric']],
                'color' => ["Color", ['required', 'no_space', 'alpha_numeric']],
                'display_type' => ["Display Type", ['required', 'alpha_numeric']],
                'warranty' => ["Warranty", ['required', 'alpha_numeric']],
                'water_resistant' => ["Water Resistant", ['required', 'numeric']],
            ]);

            if ($val->has_error()) {
                $errors = $val->errors;
            } else {
                $product = new Product();
                $product->update_product_by_id($id, $_POST);
                flashMessage(mode: 'success', msg: 'Product updated successfully.');
                redirect('admin/products/edit/' . $id);
            }
        }

        $this->setLayout('admin');
        $this->render(path: 'admin/edit-product', data: [
            'title' => 'Products Edit - ' . $product->product_name,
            'product' => $product,
            'errors' => $errors

        ]);
    }
    public function delete($id)
    {
        $this->auth();
        $product = new Product();
        $product->delete_product($id);
        redirect('admin/products');
    }
}

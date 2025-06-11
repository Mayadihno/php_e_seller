<?php

use Core\Render;
use Auth\Session;
use Core\Validator;
use Msc\Product;

class UploadProduct extends Render
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
        $errors = [];
        $this->setLayout('admin');
        $this->render(path: 'admin.upload_product', data: [
            'title' => 'Uplaod Product',
            'errors' => $errors
        ]);
    }

    public function upload_product()
    {
        $this->auth();
        $errors = [];
        if (!empty($_POST) && !empty($_FILES)) {
            $val = new Validator(array_merge($_POST, $_FILES));
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
                'image' => ["Image", ['image']],
            ]);

            if ($val->has_error()) {
                $errors = $val->errors;
            } else {
                $myImage = upload_multiple_image($_FILES);
                if ($myImage) {
                    $_POST['image'] = json_encode($myImage);
                }
                $product = new Product();
                if ($product->create($_POST)) {
                    flashMessage(mode: 'success', msg: 'Product uploaded successfully.');
                    redirect('admin');
                } else {
                    $errors['general'] = ['An error occurred while creating the product. Please try again later.'];
                }
            }
        }
        $this->setLayout('admin');
        $this->render(path: 'admin.upload_product', data: [
            'title' => 'Uplaod Product',
            'errors' => $errors
        ]);
    }
}

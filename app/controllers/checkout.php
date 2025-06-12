<?php

use Core\Render;
use Auth\Session;
use Auth\User;
use Core\Validator;
use Msc\Orders;

class Checkout extends Render
{
    public function index()
    {;
        $errors = [];
        $session = new Session();
        if (!$session->isLoggedIn()) {
            redirect('login');
        }
        $user_id = $session->user('id');
        $user = new User();
        $country = $user->query('select country from country where id in (select country_id from users where id= :id)', ['id' => $user_id])->fetch(\PDO::FETCH_OBJ);

        $currentStep = $session->get('step') ?? 1;
        if (isset($_POST['next_step'])) {
            if ($_POST['next_step'] == '1') {
                $validator = new Validator($_POST);
                $validator->setRules([
                    'address' => ['Address', ['required']],
                    'city' => ['City', ['required']],
                    'state' => ['State', ['required']],
                    'zip' => ['Zip Code', ['required']],
                ]);
                if ($validator->has_error()) {
                    $errors = $validator->errors;
                } else {
                    $session->set_many('checkout_data', [
                        'address' => $_POST['address'],
                        'city' => $_POST['city'],
                        'state' => $_POST['state'],
                        'zip' => $_POST['zip'],
                        'country' => $country->country,
                        'users_id' =>  $user_id
                    ]);
                    $session->set('step', 2);
                    redirect('checkout');
                }
            }
            if ($_POST['next_step'] == '2') {
                $session->set_many(
                    'checkout_data',
                    ['dispatch_method' => $_POST['dispatch_method'],]
                );
                $checkout = $session->get('checkout_data') ?? [];
                if ($checkout['dispatch_method'] == 'standard') {
                    $session->set('dispatch_price', '8000');
                } elseif ($checkout['dispatch_method'] == 'express') {
                    $session->set('dispatch_price', '12000');
                }
                $session->set('step', 3);
                if (isset($_POST['prev_step'])) {
                    $session->set('step', $currentStep - 1);
                    $currentStep = $session->get('step');
                    redirect('checkout');
                }
                redirect('checkout');
            }
            if ($_POST['next_step'] == '3') {
                $session->set_many('checkout_data', [
                    'payment_method' => $_POST['payment_method'],
                    'cart_items' => array_values($session->get('cart')),
                    'dispatch_price' => $session->get('dispatch_price'),
                    'total_price' => $session->get('totalPrice'),
                ]);
                $data = $session->get('checkout_data') ?? [];
                $orders = new Orders();
                $orderId =  $orders->create($data);

                if (isset($_POST['prev_step'])) {
                    $session->set('step', $currentStep - 1);
                    $currentStep = $session->get('step');
                    redirect('checkout');
                }

                if ($orderId) {
                    $session->remove('cart');
                    $session->remove('totalPrice');
                    $session->remove('dispatch_price');
                    $session->remove('checkout_data');
                    $session->remove('step');
                    $currentStep = 0;
                }
                redirect('checkout/success?order_id=' . $orderId);
            }
        }

        if (isset($_POST['prev_step'])) {
            $session->set('step', $currentStep - 1);
            $currentStep = $session->get('step');
            redirect('checkout');
        }

        $this->render(path: 'checkout', data: [
            'title' => 'Checkout',
            'errors' => $errors,
            'country' => $country,
            'currentStep' => $currentStep,
            'dispatch_price' => $session->get('dispatch_price')
        ]);
    }

    public function success()
    {
        $orderId = '';
        if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
            $orderId = $_GET['order_id'];
        }

        $order = new Orders();
        $orderData = $order->fetch('orders', ['id' => $orderId]);


        $this->render(path: 'checkout/success', data: [
            'title' => 'Payment Success',
            'orderData' => $orderData
        ]);
    }
}

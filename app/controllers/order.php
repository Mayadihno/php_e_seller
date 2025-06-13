<?php

use Auth\Session;
use Core\Render;
use Msc\Orders;

class Order extends Render
{

    public function index()
    {
        $session = new Session();
        $user_id = $session->user('id');

        $orders = new Orders();
        $orderData = $orders->get_orders_by_user_id($user_id);


        $this->render(path: 'orders/order', data: [
            'title' => 'Order',
            'orderData' => $orderData
        ]);
    }

    public function details($id)
    {
        $orders = new Orders();
        $orderData = $orders->get_order_by_id($id);

        if (!empty($_POST)) {
            $_POST['date_created'] = date('Y-m-d H:i:s');
            $orders->insert(table: 'reviews', data: $_POST);
            flashMessage('Review submitted successfully', 'success');
            redirect('order/details/' . $id);
        }
        $this->render(path: 'orders/order-details', data: [
            'title' => 'Order-Details',
            'order' => $orderData
        ]);
    }
}

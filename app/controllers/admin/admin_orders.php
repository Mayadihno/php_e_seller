<?php


use Core\Render;
use Auth\Session;
use Msc\Orders;

class AdminOrders extends Render
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

        $order = new Orders();
        $orders = $order->fetchAll('orders');

        $this->setLayout('admin');
        $this->render(path: 'admin.admin-orders', data: [
            'title' => 'Admin Orders',
            'orderData' => $orders

        ]);
    }

    public function details($id)
    {

        $this->auth();
        $order = new Orders();
        $orderData = $order->get_order_by_id($id);

        if (!empty($_POST) && isset($_POST['order_status']) && isset($_POST['order_id'])) {

            $order = $order->update(table: 'orders', data: ['order_status' => $_POST['order_status']], where: 'id = :id', whereParams: ['id' => $_POST['order_id']]);
            if ($order) {
                flashMessage('Order status updated successfully', 'success');
                redirect('admin/all-order/details/' . $_POST['order_id']);
            }
        }

        $this->setLayout('admin');
        $this->render(path: 'admin.admin-order-details', data: [
            'title' => 'Order-Details',
            'order' => $orderData
        ]);
    }
}

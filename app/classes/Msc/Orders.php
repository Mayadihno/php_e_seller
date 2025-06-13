<?php

namespace Msc;

use Core\Database;

class Orders extends Database
{

    protected $allowedInsertColumns = [
        'city',
        'address',
        'state',
        'zip',
        'country',
        'users_id',
        'dispatch_method',
        'payment_method',
        'total_price',
        'cart_items',
        'dispatch_price'
    ];
    protected $beforeInsert = [
        'make_order_id',
        'encode_cart_items'
    ];

    public function create(array $data)
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->allowedInsertColumns)) {
                unset($data[$key]);
            }
        }

        $data['date_created'] = date('Y-m-d H:i:s');

        //run this before insert to db
        if (property_exists($this, 'beforeInsert')) {
            foreach ($this->beforeInsert as $func) {
                $data = $this->$func($data);
            }
        }
        $orderId = $data['id'] ?? null;
        $this->insert('orders', $data);
        return $orderId;
    }

    public function get_orders_by_user_id($id)
    {
        $result = $this->fetchByValue(table: 'orders', data: ['users_id' => $id], where: 'users_id = :users_id', mode: 'all');
        return $result;
    }

    public function get_order_by_id($id)
    {
        $result = $this->fetch(table: 'orders', data: ['id' => $id]);
        return $result;
    }

    public function make_order_id($data)
    {
        $data['id'] = make_uniqueid();
        return $data;
    }
    public function encode_cart_items($data)
    {
        $data['cart_items'] = json_encode($data['cart_items']);
        return $data;
    }
}

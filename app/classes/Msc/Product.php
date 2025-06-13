<?php

namespace Msc;

use Core\Database;

class Product extends Database
{

    protected $allowedInsertColumns = [
        'product_name',
        'brand',
        'price',
        'stock',
        'ratings',
        'description',
        'image',
        'category',
        'style_code',
        'series',
        'color',
        'display_type',
        'warranty',
        'water_resistant',
    ];

    protected $allowedUpdateColumns = [
        'product_name',
        'brand',
        'price',
        'stock',
        'ratings',
        'description',
        'category',
        'style_code',
        'series',
        'color',
        'display_type',
        'warranty',
        'water_resistant',
    ];
    protected $beforeInsert = [
        'make_product_id',
        'make_sku'
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
        return $this->insert('products', $data);
    }

    public function count_product()
    {
        return $this->count_data('products');
    }

    public function update_product_by_id($id, array $data)
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->allowedUpdateColumns)) {
                unset($data[$key]);
            }
        }
        return  $this->update('products', $data, 'id = :id', ['id' => $id]);
    }

    public function get_all_product($limit, $offset)
    {
        return $this->fetchAll(table: 'products', limit: $limit, offset: $offset);
    }

    function get_product($id)
    {
        return $this->fetch('products', ['id' => $id]);
    }

    function delete_product($id)
    {
        $this->delete('products', 'id = :id', ['id' => $id]);
    }

    function get_sorted_by_popularity()
    {
        return $this->query('select * from products order by ratings desc', [])->fetchAll(\PDO::FETCH_OBJ);
    }
    function get_sorted_by_recent()
    {
        return $this->query('select * from products order by date_created desc', [])->fetchAll(\PDO::FETCH_OBJ);
    }
    function get_sorted_by_price_low()
    {
        return $this->query('select * from products order by price asc', [])->fetchAll(\PDO::FETCH_OBJ);
    }
    function get_sorted_by_price_high()
    {
        return $this->query('select * from products order by price desc', [])->fetchAll(\PDO::FETCH_OBJ);
    }
    function get_sorted_by_name_asc()
    {
        return $this->query('select * from products order by product_name asc', [])->fetchAll(\PDO::FETCH_OBJ);
    }
    function get_sorted_by_name_desc()
    {
        return $this->query('select * from products order by product_name desc', [])->fetchAll(\PDO::FETCH_OBJ);
    }

    public function make_product_id($data)
    {
        $data['id'] = make_uniqueid();
        return $data;
    }
    public function make_sku($data)
    {
        $data['sku'] = generateSKU();
        return $data;
    }

    function get_product_reviews($id)
    {
        return $this->query('select * from reviews where product_id = :product_id', ['product_id' => $id])->fetchAll(\PDO::FETCH_OBJ);
    }
}

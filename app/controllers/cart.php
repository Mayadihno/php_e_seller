<?php

use Core\Render;

class Cart extends Render
{
    public function index()
    {

        $this->render(path: 'cart', data: [
            'title' => 'Cart'
        ]);
    }
}

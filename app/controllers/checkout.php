<?php

use Core\Render;
use Auth\Session;

class Checkout extends Render
{
    public function index()
    {
        $session = new Session();
        if (!$session->isLoggedIn()) {
            redirect('login');
        }

        $this->render(path: 'checkout', data: [
            'title' => 'Checkout'
        ]);
    }
}

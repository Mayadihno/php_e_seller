<?php

use Core\Render;

use Auth\Session;

class Admin extends Render
{
    public function index()
    {
        $session = new Session();
        if (!$session->isLoggedIn()) redirect('login');
        if (!$session->access('admin')) redirect('');
        $this->setLayout('admin');
        $this->render(path: 'admin.admin', data: [
            'title' => 'Admin'
        ]);
    }
}

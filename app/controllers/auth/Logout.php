<?php

use Auth\Session;

class Logout
{
    public function index()
    {
        $session = new Session();
        $session->logout();
        redirect('login');
    }
}

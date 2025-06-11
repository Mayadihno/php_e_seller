<?php

use Core\Render;
use Auth\Session;

class Profile extends Render
{
    public function index($id)
    {
        $session = new Session();
        if (!$session->isLoggedIn()) {
            redirect('login');
        }

        $this->render(path: 'profile', data: [
            'title' => 'Profile'
        ]);
    }

    public function edit($id)
    {
        show($id);
        show('Hello World from profile edit page');
    }
}

<?php

use Core\Render;
use Core\Validator;
use Auth\User;
use Auth\Session;

class Login extends Render
{
    public function index()
    {
        $errors = [];
        $session = new Session();
        if (!empty($_POST)) {
            $val = new Validator($_POST);
            $val->setRules([
                'email' => ['required', 'email'],
                'password' => ['required', 'min:6', 'max:20', 'no_space'],
            ]);

            if ($val->has_error()) {
                $errors = $val->errors;
            } else {
                $user = new User();
                if ($user = $user->login($_POST)) {
                    unset($user->password);

                    $session->auth($user);
                    flashMessage(mode: 'success', msg: 'You have successfully logged in.');
                    redirect('');
                } else {
                    $errors['general'] = ['Invalid email or password. Please try again.'];
                }
            }
        }
        $this->render(path: 'auth/login', useLayout: false, data: [
            'errors' => $errors ?? [],
        ]);
    }
}

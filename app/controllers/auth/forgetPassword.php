<?php

use Core\Render;
use Core\Validator;
use Auth\User;

class ForgetPassword extends Render
{

    public function index()
    {
        $errors = [];
        if (!empty($_POST) && isset($_POST['email'])) {
            $val = new Validator($_POST);
            $val->setRules([
                'email' => ['required', 'email'],
            ]);
            if ($val->has_error()) {
                $errors = $val->errors;
            } else {
                $user = new User();
                $res =  $user->fetchByValue(table: 'users', where: 'email = :email', data: ['email' => $_POST['email']]);
                if ($res) {
                    // $token = $user->make_token($res->id);
                    // $user->update_user_by_id($res->id, ['token' => $token]);
                    // $user->send_email($res->email, $token);
                    // flashMessage(mode: 'success', msg: 'Please check your email to reset your password.');
                } else {
                    flashMessage(mode: 'danger', msg: 'Email not found.');
                    $errors['general'] = ["User Email ({$_POST['email']}) not found."];
                }
            }
        }
        $this->render(path: 'auth/forget-password', useLayout: false, data: [
            'title' => 'Forget Password',
            'errors' => $errors
        ]);
    }
}

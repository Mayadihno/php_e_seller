<?php

use Core\Render;
use Core\Validator;
use Auth\User;

class ResetPassword extends Render
{
    public function index()
    {
        $errors = [];
        $token = $_GET['token'] ?? '';

        if (!$token) {
            flashMessage('danger', 'Invalid or missing token.');
            redirect('forget-password');
            return;
        }

        $user = new User();
        $res = $user->fetchByValue(
            table: 'users',
            where: 'reset_token = :token',
            data: ['token' => $token]
        );

        if (!$res || strtotime($res->reset_expires) < time()) {
            flashMessage('danger', 'Token expired or invalid.');
            redirect('forget-password');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $val = new Validator($_POST);
            $val->setRules([
                'password' => ['required', 'min:6', 'max:20', 'no_space', ['match:confirm_password', "Passwords do not match."]],
                'confirm_password' => ["Confirm Password", ['required', 'min:6', 'max:20', 'no_space', ['match:password', "Confirm Password and password do not match."]]],
            ]);

            if ($val->has_error()) {
                $errors = $val->errors;
            } else {
                $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $user->update_user_by_id($res->id, [
                    'password' => $hashed,
                    'reset_token' => null,
                    'reset_expires' => null,
                ]);
                flashMessage('success', 'Password successfully reset. You can now login.');
                redirect('login');
                return;
            }
        }

        $this->render(path: 'auth/reset-password', useLayout: false, data: [
            'title' => 'Reset Password',
            'errors' => $errors,
            'token' => $token,
        ]);
    }
}

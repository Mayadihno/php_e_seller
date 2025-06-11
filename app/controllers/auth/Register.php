<?php

use Core\Render;
use Core\Validator;
use Auth\User;

class Register extends Render
{

    public function index()
    {
        $errors = [];

        if (!empty($_POST)) {
            $val = new Validator($_POST);
            $val->setRules([
                'first_name' => [
                    "name" => "First Name",
                    'rules' => [
                        ['rule' => 'required', 'error_message' => 'Please enter your first name.'],
                        ['min:3', 'Please First name must be at least 3 characters long.'],
                        ['max:30', 'First name cannot exceed 30 characters.'],
                        'max:30',
                        'alpha',
                        'no_space'
                    ]
                ],
                'last_name' => ['Surname', ['required', 'min:3', 'max:30', 'alpha', 'no_space']],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:6', 'max:20', 'no_space', ['match:confirm_password', "Passwords do not match."]],
                'confirm_password' => ["Confirm Password", ['required', 'min:6', 'max:20', 'no_space', ['match:password', "Confirm Password and password do not match."]]],
                'phone' => ["Phone Number", ['required',  'min:10', 'max:20', 'no_space']],
                'gender' => ['required', 'no_space'],
                'country_id' => ["Country", ['required', 'no_space']],
            ]);


            if ($val->has_error()) {
                $errors = $val->errors;
            } else {
                $user = new User();
                if ($user->create($_POST)) {
                    flashMessage(mode: 'success', msg: 'Your account has been created successfully. You can now login.');
                    redirect('login');
                } else {
                    $errors['general'] = ['An error occurred while creating your account. Please try again later.'];
                }
            }
        }

        $countries = get_countries();

        $view = new Render();
        $view->render(path: 'auth/register', useLayout: false, data: [
            'errors' => $errors ?? [],
            'countries' => $countries ?? [],
        ]);
    }
}

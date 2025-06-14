<?php

use Core\Render;
use Auth\Session;
use Auth\User;
use Core\Validator;


class Profile extends Render
{
    public function index($id)
    {
        $session = new Session();
        if (!$session->isLoggedIn()) {
            redirect('login');
        }

        $user = new User();
        $user_data = $user->fetch('users', ['id' => $id]);
        unset($user_data->password);
        $country = $user->fetch('country', ['id' => $user_data->country_id]);
        $this->render(path: 'profile', data: ['title' => "Profile " . " - " . $user_data->first_name, 'user' => $user_data, 'country' => $country->country]);

        $this->render(path: 'profile', data: [
            'title' => 'Profile'
        ]);
    }

    public function edit($id)
    {
        $session = new Session();
        if (!$session->isLoggedIn()) {
            redirect('login');
        }
        $errors = [];
        $user = new User();
        $session = new Session();
        $user_data = $user->fetch('users', ['id' => $id]);
        $country = $user->fetch('country', ['id' => $user_data->country_id]);
        $countries = get_countries();

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
                'password' => ['required', 'min:6', 'max:20', 'no_space'],
                'phone' => ["Phone Number", ['required',  'min:10', 'max:20', 'no_space']],
                'gender' => ['required', 'no_space'],
                'country_id' => ["Country", ['required', 'no_space']],
            ]);
            if ($val->has_error()) {
                $errors = $val->errors;
            } else {
                if (password_verify($_POST['password'], $user_data->password)) {
                    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
                        $my_image = upload_images($_FILES);
                        $_POST['image'] = $my_image;
                    }
                    if ($user->update_user_by_id($id, $_POST)) {
                        flashMessage(mode: 'success', msg: 'Your profile has been updated.');
                        $updatedUser = $user->fetch('users', ['id' => $id]);
                        unset($updatedUser->password);
                        $session->auth($updatedUser);
                        redirect('profile/edit/' . $id);
                    } else {
                        $errors['general'] = ['An error occurred while creating your account. Please try again later.'];
                    }
                } else {
                    $errors['password_incorrect'] = ['Incorrect password. Please try again'];
                }
            }
        }
        unset($user_data->password);
        $this->render(path: 'edit-profile', data: [
            'title' => "Profile " . " - " . $user_data->first_name,
            'user' => $user_data,
            'country' => $country->country,
            'countries' => $countries,
            'country_id' => $user_data->country_id,
            'errors' => $errors
        ]);
    }
}

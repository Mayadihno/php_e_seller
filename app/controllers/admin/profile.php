<?php

use Core\Render;
use Auth\User;

class Profile extends Render
{

    public function index($id)
    {
        $user = new User();
        $user_data = $user->fetch('users', ['id' => $id]);
        unset($user_data->password);
        $country = $user->fetch('country', ['id' => $user_data->country_id]);
        $this->setLayout('admin');
        $this->render(path: 'admin/profile', data: ['title' => "Profile " . " - " . $user_data->first_name, 'user' => $user_data, 'country' => $country->country]);
    }

    public function edit($id)
    {
        $user = new User();
        $user_data = $user->fetch('users', ['id' => $id]);
        unset($user_data->password);
        $country = $user->fetch('country', ['id' => $user_data->country_id]);
        $countries = get_countries();

        if ($_POST || $_FILES) {
        }
        $this->setLayout('admin');
        $this->render(path: 'admin/edit-profile', data: [
            'title' => "Profile " . " - " . $user_data->first_name,
            'user' => $user_data,
            'country' => $country->country,
            'countries' => $countries,
            'country_id' => $user_data->country_id
        ]);
    }
}

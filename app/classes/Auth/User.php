<?php

namespace Auth;

use Core\Database;


class User extends Database
{
    protected $allowedInsertColumns = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'password',
        'phone',
        'country_id',
        'date_created',
    ];

    protected $allowedUpdateColumns = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'image',
        'gender',
        'password',
        'country_id',
        'image',
        'reset_token',
        'reset_expires',
    ];
    protected $beforeInsert = [
        'make_user_id',
    ];

    public function create(array $data)
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->allowedInsertColumns)) {
                unset($data[$key]);
            }
        }
        $data['date_created'] = date('Y-m-d H:i:s');
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        //run this before insert to db
        if (property_exists($this, 'beforeInsert')) {
            foreach ($this->beforeInsert as $func) {
                $data = $this->$func($data);
            }
        }
        return $this->insert('users', $data);
    }

    public function login(array $data)
    {
        $data['email'] = trim($data['email']);
        $data['password'] = trim($data['password']);

        if (empty($data['email']) || empty($data['password'])) {
            return false;
        }

        $user = $this->fetchByValue('users', ['email' => $data['email']], 'email = :email');
        if ($user && password_verify($data['password'], $user->password)) {
            return $user;
        }
        return false;
    }

    public function update_user_by_id($id, array $data)
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->allowedUpdateColumns)) {
                unset($data[$key]);
            }
        }
        return  $this->update('users', $data, 'id = :id', ['id' => $id]);
    }

    public function make_user_id($data)
    {
        $data['id'] = make_uniqueid();
        return $data;
    }
}

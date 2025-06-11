<?php

namespace Auth;

class Session
{

    protected $userKey = UNIQUE_KEY;

    public function __construct()
    {
        if (empty(session_id())) {
            session_start();
        }
    }
    public function set($key, $value)
    {
        $_SESSION[$this->userKey][$key] = $value;
    }

    public function get(string $key)
    {
        if (!empty($_SESSION[$this->userKey][$key])) {
            return $_SESSION[$this->userKey][$key];
        }
        return null;
    }

    public function remove(string $key)
    {
        if (!empty($_SESSION[$this->userKey][$key])) {
            $data = $_SESSION[$this->userKey][$key];
            unset($_SESSION[$this->userKey][$key]);
            return $data;
        }
        return false;
    }

    public function auth(object|array $row)
    {
        $_SESSION[$this->userKey]["USER" . $this->userKey] = $row;

        return true;
    }

    public function destroy()
    {
        session_regenerate_id();
        session_destroy();
    }

    public function user(?string $key = null): array|object|string
    {
        if (!empty($_SESSION[$this->userKey]['USER' . $this->userKey])) {
            if (empty($key))
                return $_SESSION[$this->userKey]['USER' . $this->userKey];

            $data = (array)$_SESSION[$this->userKey]['USER' . $this->userKey];
            if (!empty($data[$key]))
                return $data[$key];
        }

        return '';
    }

    public function isLoggedIn(): bool
    {
        if (!empty($_SESSION[$this->userKey]['USER' . $this->userKey]))
            return true;

        return false;
    }



    public function logout()
    {
        if (!empty($_SESSION[$this->userKey]['USER' . $this->userKey]))
            unset($_SESSION[$this->userKey]['USER' . $this->userKey]);

        $this->destroy();
    }
    public static function __callStatic($name, $arguments)
    {
        $prop = strtolower(str_replace('get', '', $name));
        if (isset($_SESSION[UNIQUE_KEY]['USER' . UNIQUE_KEY]->$prop)) {
            return $_SESSION[UNIQUE_KEY]['USER' . UNIQUE_KEY]->$prop;
        }
        return 'Unknown';
    }
    public function access(string $requiredRole = 'user'): bool
    {
        $sessionKey = 'USER' . UNIQUE_KEY;

        if (!isset($_SESSION[UNIQUE_KEY][$sessionKey])) {
            return false;
        }

        $currentUser = $_SESSION[UNIQUE_KEY][$sessionKey];

        if (!isset($currentUser->role)) {
            return false;
        }

        $role = $currentUser->role;

        $roleHierarchy = [
            'super-admin' => ['super-admin', 'admin', 'seller', 'user'],
            'admin'       => ['admin', 'seller', 'user'],
            'seller'      => ['seller', 'user'],
            'user'        => ['user'],
        ];

        return isset($roleHierarchy[$role]) && in_array($requiredRole, $roleHierarchy[$role]);
    }
}

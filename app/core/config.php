<?php

if (PHP_SAPI !== 'cli') {
    define('BASE_URL', get_baseUrl());
}


define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'e_seller');
define('DB_USER', 'root');
define('DB_PASS', '');

define('UNIQUE_KEY', 'ekwrjefsdkj');
define('RANDOM', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');

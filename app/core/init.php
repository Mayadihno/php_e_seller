<?php
function get_baseUrl()
{
    $host = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
    $serverName = $_SERVER['HTTP_HOST'];
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    $baseUrl = $host . '://' . $serverName . $scriptName;
    return $baseUrl;
}

require 'config.php';
require 'helpers.php';
require 'routes.php';

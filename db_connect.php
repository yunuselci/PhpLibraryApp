<?php
session_start();
require 'vendor/autoload.php';
include_once 'user.php';
include_once 'book.php';
$errors = [];
function redirect($url)
{
    header("Location: $url");
}
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$db_host = getenv('db_host');
$db_name = getenv('db_name');
$db_user = getenv('db_user');
$db_pass = getenv('db_pass');


try {
    $db_connect = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_pass);
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    array_push($errors, $exception->getMessage());
}
$user = new User($db_connect);
$book = new Book($db_connect);

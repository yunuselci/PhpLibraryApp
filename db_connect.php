<?php
session_start();

include_once 'user.php';
include_once 'book.php';
$errors = [];

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'intern_2';

try {
    $db_connect = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_pass);
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    array_push($errors, $exception->getMessage());
}
$user = new User($db_connect);
$book = new Book($db_connect);

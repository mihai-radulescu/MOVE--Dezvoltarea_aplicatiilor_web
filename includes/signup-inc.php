<?php
require_once 'db_config.php';
require_once 'functions.php';

if(isset($_POST["submit"])){
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeatPassword"];

    userCreate($conn, $name, $email, $phone, $username, $password, $repeatPassword);
}
else {
    header("location: ../signup.php");
    exit();
}
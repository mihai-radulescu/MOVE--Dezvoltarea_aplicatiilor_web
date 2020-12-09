<?php
require_once 'db_config.php';
require_once 'functions.php';

session_start();

if(isset($_POST["orderSubmit"]) && $_POST["addressid"] > 0){
    $userid = $_SESSION["userid"];

    $addressid = $_POST["addressid"];
    $clientName = $_POST["clientName"];
    $clientPhone = $_POST["clientPhone"];
    $clientEmail = $_POST["clientEmail"];
    $clientStreet = $_POST["clientStreet"];
    $weight = $_POST["weight"];

    placeOrder($conn, $userid, $addressid, $clientName, $clientPhone, $clientEmail, $clientStreet, $weight);
}else{
    header("location: ../order-form.php");
    exit();
}
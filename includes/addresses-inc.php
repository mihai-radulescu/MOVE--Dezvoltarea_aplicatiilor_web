<?php

require_once 'db_config.php';
require_once 'functions.php';

session_start();

if(isset($_POST["addAddress"])){

    $userid = $_SESSION["userid"];

    $country = $_POST["country"];
    $region = $_POST["region"];
    $city = $_POST["city"];
    $street = $_POST["street"];

    addAddress($conn, $userid, $country, $region, $city, $street);
}
else 
    if(isset($_POST["delAddress"])){
        $userid = $_SESSION["userid"];

        $addressid = $_POST["addressid"];
        delAddress($conn, $addressid, $userid);
}
else 
    if(isset($_POST["updateAddressButton"])){
        //echo "<script>console.log('update')</script>";

    $userid = $_SESSION["userid"];

    $addressid = $_POST["addressid"];
    $country = $_POST["country"];
    $region = $_POST["region"];
    $city = $_POST["city"];
    $street = $_POST["street"];

    updateAddress($conn, $userid, $addressid, $country, $region, $city, $street);
}
else{
    header("location: ../address-form.php");
    exit();
}

<?php
require_once 'db_config.php';
require_once 'functions.php';
    
    $country = $_REQUEST["country"];
    $region = $_REQUEST["region"];
    $city = $_REQUEST["city"];
    $street = $_REQUEST["street"];

    /*
    $country = $_POST["country"];
    $region = $_POST["region"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    */

    addAddress($conn, $country, $region, $city, $street);


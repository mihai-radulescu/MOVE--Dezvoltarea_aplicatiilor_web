<?php
require_once "functions.php";
require_once "db_config.php";
session_start();

if(isset($_POST["courier"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $userExists = userExists($conn, $username, $username);

    $pwdHashed = $userExists["password"];
    $checkPwd = password_verify($password, $pwdHashed);

    if($checkPwd === true && $userExists["userId"] === $_SESSION["userid"]){

        $weight = $_POST["weight"];
        $country = $_POST["country"];
        $region = $_POST["region"];
        $city = $_POST["city"];

        //Adaug datele curierului
        $sql = "INSERT INTO courier (userId, weight, country, region, city ) VALUES (?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
    
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iisss", $userExists["userId"], $weight, $country, $region, $city);
        mysqli_stmt_execute($stmt); 

        mysqli_stmt_close($stmt);

        //Schimb roulul utilizatirului

        $sql = "UPDATE user SET userRole = ? WHERE userId = ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $userRole = "courier";

        mysqli_stmt_bind_param($stmt, "si", $userRole, $userExists["userId"]);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        session_unset();
        session_destroy();
        
        header("location: ../login.php");
        exit();

    }
}
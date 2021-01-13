<?php

require_once 'db_config.php';
require_once 'functions.php';

if(isset($_POST["cancel"])){
    $orderid = $_POST["orderid"];

    //update staus log
    $sql = "UPDATE statuslog SET accepted = NULL, pickedUp = NULL, delivered = NULL, canceled = NULL WHERE orderId = ?;";

    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $orderid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    //update courier
    $sql = "UPDATE courier SET orderId = NULL WHERE orderId = ?;";

    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $orderid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    //update order
    $sql = "UPDATE orders SET courierId = NULL, status = NULL WHERE orderId = ?;";

    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $orderid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../request.php");
    exit();
}
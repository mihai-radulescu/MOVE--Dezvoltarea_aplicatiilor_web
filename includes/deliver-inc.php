<?php
require_once 'db_config.php';
require_once 'functions.php';
session_start();

if(isset($_POST["selectedOrder"])){

    //Verific selectat
    $sql = "SELECT code, courierId FROM orders WHERE orderId = ?;";

    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    $orderid = $_POST["orderid"];

    mysqli_stmt_bind_param($stmt, "i", $orderid);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if(is_null($data["courierId"]) === true){

    //update pt curier
    $sql = "UPDATE courier SET orderId = ? WHERE userId = ?;";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    $orderid = $_POST["orderid"];
    $userid = $_SESSION["userid"];

    mysqli_stmt_bind_param($stmt, "ii", $orderid, $userid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

//update al comenzii
    $sql = "UPDATE orders SET courierId = ?, status = ? WHERE orderId = ?;";
    
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    
    $status = "accepted";

    mysqli_stmt_bind_param($stmt, "isi", $userid, $status, $orderid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

//Start log
    $date = date('Y-m-d H:i');

    $sql = "INSERT INTO statuslog (orderId, code, accepted) VALUES (?, ?, ?) ";

    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iss", $orderid, $data["code"], $date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../deliver.php");
    exit();
} else {
    header("location: ../deliver.php");
    exit();
}
}

if(isset($_POST["update"])){

    $orderid = $_POST["orderid"];
    $log = "pickedUp";

    $result = checkLog($conn, $orderid);

    if($result === 1){
        exit();
    }

    updateLog($conn, $orderid, $log);

    header("location: ../deliver.php");
    exit();
}

if(isset($_POST["update2"])){

    $orderid = $_POST["orderid"];
    $log = "delivered";

    $result = checkLog($conn, $orderid);

    if($result === 1){
        header("location: ../deliver.php");
        exit();  
    } else if($result === 2){

        updateLog($conn, $orderid, $log);

        $sql = "UPDATE orders SET status = ? WHERE orderId = ?;";
    
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        $status = "delivered";

        mysqli_stmt_bind_param($stmt, "si", $status, $orderid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        //update courier
        $sql = "UPDATE courier SET orderId = NULL WHERE userId = ?;";
 
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
    
        $userid = $_SESSION["userid"];

        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } else {
        header("location: ../deliver.php?error=notinorder");
        exit();
    }

    header("location: ../deliver.php");
    exit();
}

if(isset($_POST["cancel"])){

    $date = date('Y-m-d H:i');
    $orderid = $_POST["orderid"];

    $sql = "UPDATE statuslog SET canceled = ? WHERE orderId = ?;";
    
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $date, $orderid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../includes/wait.php");
    exit();
}
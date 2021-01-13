<?php
require_once "db_config.php";
session_start();

$oldPassword = $_POST["oldPassword"];
$password = $_POST["password"];
$repPassword = $_POST["repeatePassword"];

$userid = $_SESSION["userid"];


if($password === $repPassword){
    //echo "<script>console.log(\"" . $repPassword . "\")</script>";
    
    $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
    $oldPassword = password_hash($oldPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE user SET password = ? WHERE userId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $hashedpwd, $userid);
    mysqli_stmt_execute($stmt); 

    mysqli_stmt_close($stmt);

    header("location: ../profile.php");
    exit();

}
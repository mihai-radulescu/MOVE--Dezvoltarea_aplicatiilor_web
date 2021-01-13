<?php
require_once "db_config.php";
session_start();

$userName = $_POST["username"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$name = $_POST["name"];
$userid = $_SESSION["userid"];

//echo "<script>console.log(\"" . $name . "\")</script>";

$sql = "UPDATE user SET username = ?, name = ?, email = ?, phone_number = ? WHERE userId = ?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "sssii", $userName, $name, $email, $phone, $userid);
mysqli_stmt_execute($stmt); 

mysqli_stmt_close($stmt);

header("location: ../profile.php");
exit();
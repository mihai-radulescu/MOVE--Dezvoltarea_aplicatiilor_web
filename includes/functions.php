<?php 
require_once 'db_config.php';

//-- Signup functions --

function userExists($conn, $username, $email){
    $sql = "SELECT * FROM user WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

//-- Login functions --

function emptyInputLogin($username, $password){
    $result;

    if(empty($username) || empty($password)){
        $result = true;
    }
    else{
        $result = false;
    }

    return $result;
}

function loginUser($conn, $username, $password){
    $userExists = userExists($conn, $username, $username);

    if($userExists === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $userExists["password"];
    
    //$checkPwd = password_verify($password, $pwdHashed);
    //$checkPwd === false
    //$checkPwd === true

    if($password !== $pwdHashed){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if($password === $pwdHashed){
        session_start();
        $_SESSION["userid"] = $userExists["userId"];
        header("location: ../index.php");
        exit();
    }
}

//-- CRUD addresses --
function addAddress($conn, $country, $region, $city, $street){
    
    require_once 'db_config.php';

    $userid = $_SESSION["userid"];
    
  
    $sql = "INSERT INTO addresses (userId, country, region, city, street) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
   
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "issss", $userid, $country, $region, $city, $street);
    mysqli_stmt_execute($stmt); 
    
    mysqli_stmt_close($stmt);
    
    header("location: ../addresses.php");
    exit();
}

function readAddresses($conn, $userid){

    $sql = "SELECT * FROM addresses WHERE userId = ?;";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    mysqli_stmt_bind_param($stmt, "i", $userid);
    mysqli_stmt_execute($stmt);
 
    return $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
 }
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

function userCreate($conn, $name, $email, $phone, $username, $password, $repeatPassword){

   /* if(!preg_match('/^[a-zA-Z0-9]*$/'), $username){
        header("location: ../signup.php?error=invaliduser");
        exit();
    }*/

    $username = mysqli_real_escape_string($conn, $username);
    $name = mysqli_real_escape_string($conn, $name);

    if(userExists($conn, $username, $email) === false){
        header("location: ../signup.php?error=userexists");
        exit();
    }

    if($password !== $repeatPassword){
        header("location: ../signup.php?error=wrongsignup");
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, password, name, email, phone_number) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
   
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssi", $username, $hashedPwd, $name, $email, $phone);
    mysqli_stmt_execute($stmt); 

    mysqli_stmt_close($stmt);
    
    header("location: ../login.php");
    exit();

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

    $pwdHashed = password_hash($password, PASSWORD_DEFAULT);
    
    $checkPwd = password_verify($password, $pwdHashed);
    //$checkPwd === false
    //$checkPwd === true

    if($checkPwd === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if($checkPwd === true){
        session_start();
        $_SESSION["userid"] = $userExists["userId"];
        header("location: ../index.php");
        exit();
    }
}

//-- CRUD addresses --
function addAddress($conn, $userid, $country, $region, $city, $street){
    
    require_once 'db_config.php';

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

function delAddress($conn, $addressid, $userid){
    require_once 'db_config.php';

    $sql = "DELETE FROM addresses WHERE addressId = ? AND userId = ?;";
    $stmt = mysqli_stmt_init($conn);
   
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $addressid, $userid);
    mysqli_stmt_execute($stmt); 

    mysqli_stmt_close($stmt);
    
    header("location: ../addresses.php");
    exit();
}

function updateAddress($conn, $userid, $addressid, $country, $region, $city, $street){
    
    $sql = "UPDATE addresses SET country = ?, region = ?, city = ?, street = ? WHERE userId = ? AND addressId = ?;";
    $stmt = mysqli_stmt_init($conn);
   
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssii", $country, $region, $city, $street, $userid, $addressid);
    mysqli_stmt_execute($stmt); 

    mysqli_stmt_close($stmt);

     //echo "<script>console.log(\"" . $country . "\")</script>";
    
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

 function readOneAddress($conn, $addressid){

    $sql = "SELECT * FROM addresses WHERE addressId = ?;";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    mysqli_stmt_bind_param($stmt, "i", $addressid);
    mysqli_stmt_execute($stmt);
 
    return $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
 }


 //-- CRUD orders --
 function checkCode($conn, $code){
    $sql = "SELECT * FROM orders WHERE code = ?;";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    mysqli_stmt_bind_param($stmt, "s", $code);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        return $row;
    }
    else{
        $result = false;
        return $result; 
    }
    mysqli_stmt_close($stmt);  
}

 function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function placeOrder($conn, $userid, $addressid, $clientName, $clientPhone, $clientEmail, $clientStreet, $weight){
    require_once 'db_config.php';

    $date = date('Y-m-d H:i');

    $code = generateRandomString();
    while(checkCode($conn, $code) !== false){
        $code = generateRandomString();
    }

    $sql = "INSERT INTO orders (userId, useraddressId, code, date, weight, clientName, clientPhone, clientEmail, clientStreet) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
   
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iississss", $userid, $addressid, $code, $date, $weight, $clientName, $clientPhone, $clientEmail, $clientStreet);
    mysqli_stmt_execute($stmt); 

    mysqli_stmt_close($stmt);
    
    header("location: ../orders.php");
    exit();
}


function readOrders($conn, $userid){
    $sql = "SELECT * FROM orders WHERE userId = ?;";
 
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
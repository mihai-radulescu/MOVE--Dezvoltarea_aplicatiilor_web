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

    if(userExists($conn, $username, $email) !== false){
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
        header("location: ../login.php?error=wronglogin_1");
        exit();
    }

    $pwdHashed = $userExists["password"];
    
    $checkPwd = password_verify($password, $pwdHashed);

    if($checkPwd === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if($checkPwd === true){
        session_start();

        $_SESSION["userid"] = $userExists["userId"];
        $_SESSION["userRole"] = $userExists["userRole"];
        $_SESSION["name"] = $userExists["name"];

        header("location: ../index.php");
        exit();
    }
}

function profileShow($conn, $userid){
    if(!isset($_SESSION["userid"])){
        header("location: ../index.php");
        exit();
    }
    else if($_SESSION["userid"] === $userid){
        $sql = "SELECT * FROM user WHERE userId = ?;";
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
    
        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);

        return $row;

        mysqli_stmt_close($stmt);
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

function readOneOrder($conn, $orderid){
    $sql = "SELECT * FROM orders WHERE orderId = ?;";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    mysqli_stmt_bind_param($stmt, "i", $orderid);
    mysqli_stmt_execute($stmt);
 
    return $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
}

function readSelected($conn, $userid){

    $sql = "SELECT orderId FROM courier WHERE userId = ?;";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    mysqli_stmt_bind_param($stmt, "i", $userid);
    mysqli_stmt_execute($stmt);
 
    $result = mysqli_stmt_get_result($stmt);
    $data =  mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $sql = "SELECT * FROM orders WHERE orderId = ?;";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    $orderId = $data["orderId"];
 
    mysqli_stmt_bind_param($stmt, "i",  $orderId);
    mysqli_stmt_execute($stmt);
 
    return $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
}

function readDeliveries($conn, $userid){
/*
SELECT orders.orderId FROM orders WHERE orders.userAddressId IN ( SELECT addresses.addressId FROM addresses WHERE addresses.city = "Pitesti")
*/ 
//Verificare curier

    $sql = "SELECT * FROM courier WHERE userId = ?;";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    mysqli_stmt_bind_param($stmt, "i", $userid);
    mysqli_stmt_execute($stmt);
    $ok = false;
 
    $result = mysqli_stmt_get_result($stmt);
    if($data =  mysqli_fetch_assoc($result)){
        $ok = true;
        $country = $data["country"];
        $region = $data["region"];
        $city = $data["city"];
    }
    mysqli_stmt_close($stmt);

//Selectare comenzi
    if($ok === true){

        $sql = "SELECT * FROM orders WHERE orders.courierId IS NULL AND (orders.status IS NULL OR orders.status = 'delivered' ) AND orders.userAddressId IN ( 
            SELECT addresses.addressId FROM addresses WHERE addresses.country = ? AND addresses.region = ? AND addresses.city = ?)";
    
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "sss", $country, $region, $city);
        mysqli_stmt_execute($stmt);

        return $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    }

}

function checkLog($conn, $orderid){

    $sql = "SELECT * FROM statuslog WHERE orderId = ?;";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    mysqli_stmt_bind_param($stmt, "i", $orderid);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $data =  mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if(is_null($data["pickedUp"]) === flase){
        return 1;
    } else if(is_null($data["delivered"]) === true){
        return 2;
    } else{
        return 0;
    }
}

function updateLog($conn, $orderid, $log){

    $date = date('Y-m-d H:i');

    $sql = "UPDATE statuslog SET " . $log . " = ? WHERE orderId = ?;";

    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    mysqli_stmt_bind_param($stmt, "si", $date, $orderid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function readUser($conn, $userid){
    $sql = "SELECT name, email, phone_number FROM user WHERE userId = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userid);
    mysqli_stmt_execute($stmt);

    return $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
}

function readCanceled($conn){

    $sql = "SELECT * FROM orders WHERE orderId IN (SELECT orderId FROM statuslog WHERE canceled IS NOT NULL);";
 
    $stmt = mysqli_stmt_init($conn);
     
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
 
    mysqli_stmt_execute($stmt);

    return $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
}
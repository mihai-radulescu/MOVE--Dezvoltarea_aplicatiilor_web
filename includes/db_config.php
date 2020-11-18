<?php

$serverName = 'localhost';
$dBUserName = 'root';
$dBPassword = '';
$dBName = 'move_db_v1';
 

$conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);
 
// Check connection
if(!$conn){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

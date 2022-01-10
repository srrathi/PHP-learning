<?php 
// THIS FILE CONTAINS DATABASE CONFIGURATION
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME","login_php");

// CONNECTING TO THE DATABASE
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($con == false){
    die("connection to this database failed due to " . mysqli_connect_error());
}
else {
    echo "Connected to the databse successfully"; 
}
?>
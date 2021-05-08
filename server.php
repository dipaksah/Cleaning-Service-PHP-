<?php

$hostname="localhost";
$username="root";
$password="";
$serviceDB="service";
Global $conn;

 $conn=mysqli_connect($hostname,$username,$password,$serviceDB);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
	// echo "database connected";
} 

?>
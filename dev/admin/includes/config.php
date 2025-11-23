<?php
$servername = "localhost";
$usernameDB = "u800348178_myacadDev";
$password = "Hostinger@90949089";
$dbname = "u800348178_myacadDev";
$baseURL = "https://dev.myacad.app/requests";
$printImageUrl = "https://dev.myacad.app";
$dbconnect = new MySQLi($servername,$usernameDB,$password,$dbname);
if ( $dbconnect->connect_error ){
	die("Connection Failed: " .$dbconnect->connect_error );
}
$sql = "SET CHARACTER SET utf8";
$dbconnect->query($sql);
?>

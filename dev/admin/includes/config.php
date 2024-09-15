<?php
$servername = "localhost";
$username = "u800348178_myacad2USER";
$password = "N@b$90949089";
$dbname = "u800348178_myacadv2DB";
$baseURL = "https://dev.myacad.app/requests";
$dbconnect = new MySQLi($servername,$username,$password,$dbname);
if ( $dbconnect->connect_error ){
	die("Connection Failed: " .$dbconnect->connect_error );
}
$sql = "SET CHARACTER SET utf8";
$dbconnect->query($sql);
?>

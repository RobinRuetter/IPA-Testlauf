<?php
//conect to db 
$benuzername = "root";
$passwort = "";
$datenbank = "ipa";
$conn = new mysqli("localhost", $benuzername, $passwort, $datenbank);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
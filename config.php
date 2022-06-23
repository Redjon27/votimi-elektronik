<?php
$host = "localhost";
$userName = "root";
$password = "";
$dbName = "voting-db";
// lidhja me db
$conn = new mysqli($host, $userName, $password, $dbName);
// verifikimi i lidhjes
if ($conn->connect_error) {
die("Lidhja deshtoi " . $conn->connect_error);
}
?>
<?php 
require_once("config.php");
if((isset($_POST['emri'])&& $_POST['emri'] !='') && (isset($_POST['email'])&& $_POST['email'] !=''))
{
$emri = $conn->real_escape_string($_POST['emri']);
$mbiemri = $conn->real_escape_string($_POST['mbiemri']);
$email = $conn->real_escape_string($_POST['email']);
$telefon = $conn->real_escape_string($_POST['telefon']);
$subjekti = $conn->real_escape_string($_POST['subjekti']);
$sql="INSERT INTO kontakt (emri, mbiemri, email, telefon, subjekti) VALUES ('".$emri."','".$mbiemri."','".$email."','".$telefon."','".$subjekti."')";
if(!$result = $conn->query($sql)){
die('Ndodhi nje problem [' . $conn->error . ']');
}
else
{
echo "Faleminderit! Do ju kontaktojme se shpejti";
}
}

?>
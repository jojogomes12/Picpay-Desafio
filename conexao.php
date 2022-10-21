<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname='pickpay';
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}







?>
<?php 

$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
  die("Koneksi ke database gagal : " . mysqli_connect_error());
}

<?php 
session_start();
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$id = $_GET['materialid'];

mysqli_query($conn, "DELETE FROM material WHERE material_id = '$id'");

if(mysqli_affected_rows($conn) > 0){
  header('Location: material.php?pesan=delete');
} else {
  echo mysqli_error($conn);
}
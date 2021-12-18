<?php 
session_start();
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$id = $_GET['itemid'];

mysqli_query($conn, "DELETE FROM item WHERE item_id = '$id'");

if(mysqli_affected_rows($conn) > 0){
  header('Location: item.php?pesan=delete');
  exit();
} else {
  echo mysqli_error($conn);
}
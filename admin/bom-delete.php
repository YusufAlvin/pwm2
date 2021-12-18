<?php 
session_start();
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

extract($_GET);

mysqli_query($conn, "DELETE FROM bom WHERE bom_item_id = '$itemid'");

if(mysqli_affected_rows($conn) > 0){
  header('Location: bom.php?pesan=delete');
  exit();
} else {
  echo mysqli_error($conn);
  exit();
}
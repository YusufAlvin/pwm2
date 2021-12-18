<?php 
session_start();
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

extract($_GET);

mysqli_query($conn, "DELETE FROM bom WHERE bom_id = $bomid");

if(mysqli_affected_rows($conn) > 0){
  header('Location: bom-detail.php?' . $_SERVER['QUERY_STRING'] . '&pesan=delete');
  exit();
} else {
  echo mysqli_error($conn);
  exit();
}
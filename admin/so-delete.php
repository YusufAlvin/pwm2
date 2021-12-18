<?php 
session_start();
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

extract($_GET);

mysqli_query($conn, "DELETE so FROM so JOIN bom ON bom.bom_id = so.so_bom_id WHERE so.so_no_po = '$nopo' AND bom.bom_item_id = '$itemid'");

if(mysqli_affected_rows($conn) > 0){
  header('Location: so.php?pesan=delete');
  exit();
} else {
  echo mysqli_error($conn);
  exit();
}

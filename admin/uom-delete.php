<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$uomid = $_GET['uomid'];

mysqli_query($conn, "DELETE FROM uom WHERE uom_id = $uomid");
if(mysqli_affected_rows($conn) > 0){
	header('Location: uom.php?pesan=delete');
	exit();
} else {
	echo mysqli_error($conn);
	exit();
}

?>
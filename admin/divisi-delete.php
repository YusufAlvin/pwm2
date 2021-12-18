<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$divisiid = $_GET['divisiid'];

mysqli_query($conn, "DELETE FROM divisi WHERE divisi_id = $divisiid");
if(mysqli_affected_rows($conn) > 0){
	 header('Location: divisi.php?pesan=delete');
	exit();
} else {
	 echo mysqli_error($conn);
	 exit();
}
?>
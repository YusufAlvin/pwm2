<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$divisiid = $_GET['divisiid'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$divisi = trim(htmlspecialchars($_POST['divisi']));

  $querydivisi = mysqli_query($conn, "SELECT divisi_nama FROM divisi WHERE divisi_nama = '$divisi'");

  if(mysqli_num_rows($querydivisi) > 0){
    header('Location: divisi.php?pesan=duplikat');
    exit();
  }
  
	mysqli_query($conn, "UPDATE divisi SET divisi_nama = '$divisi' WHERE divisi_id = $divisiid");

	if(mysqli_affected_rows($conn) > 0){
		header('Location: divisi.php?pesan=ubah');
		exit();
	} else {
		echo mysqli_error($conn);
	}
}

$query = mysqli_query($conn, "SELECT * FROM divisi WHERE divisi_id = $divisiid");
$divisi = mysqli_fetch_assoc($query);
?>
<?php require_once "template/header.php"; ?>

<?php require_once "template/navbar.php"; ?>

<?php require_once "template/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0">Edit Divisi</h1>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-md-5">
            <form action="" method="post">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="divisi" class="form-label">Divisi</label>
                        <input name="divisi" type="text" class="form-control" id="divisi" value="<?= $divisi['divisi_nama'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <div>
                    <button name="add-item" type="submit" class="btn btn-primary">Edit Divisi</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php require_once "template/footer.php"; ?>

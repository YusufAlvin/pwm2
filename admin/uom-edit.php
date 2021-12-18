<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$uomid = $_GET['uomid'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uom = trim(htmlspecialchars($_POST['uom']));
  $queryuom = mysqli_query($conn, "SELECT uom_nama FROM uom WHERE uom_nama = '$uom'");
  if(mysqli_num_rows($queryuom) > 0){
    header('Location: uom.php?pesan=duplikat');
    exit();
  } elseif(mysqli_num_rows($queryuom) < 1){
    mysqli_query($conn, "UPDATE uom SET uom_nama = '$uom' WHERE uom_id = $uomid");
    if(mysqli_affected_rows($conn) > 0){
      header('Location: uom.php?pesan=ubah');
      exit();
    } else {
      echo mysqli_error($conn);
      exit();
    }
  }
}

$query = mysqli_query($conn, "SELECT * FROM uom WHERE uom_id = $uomid");
$uom = mysqli_fetch_assoc($query);
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
            <h1 class="m-0">Edit UoM</h1>
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
                        <label for="uom" class="form-label">UoM</label>
                        <input name="uom" type="text" class="form-control" id="uom" value="<?= $uom['uom_nama'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <div>
                    <button name="add-item" type="submit" class="btn btn-primary">Edit UoM</button>
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

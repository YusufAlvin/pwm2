<?php 
session_start();
// error_reporting(0);
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$nospk = $_GET['id'];

if($nospk == ""){
  header('Location: realisasi.php');
  exit();
}

$queryrealisasi = mysqli_query($conn, "SELECT material.material_id, material.material_nama, realisasi.so_total_kebutuhan, realisasi.so_no_spk FROM realisasi JOIN material ON material.material_id = realisasi.so_material_id WHERE realisasi.so_no_spk = '$nospk'");

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $spk = $nospk;
  $quantity = $_POST['quantity'];
  $realisasi = $_POST['realisasi'];
  $tanggal = $_POST['tanggal'];
  $new_quantity = [];
  $new_realisasi = [];
  $new_tanggal = [];


  for($i = 0; $i < count($quantity); $i++){
    if($quantity[$i] == ""){
      continue;
    }
    array_push($new_quantity, htmlspecialchars($quantity[$i]));
  }

  for($j = 0; $j < count($realisasi); $j++){
    if($realisasi[$j] == ""){
      continue;
    }
    array_push($new_realisasi, htmlspecialchars($realisasi[$j]));
  }

  for($j = 0; $j < count($tanggal); $j++){
    if($tanggal[$j] == ""){
      continue;
    }
    array_push($new_tanggal, htmlspecialchars($tanggal[$j]));
  }

  $queryrealisasi2 = mysqli_query($conn, "SELECT material.material_id, material.material_nama, realisasi.so_total_kebutuhan, realisasi.so_no_spk FROM realisasi JOIN material ON material.material_id = realisasi.so_material_id WHERE realisasi.so_no_spk = '$nospk'");

  for($k = 0; $k < mysqli_num_rows($queryrealisasi2); $k++){
    mysqli_query($conn, "UPDATE realisasi SET so_qty = $new_quantity[$k], so_realisasi = $new_realisasi[$k], so_tanggal = $new_tanggal[$k] WHERE ");
  }

  while($realisasi2 = mysqli_fetch_assoc($queryrealisasi2)){
    var_dump($new_quantity);
  }

  exit();

  if(mysqli_affected_rows($conn) > 0){
    echo "<script>alert('Material has been added!');location.href='bom.php'</script>";
  } else {
    echo mysqli_error($conn);
    exit();
  }
}
?>

<?php require_once "template/header.php"; ?>

<?php require_once "template/navbar.php"; ?>

<?php require_once "template/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Realisasi</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                <form action="" method="post">
                  <?php while($realisasi = mysqli_fetch_assoc($queryrealisasi)) : ?>
                  <div class="row mb-3">
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="materialcode">Material Code</label>
                        <input name="materialcode" type="text" class="form-control" id="materialcode" value="<?= $realisasi['material_id']; ?>" disabled>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="materialnama">Material</label>
                        <input name="materialnama" type="text" class="form-control" id="materialnama" value="<?= $realisasi['material_nama']; ?>" disabled>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="totalkebutuhan">Total Kebutuhan</label>
                        <input name="totalkebutuhan[]" type="text" class="form-control" id="totalkebutuhan" value="<?= $realisasi['so_total_kebutuhan']; ?>" disabled>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="quantity">Quantity</label>
                        <input name="quantity[]" type="text" class="form-control" id="quantity" placeholder="Quantity">
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="realisasi">Realisasi</label>
                        <input name="realisasi[]" type="text" class="form-control" id="realisasi" placeholder="Realisasi">
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="tanggal">Tanggal Input</label>
                        <input name="tanggal[]" type="date" class="form-control" id="tanggal">
                      </div>
                    </div>
                  </div>
                  <?php endwhile; ?>
                  <div class="row">
                    <div class="col-md-4">
                      <button class="btn btn-primary" type="submit" name="add">Edit Data</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php require_once "template/footer.php"; ?>

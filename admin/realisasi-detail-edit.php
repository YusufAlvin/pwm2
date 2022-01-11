<?php 
session_start();
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

extract($_GET);

if($nopo == "" || $itemid == "" || $materialid == ""){
  header('Location: realisasi.php');
  exit();
}

$queryrealisasi = mysqli_query($conn, "SELECT so.so_qty_order, bom.bom_quantity, so.so_realisasi, so.so_ba, so.so_tanggal FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_id = $soid");

$realisasi = mysqli_fetch_assoc($queryrealisasi);
$totalkebuthan = floatval($realisasi['bom_quantity'] * $realisasi['so_qty_order']);

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $quantity = trim(htmlspecialchars($_POST['quantity']));
  $realisasi = trim(htmlspecialchars($_POST['realisasi']));
  $ba = trim(htmlspecialchars($_POST['ba']));
  $tanggal = trim(htmlspecialchars($_POST['tanggal']));

  if($realisasi > $totalkebuthan){
    header('Location: realisasi-detail.php?' . $_SERVER['QUERY_STRING'] . '&pesan=validasi');
    exit();
  } else {
    mysqli_query($conn, "UPDATE so JOIN bom ON bom.bom_id = so.so_bom_id SET so_realisasi = $realisasi, so_ba = $ba WHERE so.so_id = $soid AND so.so_no_po = '$nopo' AND bom.bom_item_id = '$itemid' AND bom.bom_material_id = '$materialid'");
    if(mysqli_affected_rows($conn) > 0){
      header('Location: realisasi-detail.php?' . $_SERVER['QUERY_STRING'] . '&pesan=ubah');
      exit();
    } else {
      echo mysqli_error($conn);
      exit();
    }
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
            <h1 class="m-0">Edit</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5">
            <div class="card">
              <div class="card-body">
                <form action="" method="post">
                  <div class="row">
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="totalkebutuhan" class="form-label">Quantity Bon Bahan</label>
                        <input name="totalkebutuhan" type="text" class="form-control" id="totalkebutuhan" value="<?= $totalkebuthan ?>" disabled>                                               
                      </div>
                      <div class="mb-3">
                        <label for="realisasi" class="form-label">Realisasi</label>
                        <input name="realisasi" type="text" class="form-control" id="realisasi" value="<?= $realisasi['so_realisasi'] ?>" required>
                      </div>
                      <div class="mb-3">
                        <label for="ba" class="form-label">BA</label>
                        <input name="ba" type="text" class="form-control" id="ba" value="<?= $realisasi['so_ba'] ?>" required>
                      </div>                  
                    </div>                  
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <button class="btn btn-primary" type="submit" name="add" id="add">Edit Material</button>                    
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
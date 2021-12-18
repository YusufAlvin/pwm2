<?php 
session_start();
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

extract($_GET);

$queryso = mysqli_query($conn, "SELECT so.so_no_po, bom.bom_item_id, so.so_lot_number, so.so_qty_order FROM so JOIN bom ON bom.bom_id = so.so_bom_id WHERE so_no_po = '$nopo' AND bom_item_id = '$itemid'");
$queryitem = mysqli_query($conn, "SELECT DISTINCT bom_item_id FROM bom");

$data = mysqli_fetch_assoc($queryso);

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $no_spk = trim(htmlspecialchars($_POST['no_spk']));
  $lotnumber = trim(htmlspecialchars($_POST['lot-number']));
  $qty = trim(htmlspecialchars($_POST['qty']));
  $item = $_POST['item'];

  mysqli_query($conn, "UPDATE so JOIN bom ON bom.bom_id = so.so_bom_id SET so_qty_order = $qty, so_lot_number = '$lotnumber' WHERE so_no_po = '$no_spk' AND bom_item_id = '$item'");

  if(mysqli_affected_rows($conn) > 0){
    header('Location: so.php?pesan=edit');
    exit();
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
            <h1 class="m-0">Edit Sales Order</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-body">
                <form action="" method="post">
                  <div class="row">
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="projects" class="form-label">No PO</label>
                        <input name="no_spk" type="text" class="form-control" id="no_spk" value="<?= $data['so_no_po']; ?>" readonly>
                      </div>
                      <div class="mb-3">
                        <label for="itemid" class="form-label">Item</label>
                        <input name="item" type="text" class="form-control" id="itemid" value="<?= $data['bom_item_id']; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="lot-number" class="form-label">Lot Number</label>
                        <input name="lot-number" type="text" class="form-control" id="lot-number" value="<?= $data['so_lot_number']; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="qty" class="form-label">Quantity</label>
                        <input name="qty" type="text" class="form-control" id="qty" value="<?= $data['so_qty_order']; ?>">
                      </div>
                    </div>                  
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <button class="btn btn-primary" type="submit" name="edit">Edit Data</button>
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

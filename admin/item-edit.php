<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$item_id = $_GET['itemid'];

$query = mysqli_query($conn, "SELECT * FROM item WHERE item_id = '$item_id'");
$queryuom = mysqli_query($conn, "SELECT * FROM uom");
$item = mysqli_fetch_assoc($query);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $itemcode = $item_id;
  $nama = trim(htmlspecialchars($_POST['nama']));
  $panjang = trim(htmlspecialchars($_POST['panjang']));
  $lebar = trim(htmlspecialchars($_POST['lebar']));
  $tebal = trim(htmlspecialchars($_POST['tebal']));
  $uom = $_POST['uom'];

  $kubikasi = round(floatval($panjang) * floatval($lebar) * floatval($tebal) / 1000000, 4);

  mysqli_query($conn, "UPDATE item SET item_nama = '$nama', item_panjang = $panjang, item_lebar = $lebar, item_tebal = $tebal, item_kubikasi = $kubikasi, item_uom_id = $uom WHERE item_id = '$itemcode'");

  if(mysqli_affected_rows($conn) > 0){
    header('Location: item.php?pesan=ubah');
  } else {
    echo mysqli_error($conn);
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
            <h1 class="m-0">Edit Master Barang</h1>
          </div>
        </div><!-- /.row -->
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
                        <label for="item-code" class="form-label">item Code</label>
                        <input name="item-code" type="text" class="form-control" id="item-code" value="<?= $item['item_id']; ?>" disabled>
                      </div>
                      <div class="mb-3">
                        <label for="nama" class="form-label">Nama item</label>
                        <input name="nama" type="text" class="form-control" id="nama" value="<?= $item['item_nama']; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="uom" class="form-label">UoM</label>
                        <select name="uom" class="form-select form-control">
                          <?php while($uom = mysqli_fetch_assoc($queryuom)): ?>
                            <?php if($uom['uom_id'] == $item['item_uom_id']): ?>
                              <option value="<?= $uom['uom_id'] ?>" selected><?= $uom['uom_nama'] ?></option>
                            <?php else: ?>
                              <option value="<?= $uom['uom_id'] ?>"><?= $uom['uom_nama'] ?></option>
                            <?php endif; ?>
                          <?php endwhile; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="panjang" class="form-label">Panjang</label>
                        <input name="panjang" type="text" class="form-control" id="panjang" value="<?= $item['item_panjang'] ?>">
                      </div>
                      <div class="mb-3">
                        <label for="lebar" class="form-label">Lebar</label>
                        <input name="lebar" type="text" class="form-control" id="lebar" value="<?= $item['item_lebar'] ?>">
                      </div>
                      <div class="mb-3">
                        <label for="tebal" class="form-label">Tebal</label>
                        <input name="tebal" type="text" class="form-control" id="tebal" value="<?= $item['item_tebal'] ?>">
                      </div>
                    </div>
                  </div>
                  
                  <div>
                    <button name="add-material" type="submit" class="btn btn-primary">Edit Material</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php require_once "template/footer.php"; ?>



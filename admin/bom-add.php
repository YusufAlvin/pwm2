<?php 
session_start();
error_reporting(0);
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$queryitem = mysqli_query($conn, "SELECT item_id FROM item");
$querymaterial = mysqli_query($conn, "SELECT material.material_id, material.material_nama, uom.uom_nama FROM material JOIN uom ON uom.uom_id = material.material_uom_id");
$querydivisi = mysqli_query($conn, "SELECT divisi_id, divisi_nama FROM divisi");

while($divisi = mysqli_fetch_assoc($querydivisi)){
  $newdivisi[] = $divisi;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $item = $_POST['item'];
  $material = $_POST['material'];
  $divisi = $_POST['divisi'];
  $quantity = $_POST['quantity'];
  $new_quantity = [];
  $new_divisi = [];
  $lastid = [];

  if(count($material) == 0 || $item == "" || count($divisi) == 0 || count($quantity) == 0){
    echo "<script>alert('Isi kolom item, material, quantity, divisi');location.href='bom-add.php'</script>";
    exit();
  }

  for($i = 0; $i < count($quantity); $i++){
    if($quantity[$i] == ""){
      continue;
    }
    array_push($new_quantity, htmlspecialchars($quantity[$i]));
  }

  for($j = 0; $j < count($divisi); $j++){
    if($divisi[$j] == ""){
      continue;
    }
    array_push($new_divisi, htmlspecialchars($divisi[$j]));
  }

  if(count($new_divisi) != count($material) || count($new_quantity) != count($material)){
    echo "<script>alert('Isi kolom material, quantity, divisi');location.href='bom-add.php'</script>";
    exit();
  }

  for($i = 0; $i < count($material); $i++){
    mysqli_query($conn, "INSERT INTO bom (bom_item_id, bom_material_id, bom_quantity, bom_divisi_id) VALUES ('$item', '$material[$i]', $new_quantity[$i], $new_divisi[$i])");
    array_push($lastid, mysqli_insert_id($conn));
  }

  $querynopo =  mysqli_query($conn, "SELECT DISTINCT so_no_po, so_qty_order, so_lot_number FROM so JOIN bom ON bom.bom_id = so.so_bom_id WHERE bom.bom_item_id = '$item'");
  if(mysqli_num_rows($querynopo) > 0){
    while($nopo = mysqli_fetch_assoc($querynopo)){
      foreach ($lastid as $id) {
        mysqli_query($conn, "INSERT INTO so (so_no_po, so_bom_id, so_qty_order, so_lot_number) VALUE ('$nopo[so_no_po]', $id, $nopo[so_qty_order], '$nopo[so_lot_number]')");
      }
    }
  }
  
  if(mysqli_affected_rows($conn) > 0){
    header('Location: bom.php?pesan=sukses');
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
            <h1 class="m-0">Add BoM</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10">
            <div class="card">
              <div class="card-body">
                <form action="" method="post">
                  <select name="item" class="form-select form-control mb-3" aria-label="Default select example">
                    <option value="" selected>Item</option>
                    <?php while($item = mysqli_fetch_assoc($queryitem)) : ?>
                      <option value="<?= $item['item_id'] ?>"><?= $item['item_id'] ?></option>
                    <?php endwhile; ?>
                  </select>
                  <hr>
                  <?php while($material = mysqli_fetch_assoc($querymaterial)) : ?>
                  <div class="row mb-3">
                    <div class="col-md">
                      <div class="form-check">
                        <input name="material[]" class="form-check-input" type="checkbox" value="<?= $material['material_id'] ?>" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                          <?= $material['material_nama'] ?>
                        </label>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <input name="quantity[]" type="text" class="form-control" id="quantity" placeholder="Quantity">
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <input name="uom[]" type="text" class="form-control" id="quantity" value="<?= $material['uom_nama'] ?>" disabled>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <select name="divisi[]" class="form-select form-control">
                          <option value="" selected>Divisi</option>
                          <?php foreach($newdivisi as $d): ?>
                            <option value="<?= $d['divisi_id'] ?>"><?= $d['divisi_nama'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <?php endwhile; ?>
                  <div class="row">
                    <div class="col-md-4">
                      <button class="btn btn-primary" type="submit" name="add">Add Data</button>
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

<?php 
session_start();
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

extract($_GET);

if($materialid == "" || $itemid == ""){
  header('Location: bom.php');
  exit();
}

$querybom = mysqli_query($conn, "SELECT bom_material_id, bom_quantity, bom_divisi_id FROM bom JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id WHERE bom_id = $bomid");
$querydivisi = mysqli_query($conn, "SELECT divisi_id, divisi_nama FROM divisi");

$bom = mysqli_fetch_assoc($querybom);

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $divisi = $_POST['divisi'];
  $quantity = floatval(trim(htmlspecialchars($_POST['quantity'])));

  mysqli_query($conn, "UPDATE bom SET bom_divisi_id = $divisi, bom_quantity = $quantity WHERE bom_id = $bomid");  
 
  if(mysqli_affected_rows($conn) > 0){
    header('Location: bom-detail.php?' . $_SERVER['QUERY_STRING'] .'&pesan=ubah');
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
                        <label for="material" class="form-label">Material</label>
                        <input type="text" class="form-control" name="material" value="<?= $bom['bom_material_id'] ?>" disabled>                       
                      </div>
                      <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input name="quantity" type="text" class="form-control" id="quantity" value="<?= $bom['bom_quantity'] ?>">
                      </div>  
                      <div class="mb-3">
                        <label for="divisi" class="form-label">Divisi</label>
                        <select name="divisi" class="form-select form-control">
                          <?php while($divisi = mysqli_fetch_assoc($querydivisi)) : ?>
                            <?php if($bom['bom_divisi_id'] == $divisi['divisi_id']) : ?>
                              <option value="<?= $divisi['divisi_id'] ?>" selected><?= $divisi['divisi_nama'] ?></option>
                            <?php else : ?>
                              <option value="<?= $divisi['divisi_id'] ?>"><?= $divisi['divisi_nama'] ?></option>
                            <?php endif; ?>
                          <?php endwhile; ?>
                        </select>
                      </div>                   
                    </div>                  
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <button class="btn btn-primary" type="submit" name="add">Edit Material</button>                    
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
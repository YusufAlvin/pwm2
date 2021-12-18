<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$query = mysqli_query($conn, "SELECT material.material_id, material.material_nama, material.material_harga, uom.uom_nama FROM material JOIN uom ON uom.uom_id = material.material_uom_id");
$queryuom = mysqli_query($conn, "SELECT uom_id, uom_nama FROM uom");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $materialcode = trim(htmlspecialchars($_POST['material-code']));
  $nama = trim(htmlspecialchars($_POST['nama']));
  $uom = $_POST['uom'];
  $harga = trim(htmlspecialchars($_POST['harga']));

  $querymaterial = mysqli_query($conn, "SELECT material_id FROM material WHERE material_id = '$materialcode'");
  if(mysqli_num_rows($querymaterial) > 0){
    header('Location: material.php?pesan=duplikat');
    exit();
  }

  mysqli_query($conn, "INSERT INTO material (material_id, material_nama, material_uom_id, material_harga) VALUES ('$materialcode', '$nama', '$uom', $harga)");

  if(mysqli_affected_rows($conn) > 0){
    header('Location: material.php?pesan=sukses');
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
          <div class="col-sm-8">
            <h1 class="m-0">Master Bahan</h1>
            <?php if(isset($_GET['pesan'])) : ?>
                <?php if($_GET['pesan'] == 'sukses') : ?>
                  <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    Data berhasil ditambahkan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php elseif($_GET['pesan'] == 'delete') : ?>
                  <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    Data berhasil dihapus
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php elseif($_GET['pesan'] == 'duplikat') : ?>
                  <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    Material code sudah terdaftar
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php elseif($_GET['pesan'] == 'ubah') : ?>
                  <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    Data berhasil diubah
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php endif; ?>    
              <?php endif; ?>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-md-9">
            <form action="" method="post">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="material-code" class="form-label">Material Code</label>
                        <input name="material-code" type="text" class="form-control" id="material-code" placeholder="3LVL014M5SE002">
                      </div>
                      <div class="mb-3">
                        <label for="nama" class="form-label">Material Name</label>
                        <input name="nama" type="text" class="form-control" id="nama" placeholder="LVL SENGON 14.5MM (UK. 1250MM X 1250MM)">
                      </div>    
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="uom" class="form-label">UoM</label>
                        <select name="uom" class="form-select form-control">
                          <?php while($uom = mysqli_fetch_assoc($queryuom)): ?>
                            <option value="<?= $uom['uom_id'] ?>"><?= $uom['uom_nama'] ?></option>
                          <?php endwhile; ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input name="harga" type="text" class="form-control" id="harga" placeholder="20000">
                      </div>
                    </div>
                  </div>
                  <div>
                    <button name="add-material" type="submit" class="btn btn-primary">Add Material</button>
                  </div>
                  
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="card table-responsive">
              <div class="card-body">
                <table id="material" class="table table-striped display" style="width:100%">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Material Code</th>
                          <th>Nama</th>
                          <th>UoM</th>
                          <th>Harga</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php while($material = mysqli_fetch_assoc($query)) : ?>
                      <tr>
                          <td></td>
                          <td><?= $material['material_id']; ?></td>
                          <td><?= $material['material_nama']; ?></td>
                          <td><?= $material['uom_nama']; ?></td>
                          <td><?= number_format($material['material_harga'], 0, ",", ",") ?></td>
                          <td>
                            <a href="material-edit.php?materialid=<?= $material['material_id']; ?>"><span class="badge rounded-pill bg-primary">Edit</span></a>
                            <a href="material-delete.php?materialid=<?= $material['material_id']; ?>"><span class="badge rounded-pill bg-danger">Delete</span></a>
                          </td>
                      </tr> 
                    <?php endwhile; ?>                     
                  </tbody>
                </table>
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

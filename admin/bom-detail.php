<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$id = $_GET['itemid'];

$query = mysqli_query($conn, "SELECT bom.bom_id, item.item_id, material.material_id, material.material_nama, bom.bom_quantity, uom.uom_nama, divisi.divisi_nama FROM bom INNER JOIN item ON item.item_id = bom.bom_item_id INNER JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id INNER JOIN material ON material.material_id = bom.bom_material_id INNER JOIN uom ON uom.uom_id = material.material_uom_id WHERE bom.bom_item_id = '$id'");
$query_item_code = mysqli_query($conn, "SELECT bom_item_id FROM bom WHERE bom_item_id = '$id'");
$item_code = mysqli_fetch_assoc($query_item_code);
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
            <h1 class="m-0">Material Item Code <?= $id ?></h1>
            <?php if(isset($_GET['pesan'])) : ?>
              <?php if($_GET['pesan'] == 'ubah') : ?>
                  <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    Data berhasil diubah
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
          <div class="col-md-5">
            <!-- <a href="bom-add.php">
              <button class="btn btn-primary">Add Data</button>
            </a> -->
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="card table-responsive">
              <div class="card-body">
                <table id="bom-detail" class="table table-striped display" style="width:100%">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Material Code</th>
                          <th>Material</th>
                          <th>Quantity</th>
                          <th>UoM</th>
                          <th>Divisi</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php while($bom = mysqli_fetch_assoc($query)) : ?>
                      <tr>
                          <td></td>
                          <td><?= $bom['material_id']; ?></td>
                          <td><?= $bom['material_nama']; ?></td>
                          <td><?= $bom['bom_quantity']; ?></td>
                          <td><?= $bom['uom_nama']; ?></td>
                          <td><?= $bom['divisi_nama']; ?></td>
                          <td>
                            <a href="bom-detail-edit.php?bomid=<?= $bom['bom_id'] ?>&materialid=<?= $bom['material_id'] ?>&itemid=<?= $bom['item_id'] ?>"><span class="badge rounded-pill bg-primary">Edit</span></a>
                            <a href="bom-detail-delete.php?bomid=<?= $bom['bom_id'] ?>&materialid=<?= $bom['material_id'] ?>&itemid=<?= $bom['item_id'] ?>"><span class="badge rounded-pill bg-danger">Delete</span></a>
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

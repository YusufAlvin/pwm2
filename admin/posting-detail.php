<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

extract($_GET);

$query = mysqli_query($conn, "SELECT material.material_id, material.material_nama, so.so_lot_number, bom.bom_quantity, so.so_qty_order, uom.uom_nama, divisi.divisi_nama, so.so_realisasi, so.so_ba FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_no_po = '$nopo' AND item.item_id = '$itemid'");
?>
<?php require_once "template/header.php"; ?>

<?php require_once "template/navbar.php"; ?>

<?php require_once "template/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Detail No PO <strong><?= $nopo ?></strong> Item Code <strong><?= $itemid ?></strong></h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <?php if(isset($_GET['pesan'])) : ?>
              <?php if($_GET['pesan'] == 'delete') : ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                  Data berhasil dihapus
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>    
            <?php endif; ?>
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
            <!-- <a href="bom-add.php">
              <button class="btn btn-primary">Add Data</button>
            </a> -->
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="card table-responsive">
              <div class="card-body">
                <table id="so" class="table table-striped display" style="width:100%">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Material Code</th>
                          <th>Material</th>
                          <th>Lot Number</th>
                          <th>Quantity</th>
                          <th>Qty Order</th>
                          <th>UoM</th>
                          <th>Divisi</th>
                          <th>Qty Bon Bahan</th>
                          <th>Realisasi</th>
                          <th>BA</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php while($so = mysqli_fetch_assoc($query)) : ?>
                      <tr>
                          <td></td>
                          <td><?= $so['material_id']; ?></td>
                          <td><?= $so['material_nama']; ?></td>
                          <td><?= $so['so_lot_number']; ?></td>
                          <td><?= $so['bom_quantity']; ?></td>
                          <td><?= $so['so_qty_order']; ?></td>
                          <td><?= $so['uom_nama']; ?></td>
                          <td><?= $so['divisi_nama']; ?></td>
                          <td><?= floatval($so['so_qty_order'] * $so['bom_quantity']); ?></td>
                          <td><?= $so['so_realisasi']; ?></td>
                          <td><?= $so['so_ba']; ?></td>
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

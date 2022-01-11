<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

extract($_GET);

$query = mysqli_query($conn, "SELECT item.item_id, material.material_id, material.material_nama, so.so_id, so.so_no_po, so.so_lot_number, bom.bom_quantity, so.so_realisasi, so.so_tanggal, so.so_ba, so.so_qty_order, uom.uom_nama, divisi.divisi_nama FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_no_po = '$nopo' AND item.item_id = '$itemid'");

$bulan_sekarang = date('m-Y');

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
              <?php elseif($_GET['pesan'] == 'validasi') : ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                  Reaslisasi lebih besar dari total kebutuhan
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
                          <th>Divisi</th>
                          <th>Quantity Bon Bahan</th>
                          <th>Realisasi</th>
                          <th>BA</th>
                          <th>Tanggal</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php while($so = mysqli_fetch_assoc($query)) : ?>
                      <?php $sobulan = date('m-Y', strtotime($so['so_tanggal']));?>
                      <tr>
                          <td></td>
                          <td><?= $so['material_id']; ?></td>
                          <td><?= $so['material_nama']; ?></td>
                          <td><?= $so['divisi_nama']; ?></td>
                          <td><?= floatval($so['so_qty_order'] * $so['bom_quantity']); ?></td>
                          <td><?= $so['so_realisasi']; ?></td>
                          <td><?= $so['so_ba']; ?></td>
                          <td><?= $so['so_tanggal']; ?></td>
                          <td>
                            <?php if(isset($_SESSION["toggle"])) : ?>
                              <?php if($_SESSION["toggle"] == 'aktif') : ?>
                                <a href="realisasi-detail-edit.php?nopo=<?= $so['so_no_po']; ?>&itemid=<?= $so['item_id']; ?>&materialid=<?= $so['material_id']; ?>&soid=<?= $so['so_id']; ?>"><span class="badge rounded-pill bg-success">Edit</span></a>  
                              <?php elseif($_SESSION["toggle"] == 'nonaktif') : ?>
                                <?php if($bulan_sekarang == $sobulan) : ?>
                                  <a href="realisasi-detail-edit.php?nopo=<?= $so['so_no_po']; ?>&itemid=<?= $so['item_id']; ?>&materialid=<?= $so['material_id']; ?>&soid=<?= $so['so_id']; ?>"><span class="badge rounded-pill bg-success">Edit</span></a>
                                <?php endif; ?>
                              <?php endif; ?>
                            <?php else : ?>
                              <?php if($bulan_sekarang == $sobulan) : ?>
                                <a href="realisasi-detail-edit.php?nopo=<?= $so['so_no_po']; ?>&itemid=<?= $so['item_id']; ?>&materialid=<?= $so['material_id']; ?>&soid=<?= $so['so_id']; ?>"><span class="badge rounded-pill bg-success">Edit</span></a>
                              <?php endif; ?>
                            <?php endif; ?>
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

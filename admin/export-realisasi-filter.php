<?php 
session_start();

require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$queryitemcode = mysqli_query($conn, "SELECT DISTINCT so_item_id FROM realisasi");
$queryso = mysqli_query($conn, "SELECT DISTINCT so_no_spk FROM realisasi");
$queryitem = mysqli_query($conn, "SELECT DISTINCT so_item_id FROM realisasi");

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
            <h1 class="m-0">Export Filter</h1>
            <?php if(isset($_GET['pesan'])) : ?>
              <?php if($_GET['pesan'] == 'fieldkosong') : ?>
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  <strong>Tidak memasukkan filter</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>   
              <?php endif; ?>
              <?php if($_GET['pesan'] == 'datakosong') : ?>
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  <strong>Tidak ada data</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>   
              <?php endif; ?>
              <?php if($_GET['pesan'] == 'tanggalawalkosong') : ?>
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  <strong>Isi kolom tanggal awal</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>   
              <?php endif; ?>
              <?php if($_GET['pesan'] == 'tanggalakhirkosong') : ?>
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  <strong>Isi kolom tanggal akhir</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>   
              <?php endif; ?> 
              <?php if($_GET['pesan'] == 'nospkkosong') : ?>
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  <strong>Isi kolom No PO</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>   
              <?php endif; ?>
              <?php if($_GET['pesan'] == 'itemidkosong') : ?>
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  <strong>Isi kolom Item Code</strong>
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
        <div class="row">
          <div class="col-md-4">
            <div class="card table-responsive">
              <div class="card-body">
                <form action="export-realisasi.php" method="GET">
                  <select name="projects" class="form-select form-control mb-3" aria-label="Default select example">
                    <option value="" selected>No PO</option>
                    <?php while ($so = mysqli_fetch_assoc($queryso)) : ?>
                        <option value="<?= $so['so_no_spk']; ?>"><?= $so['so_no_spk']; ?></option>
                    <?php endwhile; ?>
                  </select>
                  <select name="itemid" class="form-select form-control mb-3" aria-label="Default select example">
                    <option value="" selected>Item Code</option>
                    <?php while ($item = mysqli_fetch_assoc($queryitemcode)) : ?>
                        <option value="<?= $item['so_item_id']; ?>"><?= $item['so_item_id']; ?></option>
                    <?php endwhile; ?>
                  </select>
                  <div class="mb-3">
                    <label for="tanggalawa">Tanggal Awal</label>
                    <input name="tanggalawal" type="date" class="form-control" id="tanggalawal">
                  </div> 
                  <div class="mb-3">
                    <label for="tanggalawa">Tanggal Akhir</label>
                    <input name="tanggalakhir" type="date" class="form-control" id="tanggalakhir">
                  </div>
                  <button name='export' type="submit" class="btn btn-primary">Export</button>
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


<?php 
session_start();

require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$queryitemcode = mysqli_query($conn, "SELECT DISTINCT so_no_po FROM so");

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
              <?php if($_GET['pesan'] == 'tanggalakhirkosong') : ?>
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  <strong>Isi kolom tanggal awal</strong>
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
                <form action="so-excel.php" method="GET">
                  <div class="mb-3">
                    <label for="nopo">No PO</label>
                    <select name="nopo" class="form-select form-control mb-3" aria-label="Default select example">
                      <option value="" selected>No PO</option>
                      <?php while ($item = mysqli_fetch_assoc($queryitemcode)) : ?>
                      <option value="<?= $item['so_no_po']; ?>"><?= $item['so_no_po']; ?></option>
                      <?php endwhile; ?>
                  </select>
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


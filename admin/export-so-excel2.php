<?php 
session_start();

require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$querynopo = mysqli_query($conn, "SELECT DISTINCT so_no_po FROM so");
$querydivisi = mysqli_query($conn, "SELECT divisi_id, divisi_nama FROM divisi");

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
              <?php if($_GET['pesan'] == 'tanggalkosong') : ?>
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  <strong>Isi kolom tanggal awal dan akhir</strong>
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
                <form action="so-excel2.php" method="GET">
                  <label for="">No PO</label>
                  <div class="overflow-auto" style="height: 50vh;">
                  <?php while($nopo = mysqli_fetch_assoc($querynopo)) :?>
                      <div class="form-check">
                        <input name="nopo[]" class="form-check-input" type="checkbox" value="<?= $nopo['so_no_po'] ?>" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                          <?= $nopo['so_no_po'] ?>
                        </label>
                      </div>
                    <?php endwhile; ?>
                  </div>
                  <button name='export' type="submit" class="btn btn-primary mt-3">Export</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card table-responsive">
              <div class="card-body">
                <form action="so-excel-divisi.php" method="GET">
                  <label for="">Divisi</label>
                  <div class="overflow-auto">
                  <?php while($divisi = mysqli_fetch_assoc($querydivisi)) :?>
                      <div class="form-check">
                        <input name="divisi[]" class="form-check-input" type="checkbox" value="<?= $divisi['divisi_id'] ?>" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                          <?= $divisi['divisi_nama'] ?>
                        </label>
                      </div>
                    <?php endwhile; ?>
                    <div class="mb-3">
                      <label for="tanggalawal">Tanggal Awal</label>
                      <input name="tanggalawal" type="date" class="form-control" id="tanggalawal">
                    </div> 
                    <div class="mb-3">
                      <label for="tanggalakhir">Tanggal Akhir</label>
                      <input name="tanggalakhir" type="date" class="form-control" id="tanggalakhir">
                    </div>
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


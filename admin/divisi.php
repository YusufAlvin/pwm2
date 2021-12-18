<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $divisi = trim(htmlspecialchars($_POST['divisi']));

  $queryitem = mysqli_query($conn, "SELECT divisi_nama FROM divisi WHERE divisi_nama = '$divisi'");

  if(mysqli_num_rows($queryitem) > 0){
    header('Location: divisi.php?pesan=duplikat');
    exit();
  }

  mysqli_query($conn, "INSERT INTO divisi VALUES ('', '$divisi')");

  if(mysqli_affected_rows($conn) > 0){
    header('Location: divisi.php?pesan=sukses');
    exit();
  } else {
    echo mysqli_error($conn);
  }
}

$query = mysqli_query($conn, "SELECT * FROM divisi");
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
            <h1 class="m-0">Master Divisi</h1>
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
                    Data sudah ada
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
          <div class="col-md-5">
            <form action="" method="post">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="divisi" class="form-label">Divisi</label>
                        <input name="divisi" type="text" class="form-control" id="divisi" placeholder="GESSO" required>
                      </div>
                    </div>
                  </div>
                  <div>
                    <button name="add-item" type="submit" class="btn btn-primary">Add Divisi</button>
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
                <table id="uom-table" class="table table-striped display" style="width:100%">
                  <thead>
                    <tr>
          						<th>No</th>
          						<th>Divisi</th>
          						<th>Action</th>
                  	</tr>
                  </thead>
                  <tbody>
                    <?php while($divisi = mysqli_fetch_assoc($query)) : ?>
                      <tr>
                          <td></td>
                          <td><?= $divisi['divisi_nama']; ?></td>
                          <td>
                            <a href="divisi-edit.php?divisiid=<?= $divisi['divisi_id']; ?>"><span class="badge rounded-pill bg-primary">Edit</span></a>
                            <!-- <a href="divisi-delete.php?divisiid=<?= $divisi['divisi_id']; ?>"><span class="badge rounded-pill bg-danger">Delete</span></a> -->
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

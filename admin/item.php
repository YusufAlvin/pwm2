<?php 
session_start();
require_once "../koneksi.php";
if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $itemcode = trim(htmlspecialchars($_POST['item-code']));
  $nama = trim(htmlspecialchars($_POST['nama']));
  $panjang = trim(htmlspecialchars($_POST['panjang']));
  $lebar = trim(htmlspecialchars($_POST['lebar']));
  $tebal = trim(htmlspecialchars($_POST['tebal']));
  $uom = $_POST['uom'];
  $kubikasi = round(floatval($panjang) * floatval($lebar) * floatval($tebal) / 1000000, 4);

  $queryitem = mysqli_query($conn, "SELECT * FROM item WHERE item_id = '$itemcode'");
  if(mysqli_num_rows($queryitem) > 0){
    header('Location: item.php?pesan=duplikat');
    exit();
  }

  mysqli_query($conn, "INSERT INTO item VALUES ('$itemcode', '$nama', $panjang, $lebar, $tebal, $kubikasi, '$uom')");

  if(mysqli_affected_rows($conn) > 0){
    header('Location: item.php?pesan=sukses');
    exit();
  } else {
    echo mysqli_error($conn);
  }
}

$query = mysqli_query($conn, "SELECT item.item_id, item.item_nama, item.item_panjang, item.item_lebar, item.item_tebal, item.item_kubikasi, uom.uom_nama FROM item JOIN uom ON uom.uom_id = item.item_uom_id");
$queryuom = mysqli_query($conn, "SELECT uom_id, uom_nama FROM uom");
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
            <h1 class="m-0">Master Barang</h1>
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
                  <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    Item code sudah terdaftar
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
                        <label for="item-code" class="form-label">Item Code</label>
                        <input name="item-code" type="text" class="form-control" id="item-code" placeholder="1LOCCTIBS05620" required>
                      </div>
                      <div class="mb-3">
                        <label for="nama" class="form-label">Item Name</label>
                        <input name="nama" type="text" class="form-control" id="nama" placeholder="CTI BASE" required>
                      </div>
                      <div class="mb-3">
                        <label for="uom" class="form-label">UoM</label>
                        <select name="uom" class="form-select form-control">
                          <?php while($uom = mysqli_fetch_assoc($queryuom)): ?>
                            <option value="<?= $uom['uom_id'] ?>"><?= $uom['uom_nama'] ?></option>
                          <?php endwhile; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="mb-3">
                        <label for="panjang" class="form-label">Panjang</label>
                        <input name="panjang" type="text" class="form-control" id="panjang" placeholder="10.12" required>
                      </div>
                      <div class="mb-3">
                        <label for="lebar" class="form-label">Lebar</label>
                        <input name="lebar" type="text" class="form-control" id="lebar" placeholder="12.5" required>
                      </div>
                      <div class="mb-3">
                        <label for="tebal" class="form-label">Tebal</label>
                        <input name="tebal" type="text" class="form-control" id="tebal" placeholder="10.5" required>
                      </div>
                    </div>
                  </div>
                  
                  <div>
                    <button name="add-item" type="submit" class="btn btn-primary">Add Item</button>
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
                <table id="item" class="table table-striped display" style="width:100%">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Item Code</th>
                          <th>Nama</th>
                          <th>P</th>
                          <th>L</th>
                          <th>T</th>
                          <th>Kubikasi</th>
                          <th>UoM</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php while($item = mysqli_fetch_assoc($query)) : ?>
                      <tr>
                          <td></td>
                          <td><?= $item['item_id']; ?></td>
                          <td><?= $item['item_nama']; ?></td>
                          <td><?= $item['item_panjang']; ?></td>
                          <td><?= $item['item_lebar']; ?></td>
                          <td><?= $item['item_tebal']; ?></td>
                          <td><?= $item['item_kubikasi']; ?></td>
                          <td><?= $item['uom_nama']; ?></td>
                          <td>
                            <a href="item-edit.php?itemid=<?= $item['item_id']; ?>"><span class="badge rounded-pill bg-primary">Edit</span></a>
                            <a href="item-delete.php?itemid=<?= $item['item_id']; ?>"><span class="badge rounded-pill bg-danger">Delete</span></a>
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

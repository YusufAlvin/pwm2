<?php
session_start(); 
require_once "../koneksi.php";

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $passwordlama = trim($_POST["password-lama"]);
  $passwordbaru = trim($_POST["password-baru"]);
  $konfirmasi = trim($_POST["konfirmasi-password"]);
  $username = $_SESSION['username'];

  $querypassword = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
  
  if(mysqli_num_rows($querypassword) == 1){
    $datapassword = mysqli_fetch_assoc($querypassword);
    if(password_verify($passwordlama, $datapassword['password'])){
      if($passwordbaru == $konfirmasi){
        $passwordbaru = password_hash($passwordbaru, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE admin SET password = '$passwordbaru' WHERE username = '$username'");
        if(mysqli_affected_rows($conn) == 1){
          echo "<script>alert('Password berhasil diperbarui. Silahkan login kembali!');location.href = '../logout.php'</script>";
        exit();
        } else {
          echo mysqli_error($conn);
          exit();
        }
      } else {
        echo "<script>alert('konfirmasi password tidak sesuai');location.href = 'ubah-password.php'</script>";
        exit();
        }
    } else {
      echo "<script>alert('Password lama salah');location.href = 'ubah-password.php'</script>";
      exit();
    }
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Ubah Password</title>
  </head>
  <body>
    <div class="container">
      <div class="row d-flex justify-content-center mt-5">
        <div class="col-md-5">
          <form class="p-4 p-md-5 border rounded-3 bg-light" method="POST" action="">
            <div class="form-floating mb-3">
                <input name="password-lama" type="password" class="form-control" id="password-lama" placeholder="Password Lama" required>
                <label for="name">Password Lama</label>
            </div>
            <div class="form-floating mb-3">
                <input name="password-baru" type="password" class="form-control" id="password-baru" placeholder="password-baru" required>
                <label for="name">Password Baru</label>
            </div>
            <div class="form-floating mb-3">
                <input name="konfirmasi-password" type="password" class="form-control" id="konfirmasi-password" placeholder="konfirmasi-password" required>
                <label for="name">Konfirmasi Password Baru</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Ubah</button>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
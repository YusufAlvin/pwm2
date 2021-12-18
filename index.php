<?php
session_start(); 
require_once "koneksi.php";

if(isset($_SESSION['login'])){
  header("Location: admin/");
  exit();
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

    <title>Login</title>
  </head>
  <body>
    <div class="container">
      <div class="row d-flex justify-content-center mt-5">
        <div class="col-md-5">
          <form class="p-4 p-md-5 border rounded-3 bg-light" method="POST" action="">
            <div class="form-floating mb-3">
                <input name="username" type="text" class="form-control" id="username" placeholder="username" required="required">
                <label for="name">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input name="password" type="password" class="form-control" id="password" placeholder="password" required="required">
                <label for="password">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Login</button>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>

<?php 

if(isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $query = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
  
  if(mysqli_num_rows($query) == 1){
    $data = mysqli_fetch_assoc($query);
    if(password_verify($password, $data["password"])){
      $_SESSION["login"] = true;
      $_SESSION["username"] = $data["username"];
      mysqli_close($conn);
      header("Location: admin/");
      exit();
    } else {
      echo "<script>alert('Password Salah')</script>";
    }
  } else {
    echo "<script>alert('Username tidak ditemukan!')</script>";
  }
}

?>
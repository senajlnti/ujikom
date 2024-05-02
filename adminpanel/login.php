<?php
session_start();
require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Login Admin</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>

<style>
    .main{
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-box{
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
        padding: 20px;
    }

    .gambar-login img{
        max-width: 100%;
        height: auto;
    }
</style>

<body>
<div class="main">
    <div class="gambar-login me-3">
        <img src="https://img.freepik.com/free-vector/mobile-login-concept-illustration_114360-135.jpg?t=st=1714062504~exp=1714066104~hmac=c513365868d65b370ee8305306c54d7cac284e6a63bee24007d80bc5a65467a4&w=740" alt="Gambar Login">
    </div>
    <div class="main d-flex flex-column justify-content-center align-items-center">
    <h2 class="mb-4">Login Admin</h2> <!-- Tulisan baru di sini -->
    <div class="login-box p-5 shadow">
        <form action="" method="post">
            <div>
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div>
                <button class="btn btn-success form-control mt-3" type="submit" name="loginbtn">Login</button>
            </div>
        </form>
    </div>
    
<!-- ini oop -->
            <?php
            if(isset($_POST['loginbtn'])){
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($con,"SELECT * FROM users WHERE username= '$username' AND password = '$password'");
                $countdata = mysqli_num_rows($query);

                if($countdata > 0){
                    $_SESSION['username'] = $countdata['username'];
                    $_SESSION['login'] = true;
                    header('location: index.php');
                } else {
            ?>
            <div class="alert alert-warning" role="alert">
                Username atau Password salah!
            </div>
            <?php
                }
            } ?>
        </form>
    </div>
</div>
</body>
</html>

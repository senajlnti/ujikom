<?php
session_start();

// Set username to session
$_SESSION['username'] = "Admin";
require "../koneksi.php";

$queryKategori = mysqli_query($con,"SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);


$queryProduk = mysqli_query($con,"SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($queryProduk);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Home</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/fontawesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
    .kotak {
        border: solid;
    }

    .sumary-kategori{
        background-color: #00A881; 
        border-radius:10px;

    }
    .sumary-produk{
        background-color: #00A881; 
        border-radius:10px;

    }


    .no-decoration{
        text-decoration: none;
    }

</style>
<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item active" aria-current="page">
            <i class="fas fa-home"></i> Home
        </li>
        </ol>
     </nav>
    <h2>Halo <?php echo $_SESSION['username']; ?></h2>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="sumary-kategori p-3">
                <div class="row">
                    <div class="col-6">
                        <i class="fas fa-align-justify fa-7x text-black-50 "></i>
                    </div>
                    <div class="col-6 text-white">
                        <h3 class="fs-2">Kategori</h3>
                        <p class="fs-4"><?php echo $jumlahKategori;?> Kategori</p>
                        <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>

                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="sumary-produk p-3">
                <div class="row">
                    <div class="col-6">
                        <i class="fas fa-box fa-7x text-black-50 p-3"></i>
                    </div>
                    <div class="col-6 text-white">
                        <h3 class="fs-2">Produk</h3>
                        <p class="fs-4"><?php echo $jumlahProduk;?> Produk</p>
                        <p><a href="produk.php" class="text-white no-decoration">Lihat Detail</a></p>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mb-3">
    <div class="sumary-produk p-3">
        <div class="row">
            <div class="col-6">
            <i class="fas fa-envelope fa-7x text-black-50 p-3"></i>
            </div>
            <div class="col-6 text-white">
                <h3 class="fs-2">Notifikasi</h3>
                <p><a href="mailto:artg5012@gmail.com" class="text-white no-decoration">Lihat Notifikasi</a></p>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
    
    <!-- Grafik -->
    <div class="row mt-5">
        <div class="col-md-6">
            <canvas id="kategoriChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="produkChart"></canvas>
        </div>
    </div>

    <script>
        // Kategori Chart
        var ctxKategori = document.getElementById('kategoriChart').getContext('2d');
        var kategoriChart = new Chart(ctxKategori, {
            type: 'bar',
            data: {
                labels: ['Kategori'],
                datasets: [{
                    label: 'Jumlah Kategori',
                    data: [<?php echo $jumlahKategori; ?>],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Produk Chart
        var ctxProduk = document.getElementById('produkChart').getContext('2d');
        var produkChart = new Chart(ctxProduk, {
            type: 'bar',
            data: {
                labels: ['Produk'],
                datasets: [{
                    label: 'Jumlah Produk',
                    data: [<?php echo $jumlahProduk; ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>

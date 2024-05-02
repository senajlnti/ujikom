<?php 
    require "koneksi.php";
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ART GALLERY | Home</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Tambahkan ini untuk memuat file CSS Anda -->
</head>
<body>
    <?php require "navbar.php"; ?>
    
    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center warna1">
        <div class="container text-center text-white">
           <h1>ART GALLERY</h1>
           <H3>Ekpresikan dirimu dengan seni lukisan</H3>
           <div class="col-md-8 offset-md-2">
            <form  method="get" action="produk.php">
            <div class="input-group input-group-lg my-4">
               <input type="text" class="form-control" placeholder="Nama Produk"
                aria-label="Nama Produk" aria-describedby="basic-addon2" name="keyword">
               <button type="submit"class="btn warna2 text-white">Telusuri</button>
               </div>
            </form>
           </div>
        </div>
    </div>
 
    <!-- Kategori -->
<div class="container-fluid py-5 owl-carousel">
    <div class="container text-center">
        <h3>Kategori Terlaris</h3>
        <div class="row mt-5">
            <div class="col-md-4 mb-3">
                <div class="highlighted-kategori kategori-realis d-flex justify-content-center align-items-center position-relative">
                    <div class="text-box">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Seni Lukis Realisme">Seni Lukis Realisme</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="highlighted-kategori kategori-abstrak d-flex justify-content-center align-items-center position-relative">
                    <div class="text-box">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Seni Lukis Abstrak ">Seni Lukis Abstrak</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="highlighted-kategori kategori-impresionis d-flex justify-content-center align-items-center position-relative">
                    <div class="text-box">
                        <h4 class="text-white"><a class="no-decoration"href="produk.php?kategori=Seni Lukis Impresionisme">Seni Lukis Impresionisme</a></h4>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>


<!-- tentang kami -->
<div class="container-fluid warna3 py-5">
    <div class="container text-center">
        <h3>Tentang Kami</h3>
        <p class="fs5-5 mt-3"> 
        Selamat datang di Art Gallery! Kami adalah destinasi
         seni yang menghadirkan keindahan dan inspirasi melalui 
         karya-karya lukisan yang memukau. Dengan bangga kami 
         mempersembahkan ruang yang memadukan keindahan visual
          dengan pengalaman mendalam bagi penggemar seni dan kolektor.
        </p>
    </div>
</div>

<!-- Produk -->

<div class="container-fluid py-5">
    <div class="container text-center">
        <h3>Produk Kami</h3>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-5"> 
            <?php while($produk = mysqli_fetch_assoc($queryProduk)){ ?>
            <div class="col mb-3">
                <div class="card h-100">
                    <div class="image-box">
                    <img src="image/<?php echo $produk['foto'];?>" class="card-img-top" alt="...">
                    </div>
                   
                    <div class="card-body d-flex flex-column justify-content-between">
                                                    <h4 class="card-title"><?php echo $produk['nama'];?></h4>
                                                    <p class="card-text text-truncate"><?php echo $produk['detail'];?></p>
                                                    <p class="card-text text-harga">Rp.<?php echo $produk['harga'];?></p>
                                                    <a href="produk-detail.php?nama=<?php echo $produk['nama'];?>" class="btn btn-block warna2 text-white stretched-link">Lihat Detail</a>
                                                </div>
                </div>
            </div>
            <!-- Menambahkan lebih banyak produk di sini -->
        <?php } ?>
        </div>
        <a class="btn warna2 mt-3 text-white" href="produk.php">Selengkapnya<i class="fas fa-arrow-right"></i></a>
    </div>
</div>


<!-- footer -->
<?php require "footer.php";?>
       
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>


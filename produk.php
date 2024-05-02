<?php 
    require "koneksi.php";
    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

    // get produk nama produk
    if(isset($_GET['keyword'])){
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
    }
 
    // get produk by kategori
    else if(isset($_GET['kategori'])){
        $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_assoc($queryGetKategoriId);
       
        $queryProduk =  mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$kategoriId[id]'");
    }
       
    // get produk default
    else{
        $queryProduk = mysqli_query($con, "SELECT * FROM produk");

    }

    $countData = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Gallery | Produk</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>

    <!-- body -->
    <style>
    .kategori-link {
        color: black; /* Ubah warna teks menjadi hitam */
        font-weight: bold; /* Jadikan teksnya tebal */
        text-decoration: none; /* Hilangkan garis bawah */
    }
</style>

            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-12 mb-5 text-center">
                        <h3>Daftar Kategori</h3><br>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <?php while($kategori = mysqli_fetch_assoc($queryKategori)) { ?>
                                            <td>
                                                <a class="kategori-link" href="produk.php?kategori=<?php echo $kategori['nama'];?>">
                                                    <?php echo $kategori['nama'];?>
                                                </a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="container-fluid py-5">
                            <div class="container text-center">
                                <h3>Produk Kami</h3>
                                <div class="row">
                                <?php 
                                if($countData<1){
                                ?>
                                    <div class="alert alert-warning mt-3 text-center" mt-3 role="alert">
                                    Produk Yang Anda Cari Tidak Tersedia
                                    </div>
                                <?php
                                    }
                                ?>
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
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

   
   <!-- footer -->
<?php require "footer.php";?>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>
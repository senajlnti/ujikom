<?php
    require "koneksi.php";

    $nama = htmlspecialchars($_GET['nama']);
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_assoc($queryProduk);
   
    $queryProdukTerkait = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='{$produk['kategori_id']}'");
    $produkTerkait = mysqli_fetch_assoc($queryProdukTerkait);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Gallery | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid py-5">
    <div class="col-lg-4 mb-5">
    <h2 class="text-center">Detail Produk</h2>
    </div>
        
        <div class="container">
            <div class="row">
            <div class="col-md-5 mb-5">
                <img src="image/<?php echo $produk['foto']; ?>" class="w-100 highlighted-kategori" alt="">
            </div>
            <div class="col-md-6 offset-md-1">
                <h1><?php echo $produk['nama']; ?></h1>
                <p class="fs-5"><?php echo $produk['detail']; ?>
                    </p>
                    <P class="text-harga">
                        Rp<?php echo $produk['harga']; ?>
                    </P>
                    <p class="fs-5">Status Ketersediaan : <strong><?php echo $produk['stok']; ?></strong></p>
                    <a href="https://wa.me/6289528918851?text=Halo,%20saya%20tertarik%20untuk%20memesan%20produk%20ini." class="btn warna2 text-white">
                        <i class="fab fa-whatsapp"></i> Pesan Sekarang
                    </a>



            </div>
            </div>     
        </div>
    </div>

    <!-- produk terkait -->
    <div class="container-fluid py-5 warna2">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>
            <div class="row">
                <?php while ($produkTerkait = mysqli_fetch_assoc($queryProdukTerkait)) : ?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="produk-detail.php?nama=<?php echo $produkTerkait['nama'];?>">
                    <img src="image/<?php echo $produkTerkait['foto']; ?>" class="img-fluid img-top img-thumbnail produk-terkait-image" alt="">
                    </a>
                </div>
                <?php endwhile; ?>
                

            </div>
        </div>
    </div>


    <!-- footer -->
<?php require "footer.php"; ?>
<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>

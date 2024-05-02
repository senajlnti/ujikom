<?php
require "session.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

// Menginisialisasi koneksi
require "../koneksi.php";

// Tambahkan kategori jika tombol "Tambah" ditekan
if(isset($_POST['tambah_kategori'])){
    $kategori = htmlspecialchars($_POST['kategori']);

    $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama='$kategori'");
    $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

    if($jumlahDataKategoriBaru > 0){
        // Kategori sudah ada, munculkan pesan peringatan
        echo '<div class="alert alert-warning" role="alert">Kategori Sudah Ada!</div>';
    }
    else{
        // Tambahkan kategori baru ke dalam database
        $queryTambah = mysqli_query($con, "INSERT INTO kategori (nama) VALUES ('$kategori')");
        if($queryTambah){
            // Refresh halaman agar data kategori terbaru ditampilkan
            header("Location: kategori.php");
            exit;
        } else {
            // Jika terjadi kesalahan saat menambahkan kategori
            echo '<div class="alert alert-danger" role="alert">Gagal menambahkan kategori!</div>';
        }
    } 
}

// Mendapatkan data kategori setelah penambahan
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Kategori</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/fontawesome.min.css">
</head>

<style>
     .no-decoration {
        text-decoration: none;
    }
</style>
<body>

<?php require "navbar.php"; ?>
<div class="container mt-5">
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item active" aria-current="page">
           <a href="../adminpanel" class="no-decoration text-muted"> <i class="fas fa-home"></i> Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
             Kategori
        </li>
        </ol>
     </nav>
     
     <div class="input-group mb-3 ">
            <form action="" method="post">
                <input type="text" class="form-control mt-3" placeholder="Tambah Kategori Baru" aria-label="Tambah Kategori Baru" aria-describedby="button-addon2" name="kategori">
                <button class="btn btn-primary mt-3" type="submit" name="tambah_kategori" id="button-addon2">Tambah</button>
            </form>
        </div>
        
     <div class="mt-3">
        <h2>List Kategori</h2>
       
        
        <div class="table-responsive mt-5">
            <table class="table">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Action</th> <!-- Kolom untuk aksi -->
                </tr>
                </thead>
                <tbody>
                    <?php
                    // Periksa jika ada data kategori
                    if ($jumlahKategori == 0) {
                    ?>
                        <tr>
                            <td colspan="3">Tidak Ada Data Kategori</td>
                        </tr>
                    <?php
                    } else {
                        $number = 1; // Variabel untuk nomor urut
                        // Loop untuk menampilkan data kategori
                        while ($kategori = mysqli_fetch_assoc($queryKategori)) {
                    ?>
                            <tr>
                                <td><?php echo $number++; ?></td>
                                <td><?php echo $kategori['nama']; ?></td>
                                <td>
                                    <!-- <a href="edit_kategori.php?p=<?php echo $kategori['id']; ?>" 
                                    class="btn btn-info"><i class="fas fa-pencil-alt"></i></a>

                                    <a href="hapus_kategori.php?p=<?php echo $kategori['id']; ?>"
                                    class="btn btn-info"><i class="fas fa-trash-alt"></i></a> -->

                                    <a href="kategori-detail.php?p=<?php echo $kategori['id']; ?>" 
                                    class="btn btn-info"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
     </div>
</div>

<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>
</html>

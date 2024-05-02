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

// Periksa apakah parameter id kategori telah diterima
if(isset($_GET['id'])){
    $kategori_id = $_GET['id'];

    // Query untuk mendapatkan informasi kategori berdasarkan id
    $query_kategori = mysqli_query($con, "SELECT * FROM kategori WHERE id = '$kategori_id'");
    $data_kategori = mysqli_fetch_assoc($query_kategori);
} else {
    // Jika tidak ada parameter id kategori, redirect ke halaman kategori.php
    header("Location: kategori.php");
    exit;
}

// Perbarui kategori jika tombol "Simpan Perubahan" ditekan
if(isset($_POST['simpan_perubahan'])){
    $kategori_baru = htmlspecialchars($_POST['kategori']);

    // Query untuk memperbarui nama kategori dalam database
    $query_update = mysqli_query($con, "UPDATE kategori SET nama = '$kategori_baru' WHERE id = '$kategori_id'");
    if($query_update){
        // Redirect kembali ke halaman kategori.php setelah perubahan berhasil disimpan
        header("Location: kategori.php");
        exit;
    } else {
        // Jika terjadi kesalahan saat memperbarui kategori
        echo '<div class="alert alert-danger" role="alert">Gagal memperbarui kategori!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin| Edit Kategori</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<?php require "navbar.php"; ?>
<div class="container mt-5">
    <h2>Edit Kategori</h2>
    <form action="" method="post">
        <div class="mb-3">
            <label for="kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $data_kategori['nama']; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="simpan_perubahan">Simpan Perubahan</button>
    </form>
</div>

<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

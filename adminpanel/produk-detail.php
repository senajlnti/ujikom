<?php
require "session.php";
require "../koneksi.php";

// Fungsi generateRandomString()
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$id_produk = $_GET['p'];

$query_produk = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id_produk'");
$produk_data = mysqli_fetch_assoc($query_produk);

// Tombol simpan ditekan
if (isset($_POST['simpan'])) {
    // Cek apakah ada file foto baru yang diunggah
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "../image/";
        $nama_file = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $nama_file;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];
        $random_name = generateRandomString(20);
        $new_name = $random_name . "." . $imageFileType;

        // Hapus foto lama dari direktori
        unlink($target_dir . $produk_data['foto']);

        // Pindahkan foto baru ke direktori
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

        // Perbarui nama file foto di database
        mysqli_query($con, "UPDATE produk SET foto='$new_name' WHERE id='$id_produk'");

        // Perbarui data produk dengan foto baru
        $produk_data['foto'] = $new_name;
    }
}

// Tombol hapus ditekan
if (isset($_POST['hapus'])) {
    // Hapus foto dari direktori
    unlink("../image/" . $produk_data['foto']);

    // Hapus produk dari database
    mysqli_query($con, "DELETE FROM produk WHERE id='$id_produk'");

    // Redirect ke halaman produk setelah penghapusan
    header("Location: produk.php");
    exit();
}
?>

<!-- Bagian HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Detail Produk</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <h2>Detail Produk</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mt-3">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $produk_data['nama']; ?>" readonly>
                </div>

                <div class="mt-3">
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $produk_data['nama_kategori']; ?>" readonly>
                </div>

                <div class="mt-3">
                    <label for="harga">Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control" value="<?php echo $produk_data['harga']; ?>" readonly>
                </div>

                <div class="mt-3">
                    <label for="currentFoto">Foto Produk</label><br>
                    <img src="../image/<?php echo $produk_data['foto']; ?>" alt="Foto Produk" style="max-width: 300px;">
                </div>

                <div class="mt-3">
                    <label for="foto">Ganti Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <div class="mt-3">
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control" readonly><?php echo $produk_data['detail']; ?></textarea>
                </div>

                <div class="mt-3">
                    <label for="stok">Stok</label>
                    <input type="text" name="stok" id="stok" class="form-control" value="<?php echo $produk_data['stok']; ?>" readonly>
                </div>

               <!-- Tambahkan tombol Edit -->
                <a href="edit-produk.php?p=<?php echo $produk_data['id']; ?>" class="btn btn-primary">Edit</a>

              

                <!-- Tombol untuk menyimpan perubahan -->
                <button type="submit" class="btn btn-success" name="simpan">Simpan Perubahan</button>

                <!-- Tombol untuk menghapus produk -->
                <button type="submit" class="btn btn-danger" name="hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
            </form>
        </div>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

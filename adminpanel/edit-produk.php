<?php
require "session.php";
require "../koneksi.php";

$id_produk = $_GET['p'];

$query_produk = mysqli_query($con, "SELECT * FROM produk WHERE id='$id_produk'");
$produk_data = mysqli_fetch_assoc($query_produk);

if(isset($_POST['simpan'])){
    // Ambil data dari form
    $nama = htmlspecialchars($_POST['nama']);
    $kategori_id = $_POST['kategori'];
    $harga = $_POST['harga'];
    $detail = $_POST['detail'];
    $stok = $_POST['stok'];

    // Query untuk memperbarui data produk dalam database
    $query_update = mysqli_query($con, "UPDATE produk SET nama='$nama', kategori_id='$kategori_id', harga='$harga', detail='$detail', stok='$stok' WHERE id='$id_produk'");
    if ($query_update) {
        // Redirect kembali ke halaman produk.php setelah perubahan berhasil disimpan
        header("Location: produk.php");
        exit;
    } else {
        // Jika terjadi kesalahan saat memperbarui produk
        echo '<div class="alert alert-danger" role="alert">Gagal memperbarui produk!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Produk</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<?php require "navbar.php"; ?>
<div class="container mt-5">
    <h2>Edit Produk</h2>
    <form action="" method="post">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $produk_data['nama']; ?>">
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <!-- Dropdown untuk pilihan kategori -->
            <select class="form-select" id="kategori" name="kategori">
                <?php
                // Query untuk mendapatkan daftar kategori
                $query_kategori = mysqli_query($con, "SELECT * FROM kategori");
                while($row_kategori = mysqli_fetch_assoc($query_kategori)){
                    // Tandai kategori yang dipilih dengan atribut 'selected'
                    $selected = ($produk_data['kategori_id'] == $row_kategori['id']) ? 'selected' : '';
                    echo "<option value='{$row_kategori['id']}' $selected>{$row_kategori['nama']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $produk_data['harga']; ?>">
        </div>
        <div class="mb-3">
            <label for="detail" class="form-label">Detail</label>
            <textarea class="form-control" id="detail" name="detail"><?php echo $produk_data['detail']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $produk_data['stok']; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="simpan">Simpan Perubahan</button>
    </form>
</div>

<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

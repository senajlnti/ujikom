<?php
require "session.php";
require "../koneksi.php";

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahProduk = mysqli_num_rows($query);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString; // Change $_randomString to $randomString
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Produk</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
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
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6">
                <div class="my-5">
                    <h3>Tambah Produk</h3>

                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" required>

                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="">Pilih Satu</option>
                            <?php
                            while ($kategori = mysqli_fetch_assoc($queryKategori)) {
                            ?>
                                <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['nama']; ?></option>
                            <?php
                            }
                            ?>
                        </select>

                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga" required>

                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">

                        <label for="detail">Detail</label>
                        <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>

                        <label for="stok">Stok</label>
                        <select name="stok" id="stok" class="form-control">
                            <option value="tersedia">Tersedia</option>
                            <option value="habis">Habis</option>
                        </select>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['simpan'])) {
                        $nama = htmlspecialchars($_POST['nama']);
                        $kategori = htmlspecialchars($_POST['kategori']);
                        $harga = htmlspecialchars($_POST['harga']);
                        $detail = htmlspecialchars($_POST['detail']);
                        $stok = htmlspecialchars($_POST['stok']);

                        $target_dir = "../image/";
                        $nama_file = basename($_FILES["foto"]["name"]);
                        $target_file = $target_dir . $nama_file;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        $image_size = $_FILES["foto"]["size"];
                        $random_name = generateRandomString(20);
                        $new_name = $random_name . "." . $imageFileType;

                        echo $target_dir . "<br>";
                        echo $nama_file . "<br>";
                        echo $target_file . "<br>";
                        echo $imageFileType . "<br>";
                        echo $image_size . "<br>";

                        if ($nama == '' || $kategori == '' || $harga == '') {
                    ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Nama, kategori dan harga wajib diisi!
                            </div>
                        <?php
                        } else {
                            if ($nama_file != '') {
                                if ($image_size > 500000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 500 Kb
                                    </div>
                                <?php
                                } else {
                                    if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                                ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            File wajib bertipe jpg, png atau gif
                                        </div>
                    <?php
                                    } else {
                                        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                                    }
                                }
                            }

                            //query insert to produk table
                            $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, stok) VALUES ('$kategori','$nama','$harga','$new_name','$detail','$stok')");

                            if ($queryTambah) {
                    ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Produk Berhasil Tersimpan
                                </div>
                    <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }
                    }
                    ?>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="my-5 mb-5">
                    <h3>List Produk</h3>

                    <div class="table-responsive mt-5">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Action</th> <!-- Kolom untuk aksi -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($jumlahProduk == 0) {
                                ?>
                                    <tr>
                                        <td colspan=6>Tidak Ada Data Produk</td>
                                    </tr>
                                    <?php
                                } else {
                                    $jumlah = 1;
                                    while ($produk = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $jumlah; ?></td>
                                            <td><?php echo $produk['nama']; ?></td>
                                            <td><?php echo $produk['nama_kategori']; ?></td>
                                            <td><?php echo $produk['harga']; ?></td>
                                            <td><?php echo $produk['stok']; ?></td>
                                            <td>
                                            <a href="produk-detail.php?p=<?php echo $produk['id']; ?>" 
                                    class="btn btn-info"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                <?php
                                        $jumlah++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>

</html>

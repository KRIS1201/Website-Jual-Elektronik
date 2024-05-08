<?php
include "template/header.php";

// Cek apakah id_transaksi telah diberikan melalui parameter GET
if (!isset($_GET['id_transaksi'])) {
    echo "ID Transaksi tidak diberikan.";
    exit();
}

// Ambil id_transaksi dari parameter GET
$id_transaksi = $_GET['id_transaksi'];

// Include file koneksi.php
include "koneksi.php";

// Cek apakah form telah dikirimkan untuk disimpan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_produk = $_POST['id_produk'];
    $kuantitas = $_POST['kuantitas'];

    // Query untuk melakukan update transaksi
    $sql_update = $pdo->prepare("UPDATE transaksipenjualan SET id_pelanggan = :id_pelanggan, id_produk = :id_produk, kuantitas = :kuantitas WHERE id_transaksi = :id_transaksi");
    $sql_update->bindParam(':id_pelanggan', $id_pelanggan);
    $sql_update->bindParam(':id_produk', $id_produk);
    $sql_update->bindParam(':kuantitas', $kuantitas);
    $sql_update->bindParam(':id_transaksi', $id_transaksi);

    // Eksekusi query update
    if ($sql_update->execute()) {
        // Jika update berhasil, redirect ke halaman view_transaksi.php
        echo "<a href='view_transaksi.php'>kembali</a>";
        exit();
    } else {
        echo "Terjadi kesalahan saat melakukan update transaksi.";
    }
}

// Query untuk mendapatkan data transaksi berdasarkan id_transaksi
$sql_transaksi = $pdo->prepare("SELECT * FROM transaksipenjualan WHERE id_transaksi = :id_transaksi");
$sql_transaksi->bindParam(':id_transaksi', $id_transaksi);
$sql_transaksi->execute();
$data_transaksi = $sql_transaksi->fetch();

// Query untuk mendapatkan data pelanggan
$sql_pelanggan = $pdo->prepare("SELECT id_pelanggan, nama_pelanggan FROM pelanggan");
$sql_pelanggan->execute();
$data_pelanggan = $sql_pelanggan->fetchAll();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Transaksi</h1>

    <div class="row">
        <div class="col-lg-6">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Transaksi</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <input type="hidden" name="id_transaksi" value="<?php echo $data_transaksi['id_transaksi']; ?>">

                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <select class="form-control" name="id_pelanggan">
                                <?php foreach ($data_pelanggan as $pelanggan) : ?>
                                    <option value="<?php echo $pelanggan['id_pelanggan']; ?>" <?php if ($pelanggan['id_pelanggan'] == $data_transaksi['id_pelanggan']) echo 'selected'; ?>>
                                        <?php echo $pelanggan['nama_pelanggan']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <select class="form-control" name="id_produk">
                                <?php
                                // Query untuk mendapatkan data produk
                                $sql_produk = $pdo->prepare("SELECT id_produk, nama_produk FROM produk");
                                $sql_produk->execute();
                                $data_produk = $sql_produk->fetchAll();

                                // Loop untuk menampilkan opsi produk
                                foreach ($data_produk as $produk) :
                                ?>
                                    <option value="<?php echo $produk['id_produk']; ?>" <?php if ($produk['id_produk'] == $data_transaksi['id_produk']) echo 'selected'; ?>>
                                        <?php echo $produk['nama_produk']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Kuantitas</label>
                            <input type="text" class="form-control" name="kuantitas" value="<?php echo $data_transaksi['kuantitas']; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="view_transaksi.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include 'template/footer.php';
?>
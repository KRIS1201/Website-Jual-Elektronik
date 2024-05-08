<?php
include "template/header.php";

// Include file koneksi.php
include "koneksi.php";

// Query untuk mendapatkan data pelanggan
$sql_pelanggan = $pdo->prepare("SELECT id_pelanggan, nama_pelanggan FROM pelanggan");
$sql_pelanggan->execute();
$data_pelanggan = $sql_pelanggan->fetchAll();

// Query untuk mendapatkan data produk
$sql_produk = $pdo->prepare("SELECT id_produk, nama_produk FROM produk");
$sql_produk->execute();
$data_produk = $sql_produk->fetchAll();

// Cek apakah form telah dikirimkan untuk disimpan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_produk = $_POST['id_produk'];
    $kuantitas = $_POST['kuantitas'];
    $tanggal_transaksi = date("Y-m-d H:i:s");

    $sql_produk_detail = $pdo->prepare("SELECT harga FROM produk WHERE id_produk = :id_produk");
    $sql_produk_detail->bindParam(':id_produk', $id_produk);
    $sql_produk_detail->execute();
    $produk_detail = $sql_produk_detail->fetch();
    $harga = $produk_detail['harga'];
    $total_harga = $harga * $kuantitas;

    // Query untuk menyimpan transaksi baru
    $sql_insert = $pdo->prepare("INSERT INTO transaksipenjualan (id_pelanggan, id_produk, kuantitas, total_harga, tanggal_transaksi) VALUES (:id_pelanggan, :id_produk, :kuantitas, :total_harga, :tanggal_transaksi)");
    $sql_insert->bindParam(':id_pelanggan', $id_pelanggan);
    $sql_insert->bindParam(':id_produk', $id_produk);
    $sql_insert->bindParam(':kuantitas', $kuantitas);
    $sql_insert->bindParam(':total_harga', $total_harga);
    $sql_insert->bindParam(':tanggal_transaksi', $tanggal_transaksi);

    // Eksekusi query insert
    if ($sql_insert->execute()) {
        // Jika berhasil disimpan, redirect ke halaman view_transaksi.php
        echo "Data berhasil disimpan";
        echo "<a href='view_transaksi.php'>kembali</a>";
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan transaksi.";
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Transaksi</h1>

    <div class="row">
        <div class="col-lg-6">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Transaksi</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <select class="form-control" name="id_pelanggan">
                                <?php foreach ($data_pelanggan as $pelanggan): ?>
                                    <option value="<?php echo $pelanggan['id_pelanggan']; ?>"><?php echo $pelanggan['nama_pelanggan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <select class="form-control" name="id_produk">
                                <?php foreach ($data_produk as $produk): ?>
                                    <option value="<?php echo $produk['id_produk']; ?>"><?php echo $produk['nama_produk']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kuantitas</label>
                            <input type="text" class="form-control" name="kuantitas">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="view_transaksi.php" class="btn btn-secondary">Batal</a>
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

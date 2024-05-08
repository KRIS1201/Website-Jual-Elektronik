<?php
// Load file koneksi.php
include "template/header.php";
include "koneksi.php";

// Inisialisasi variabel untuk menampung pesan hasil proses
$pesan = '';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirim melalui form
    $id_produk = $_GET['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];

    // Panggil stored procedure untuk mengubah data produk
    $stmt = $pdo->prepare("CALL update_produk(:id_produk, :nama_produk, :harga, :stock)");
    $stmt->bindParam(':id_produk', $id_produk, PDO::PARAM_INT);
    $stmt->bindParam(':nama_produk', $nama_produk, PDO::PARAM_STR);
    $stmt->bindParam(':harga', $harga, PDO::PARAM_STR);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->execute();

    // Periksa apakah proses perubahan berhasil atau tidak
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result = true) {
        $pesan = "Data produk berhasil diubah.";
    } else {
        $pesan = "Gagal mengubah data produk.";
    }
}

// Ambil data produk berdasarkan ID yang dikirim melalui URL
$id_produk = $_GET['id_produk'];
$sql_produk = $pdo->prepare("SELECT * FROM produk WHERE id_produk = :id_produk");
$sql_produk->bindParam(':id_produk', $id_produk, PDO::PARAM_INT);
$sql_produk->execute();
$data_produk = $sql_produk->fetch(PDO::FETCH_ASSOC);
?>

<h1>Update Data Produk</h1>

<?php
// Tampilkan pesan hasil proses 
if ($pesan != '') {
    echo "<div>$pesan</div>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_produk=" . $id_produk; ?>">
    <table cellpadding="8">
        <tr>
            <td>Nama Produk</td>
            <td><input type="text" name="nama_produk" value="<?php echo $data_produk['nama_produk']; ?>"></td>
        </tr>
        <tr>
            <td>Harga</td>
            <td><input type="text" name="harga" value="<?php echo $data_produk['harga']; ?>"></td>
        </tr>
        <tr>
            <td>Stock</td>
            <td><input type="text" name="stock" value="<?php echo $data_produk['stock']; ?>"></td>
        </tr>
    </table>
    <hr>

    <button type='submit' class="btn btn-success btn-icon-split">
        <span class='icon text-white-50'>
            <i class='fas fa-check'></i>
        </span>
        <span class='text'>Update</span>
    </button>
    <a href='index.php' class='btn btn-danger btn-icon-split'>
        <span class='icon text-white-50'>
            <i class='fas fa-trash'></i>
        </span>
        <span class='text'>Batal</span>
    </a>
</form>
<?php
include "template/footer.php";
?>

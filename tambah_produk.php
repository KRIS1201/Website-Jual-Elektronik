<?php
// Include file koneksi.php
include "template/header.php";
include "koneksi.php";

// Inisialisasi variabel untuk menampung pesan hasil proses
$pesan = '';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirim melalui form
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];

    // Panggil stored procedure untuk menambahkan produk
    $stmt = $pdo->prepare("CALL tambah_produk(:nama_produk, :harga, :stock)");
    $stmt->bindParam(':nama_produk', $nama_produk, PDO::PARAM_STR);
    $stmt->bindParam(':harga', $harga, PDO::PARAM_STR);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->execute();

    // Periksa apakah proses penambahan berhasil atau tidak
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result = true) {
        $pesan = "Produk berhasil ditambahkan.";
    } else {
        $pesan = "Gagal menambahkan produk.";
    }
}
?>

<h1>Tambah Data Produk</h1>

<?php
// Tampilkan pesan hasil proses jika ada
if ($pesan != '') {
    echo "<div>$pesan</div>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <table class="table table-bordered" id="dataTable" width="75%" cellspacing="0">
        <tr>
            <td>Nama Produk</td>
            <td><input type="text" name="nama_produk"></td>
        </tr>
        <tr>
            <th>Harga</th>
            <td><input type="text" name="harga"></td>
        </tr>
        <tr>
            <td>Stock</td>
            <td><input type="text" name="stock"></td>
        </tr>
    </table>
    <hr>

    <button type='submit' class="btn btn-success btn-icon-split">
        <span class='icon text-white-50'>
            <i class='fas fa-check'></i>
        </span>
        <span class='text'>Simpan</span>
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
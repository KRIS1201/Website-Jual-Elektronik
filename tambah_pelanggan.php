<?php
include "template/header.php";
include "koneksi.php";

$pesan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data pelanggan yang dikirim melalui form
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];

    // Query untuk menambahkan data pelanggan ke dalam tabel
    $stmt = $pdo->prepare("INSERT INTO pelanggan (nama_pelanggan, alamat) VALUES (:nama_pelanggan, :alamat)");
    $stmt->bindParam(':nama_pelanggan', $nama_pelanggan, PDO::PARAM_STR);
    $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR);
    $stmt->execute();

    // Set pesan sukses jika penambahan berhasil
    $pesan = "Data pelanggan berhasil ditambahkan.";
}
?>

<h1>Tambah Data Pelanggan</h1>

<?php
if ($pesan != '') {
    echo "<div>$pesan</div>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <table cellpadding="8">
        <tr>
            <td>Nama Pelanggan</td>
            <td><input type="text" name="nama_pelanggan"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><input type="text" name="alamat"></td>
        </tr>
    </table>
    <hr>

    <button type='submit' class="btn btn-success btn-icon-split">
        <span class='icon text-white-50'>
            <i class='fas fa-check'></i>
        </span>
        <span class='text'>Simpan</span>
    </button>
    <a href='view_pelanggan.php' class='btn btn-danger btn-icon-split'>
        <span class='icon text-white-50'>
            <i class='fas fa-trash'></i>
        </span>
        <span class='text'>Batal</span>
    </a>
</form>

<?php
include "template/footer.php";
?>
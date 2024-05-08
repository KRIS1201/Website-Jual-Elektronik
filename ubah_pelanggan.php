<?php
include "template/header.php";
include "koneksi.php";

$pesan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = $_GET['id_pelanggan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];

    $stmt = $pdo->prepare("UPDATE pelanggan SET nama_pelanggan = :nama_pelanggan, alamat = :alamat WHERE id_pelanggan = :id_pelanggan");
    $stmt->bindParam(':id_pelanggan', $id_pelanggan, PDO::PARAM_INT);
    $stmt->bindParam(':nama_pelanggan', $nama_pelanggan, PDO::PARAM_STR);
    $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR);
    $stmt->execute();

    $pesan = "Data pelanggan berhasil diubah.";
}

$id_pelanggan = $_GET['id_pelanggan'];
$sql_pelanggan = $pdo->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = :id_pelanggan");
$sql_pelanggan->bindParam(':id_pelanggan', $id_pelanggan, PDO::PARAM_INT);
$sql_pelanggan->execute();
$data_pelanggan = $sql_pelanggan->fetch(PDO::FETCH_ASSOC);
?>

<h1>Update Data Pelanggan</h1>

<?php
if ($pesan != '') {
    echo "<div>$pesan</div>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_pelanggan=" . $id_pelanggan; ?>">
    <table cellpadding="8">
        <tr>
            <td>Nama Pelanggan</td>
            <td><input type="text" name="nama_pelanggan" value="<?php echo $data_pelanggan['nama_pelanggan']; ?>"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><input type="text" name="alamat" value="<?php echo $data_pelanggan['alamat']; ?>"></td>
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
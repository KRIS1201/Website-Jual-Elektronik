<?php
// Include file koneksi.php
include "koneksi.php";

// Cek apakah parameter id_produk telah diterima dari URL
if (isset($_GET['id_produk'])) {
    $id_produk = $_GET['id_produk'];

    // Panggil function hapus_produk dengan parameter id_produk
    $stmt = $pdo->prepare("SELECT hapus_produk(:id_produk) AS result");
    $stmt->bindParam(':id_produk', $id_produk, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['result'] == 1) {
        header("Location: view_produk.php");
        exit();
    } else {
        echo "Gagal menghapus produk.";
    }
} else {
    echo "Parameter id_produk tidak ditemukan.";
}
?>

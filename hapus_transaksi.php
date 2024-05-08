<?php
include "koneksi.php";

// Cek apakah id_transaksi telah diberikan melalui parameter GET
if (!isset($_GET['id_transaksi'])) {
    echo "ID Transaksi tidak diberikan.";
    exit();
}

// Ambil id_transaksi dari parameter GET
$id_transaksi = $_GET['id_transaksi'];

// Query untuk menghapus transaksi berdasarkan id_transaksi
$sql_delete = $pdo->prepare("DELETE FROM transaksipenjualan WHERE id_transaksi = :id_transaksi");
$sql_delete->bindParam(':id_transaksi', $id_transaksi);


if ($sql_delete->execute()) {
    header("Location: view_transaksi.php");
    exit();
} else {
    echo "Terjadi kesalahan saat menghapus transaksi.";
}
?>

<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_pelanggan'])) {
    // Ambil ID pelanggan dari parameter URL
    $id_pelanggan = $_GET['id_pelanggan'];

    // Query untuk menghapus data pelanggan berdasarkan ID
    $stmt = $pdo->prepare("DELETE FROM pelanggan WHERE id_pelanggan = :id_pelanggan");
    $stmt->bindParam(':id_pelanggan', $id_pelanggan, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect kembali ke halaman view_pelanggan.php setelah penghapusan selesai
    header("Location: view_pelanggan.php");
    exit();
} else {
    // Redirect ke halaman view_pelanggan.php jika tidak ada ID pelanggan yang diberikan
    header("Location: view_pelanggan.php");
    exit();
}
?>

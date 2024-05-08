<?php
// Memulai session
session_start();

// Memasukkan file koneksi database
include "koneksi.php";

// Cek apakah form login telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memeriksa apakah username dan password telah diisi
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM admin WHERE username = :username AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION["admin_id"] = $row['admin_id'];
            $_SESSION["username"] = $row['username'];
            header("location: index.php");
            exit();
        } else {
            $error = "Username atau password salah.";
        }
    } else {
        $error = "Silakan masukkan username dan password.";
    }
}
?>
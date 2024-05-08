<?php
// Include file koneksi.php
include "koneksi.php";

// Tangkap data yang dikirimkan dari form
$username = $_POST['username'];
$password = $_POST['password'];
$nama_lengkap = $_POST['nama_lengkap'];

// Query untuk mengecek apakah username sudah ada dalam database
$sql_check = "SELECT * FROM admin WHERE username='$username'";
$result_check = $pdo->query($sql_check);

// Cek apakah username sudah digunakan
if ($result_check->rowCount() > 0) {
    // Jika sudah, tampilkan pesan kesalahan dan redirect kembali ke halaman registrasi
    echo "<script>alert('Username already exists. Please choose another username.');</script>";
    echo "<script>window.location.href='register.php';</script>";
} else {

    // Query untuk menyimpan data pengguna ke database
    $sql_register = "INSERT INTO admin (username, password, nama_lengkap) VALUES (:username, :password, :nama_lengkap)";
    $stmt = $pdo->prepare($sql_register);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':nama_lengkap', $nama_lengkap);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful. You can now login.');</script>";
        echo "<script>window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed. Please try again.');</script>";
        echo "<script>window.location.href='register.php';</script>";
    }
}
?>

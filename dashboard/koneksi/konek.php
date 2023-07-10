<?php
$servername = "localhost";
$database = "quakaltaradb";
$username = "root";
$password = "makanminggu12";

// untuk tulisan bercetak tebal silakan sesuaikan dengan detail database Anda
// membuat koneksi
$link = mysqli_connect($servername, $username, $password, $database);
// mengecek koneksi
if (!$link) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// echo "Koneksi berhasil";
// mysqli_close($link);
?>
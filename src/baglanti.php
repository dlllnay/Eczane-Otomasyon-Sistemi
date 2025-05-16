<?php
$host = "localhost";
$kullanici = "root";
$sifre = "";
$veritabani = "eczanevt";

$conn = new mysqli($host, $kullanici, $sifre, $veritabani);
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}
?>
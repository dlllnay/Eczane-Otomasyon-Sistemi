<?php
session_start();
include("baglanti.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["personelID"])) {
    header("Location: login.php");
    exit;
}

$personelAd = $_SESSION["personelAd"] ?? 'Personel';

// Formdan veri geldiyse veritabanına ekle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST["ad"];
    $soyad = $_POST["soyad"];
    $unvan = $_POST["unvan"];
    $telefon = $_POST["telefon"];
    $kullaniciAdi = $_POST["kullaniciAdi"];
    $sifre = $_POST["sifre"];

    $ekle = $conn->prepare("INSERT INTO Personel 
        (Personel_Ad, Personel_Soyad, Unvan, CepNo, Maas, KullaniciAdi, Sifre, IseGirisTarihi)
        VALUES (?, ?, ?, ?, 0.00, ?, ?, CURDATE())");

    $ekle->bind_param("ssssss", $ad, $soyad, $unvan, $telefon, $kullaniciAdi, $sifre);
    $ekle->execute();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Personel Listesi</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      display: flex;
      height: 100vh;
      background-color: #f1f5fb;
    }

    .sidebar {
      width: 220px;
      background-color: #4755e2;
      color: white;
      padding: 20px 0;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .menu-item {
      padding: 15px 25px;
      text-decoration: none;
      color: white;
      display: block;
      transition: background 0.3s;
    }

    .menu-item:hover {
      background-color: #3c49c9;
    }

    .content {
      flex: 1;
      padding: 40px;
      overflow-y: auto;
    }

    h2 {
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #f5f5f5;
    }

    .ekle-formu {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .ekle-formu input {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .ekle-formu button {
      background-color: #4755e2;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

  </style>
</head>
<body>

<div class="sidebar">
  <h2>Eczane</h2>
  <a href="anasayfa.php" class="menu-item">🏠 Ana Sayfa</a>
  <a href="personel.php" class="menu-item">👤 Personel</a>
  <a href="ilaclar.php" class="menu-item">💊 İlaçlar</a>
  <a href="stok.php" class="menu-item">📦 Stok</a>
  <a href="satis.php" class="menu-item">🧾 Satış</a>
  <a href="logout.php" class="menu-item">🚪 Çıkış Yap</a>
</div>

<div class="content">
  <h2>👥 Personel Listesi</h2>

  <div class="ekle-formu">
    <form method="POST">
      <input type="text" name="ad" placeholder="Ad" required>
      <input type="text" name="soyad" placeholder="Soyad" required>
      <input type="text" name="unvan" placeholder="Ünvan" required>
      <input type="text" name="telefon" placeholder="Telefon" required>
      <input type="text" name="kullaniciAdi" placeholder="Kullanıcı Adı" required>
      <input type="text" name="sifre" placeholder="Şifre" required>
      <button type="submit">➕ Personel Ekle</button>
    </form>
  </div>

  <table>
    <tr>
      <th>ID</th>
      <th>Ad</th>
      <th>Soyad</th>
      <th>Ünvan</th>
      <th>Telefon</th>
      <th>Kullanıcı Adı</th>
    </tr>

    <?php
    $sorgu = $conn->query("SELECT * FROM Personel");
    while ($satir = $sorgu->fetch_assoc()) {
        echo "<tr>
                <td>{$satir['Personel_ID']}</td>
                <td>{$satir['Personel_Ad']}</td>
                <td>{$satir['Personel_Soyad']}</td>
                <td>{$satir['Unvan']}</td>
                <td>{$satir['CepNo']}</td>
                <td>{$satir['KullaniciAdi']}</td>
              </tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
<?php
session_start();
include("baglanti.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["personelID"])) {
    header("Location: login.php");
    exit;
}

// Ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barkod = $_POST["barkod"];
    $urunAd = $_POST["urunAd"];
    $etkenMadde = $_POST["etkenMadde"];
    $atc = $_POST["atc"];
    $ruhsatNo = $_POST["ruhsatNo"];
    $kullanimYasi = $_POST["kullanimYasi"];
    $receteTuru = $_POST["receteTuru"];
    $fiyat = $_POST["fiyat"];

    $ekle = $conn->prepare("INSERT INTO Ilac 
    (Barkod, Urun_Ad, EtkenMadde, ATCKodu, RuhsatNo, KullanimYasi, ReceteTuru, Fiyat)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $ekle->bind_param("sssssssd", $barkod, $urunAd, $etkenMadde, $atc, $ruhsatNo, $kullanimYasi, $receteTuru, $fiyat);
    $ekle->execute();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>İlaçlar</title>
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

    .form {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .form input {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .form button {
      background-color: #4755e2;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      margin-top: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #f5f5f5;
    }
  </style>
</head>
<body>

<!-- Sol Menü -->
<div class="sidebar">
  <h2>Eczane</h2>
  <a href="anasayfa.php" class="menu-item">🏠 Ana Sayfa</a>
  <a href="personel.php" class="menu-item">👤 Personel</a>
  <a href="ilaclar.php" class="menu-item">💊 İlaçlar</a>
  <a href="stok.php" class="menu-item">📦 Stok</a>
  <a href="satis.php" class="menu-item">🧾 Satış</a>
  <a href="logout.php" class="menu-item">🚪 Çıkış Yap</a>
</div>

<!-- İçerik -->
<div class="content">
  <h2>💊 İlaç Listesi</h2>

  <div class="form">
    <form method="POST">
      <input type="text" name="barkod" placeholder="Barkod" required>
      <input type="text" name="urunAd" placeholder="Ürün Adı" required>
      <input type="text" name="etkenMadde" placeholder="Etken Madde" required>
      <input type="text" name="atc" placeholder="ATC Kodu" required>
      <input type="text" name="ruhsatNo" placeholder="Ruhsat No" required>
      <input type="text" name="kullanimYasi" placeholder="Kullanım Yaşı" required>
      <input type="text" name="receteTuru" placeholder="Reçete Türü" required>
      <input type="number" step="0.01" name="fiyat" placeholder="Fiyat (₺)" required>
      <button type="submit">➕ İlaç Ekle</button>
    </form>
  </div>

  <table>
    <tr>
      <th>ID</th>
      <th>Barkod</th>
      <th>Ürün Adı</th>
      <th>Etken Madde</th>
      <th>ATC</th>
      <th>Ruhsat</th>
      <th>Kullanım Yaşı</th>
      <th>Reçete Türü</th>
      <th>Fiyat</th>
    </tr>

    <?php
    $sorgu = $conn->query("SELECT * FROM Ilac");
    while ($satir = $sorgu->fetch_assoc()) {
        echo "<tr>
                <td>{$satir['Ilac_ID']}</td>
                <td>{$satir['Barkod']}</td>
                <td>{$satir['Urun_Ad']}</td>
                <td>{$satir['EtkenMadde']}</td>
                <td>{$satir['ATCKodu']}</td>
                <td>{$satir['RuhsatNo']}</td>
                <td>{$satir['KullanimYasi']}</td>
                <td>{$satir['ReceteTuru']}</td>
                <td>₺{$satir['Fiyat']}</td>
              </tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
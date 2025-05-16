<?php
session_start();
include("baglanti.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["personelID"])) {
    header("Location: login.php");
    exit;
}

// Stok ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ilacID = $_POST["ilacID"];
    $tedarikciID = $_POST["tedarikciID"];
    $eczaneID = 1; // Tek eczane için sabit
    $adet = $_POST["adet"];
    $alimTarihi = $_POST["alimTarihi"];
    $uretimTarihi = $_POST["uretimTarihi"];
    $skt = $_POST["skt"];

    $ekle = $conn->prepare("INSERT INTO Stok (Ilac_ID, Eczane_ID, Tedarikci_ID, Adet, AlimTarihi, UretimTarihi, SKT)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $ekle->bind_param("iiissss", $ilacID, $eczaneID, $tedarikciID, $adet, $alimTarihi, $uretimTarihi, $skt);
    $ekle->execute();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Stok Takibi</title>
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

    .form select,
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

    tr.low-stock {
      background-color: #fff3cd;
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
  <h2>📦 Stok Takibi</h2>

  <div class="form">
    <form method="POST">
      <select name="ilacID" required>
        <option value="">İlaç Seç</option>
        <?php
        $ilaclar = $conn->query("SELECT Ilac_ID, Urun_Ad FROM Ilac");
        while ($row = $ilaclar->fetch_assoc()) {
            echo "<option value='{$row['Ilac_ID']}'>{$row['Urun_Ad']}</option>";
        }
        ?>
      </select>

      <select name="tedarikciID" required>
        <option value="">Tedarikçi Seç</option>
        <?php
        $tedarikciler = $conn->query("SELECT Tedarikci_ID, Tedarikci_Ad FROM Tedarikci");
        while ($row = $tedarikciler->fetch_assoc()) {
            echo "<option value='{$row['Tedarikci_ID']}'>{$row['Tedarikci_Ad']}</option>";
        }
        ?>
      </select>

      <input type="number" name="adet" placeholder="Adet" required>
      <input type="date" name="alimTarihi" required>
      <input type="date" name="uretimTarihi" required>
      <input type="date" name="skt" required>
      <button type="submit">➕ Stok Ekle</button>
    </form>
  </div>

  <table>
    <tr>
      <th>Stok ID</th>
      <th>İlaç</th>
      <th>Tedarikçi</th>
      <th>Adet</th>
      <th>Alım Tarihi</th>
      <th>SKT</th>
            <th>Üretim Tarihi</th>

    </tr>

    <?php
    $stoklar = $conn->query("
      SELECT s.Stok_ID, i.Urun_Ad, t.Tedarikci_Ad, s.Adet, s.AlimTarihi, s.SKT, s.UretimTarihi
      FROM Stok s
      JOIN Ilac i ON s.Ilac_ID = i.Ilac_ID
      JOIN Tedarikci t ON s.Tedarikci_ID = t.Tedarikci_ID
    ");

    while ($s = $stoklar->fetch_assoc()) {
        $class = ($s["Adet"] < 10) ? "low-stock" : "";
        echo "<tr class='$class'>
                <td>{$s['Stok_ID']}</td>
                <td>{$s['Urun_Ad']}</td>
                <td>{$s['Tedarikci_Ad']}</td>
                <td>{$s['Adet']}</td>
                <td>{$s['AlimTarihi']}</td>
                <td>{$s['SKT']}</td>
                <td>{$s['UretimTarihi']}</td>
              </tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
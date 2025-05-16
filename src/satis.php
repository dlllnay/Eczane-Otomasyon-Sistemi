<?php
session_start();
include("baglanti.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["personelID"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hastaID = $_POST["hastaID"];
    $receteID = $_POST["receteID"] !== "" ? $_POST["receteID"] : null;
    $ilacID = $_POST["ilacID"];

    // İlaç türünü al
    $ilacTurSorgu = $conn->prepare("SELECT Fiyat, ReceteTuru FROM Ilac WHERE Ilac_ID = ?");
    $ilacTurSorgu->bind_param("i", $ilacID);
    $ilacTurSorgu->execute();
    $ilac = $ilacTurSorgu->get_result()->fetch_assoc();

    if (!$ilac) {
        echo "<script>alert('Seçilen ilaca ulaşılamadı.');</script>";
        exit;
    }

    $normalFiyat = $ilac["Fiyat"];
    $receteTuru = $ilac["ReceteTuru"];

    $receteGerekliTurler = ["Kırmızı", "Yeşil"];
    if (in_array($receteTuru, $receteGerekliTurler) && $receteID === null) {
        echo "<script>alert('Bu ilaç için reçete gereklidir. Lütfen reçete seçiniz.');</script>";
        exit;
    }

    $sigortaSorgu = $conn->prepare("SELECT SigortaTuru FROM Hasta WHERE Hasta_ID = ?");
    $sigortaSorgu->bind_param("i", $hastaID);
    $sigortaSorgu->execute();
    $sigortaSonuc = $sigortaSorgu->get_result()->fetch_assoc();
    $sigorta = $sigortaSonuc["SigortaTuru"] ?? null;

    $oran = 0.0;
    if ($sigorta && $receteID != null) {
        if ($sigorta == "SGK") $oran = 0.80;
        else if ($sigorta == "Özel") $oran = 0.50;
    }

    $indirimliFiyat = $normalFiyat * (1 - $oran);
    $satisFiyati = ($oran > 0) ? $indirimliFiyat : $normalFiyat;

    $ilacAdeti = 1;
    $odemeTipi = "Nakit";

    $ekle = $conn->prepare("INSERT INTO Receteli_Ilac 
        (Recete_ID, Ilac_ID, Ilac_Adeti, OdemeTipi, SatisFiyati, NormalFiyat, IndirimliFiyat, SigortaKarsilamaOrani)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $ekle->bind_param("iiissddd", $receteID, $ilacID, $ilacAdeti, $odemeTipi, $satisFiyati, $normalFiyat, $indirimliFiyat, $oran);
    $ekle->execute();

    $stokDus = $conn->prepare("UPDATE Stok SET Adet = Adet - 1 WHERE Ilac_ID = ? AND Adet > 0");
    $stokDus->bind_param("i", $ilacID);
    $stokDus->execute();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Satış</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
    body { display: flex; background-color: #f1f5fb; }
    .sidebar {
      width: 220px; background-color: #4755e2; color: white; padding: 20px 0; height: 100vh;
    }
    .sidebar h2 { text-align: center; margin-bottom: 30px; }
    .menu-item {
      padding: 15px 25px; text-decoration: none; color: white; display: block; transition: background 0.3s;
    }
    .menu-item:hover { background-color: #3c49c9; }

    .content {
      flex: 1; padding: 40px; overflow-y: auto;
    }

    form {
      background-color: white; padding: 20px; border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05); max-width: 600px; margin-bottom: 30px;
    }

    form select, form input {
      width: 100%; padding: 10px; margin-bottom: 12px;
      border: 1px solid #ccc; border-radius: 8px;
    }

    form button {
      background-color: #4755e2; color: white; padding: 10px 20px;
      border: none; border-radius: 8px; cursor: pointer;
    }

    table {
      width: 100%; background: white; border-collapse: collapse;
      border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05);
      margin-top: 30px;
    }

    th, td {
      padding: 12px; text-align: left; border-bottom: 1px solid #eee;
    }

    th { background-color: #f5f5f5; }
    .fiyat { font-weight: bold; font-size: 18px; color: #2e2e2e; margin-top: 10px; }
  </style>

  <script>
    function fiyatHesapla() {
      const ilacFiyat = parseFloat(document.querySelector("select[name='ilacID'] option:checked").getAttribute("data-fiyat"));
      const sigorta = document.querySelector("select[name='hastaID'] option:checked").getAttribute("data-sigorta");
      const receteVar = document.querySelector("select[name='receteID']").value !== "";

      let oran = 0;
      if (sigorta === "SGK" && receteVar) oran = 0.80;
      else if (sigorta === "Özel" && receteVar) oran = 0.50;

      let indirimli = ilacFiyat * (1 - oran);
      let sonuc = (oran > 0) ? indirimli : ilacFiyat;

      document.getElementById("fiyatGoster").innerText = "Satış Fiyatı: ₺" + sonuc.toFixed(2);
    }
  </script>
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
  <h2>🧾 Satış İşlemi</h2>

  <form method="POST">
    <select name="hastaID" required onchange="fiyatHesapla()">
      <option value="">Hasta Seç</option>
      <?php
      $hastalar = $conn->query("SELECT * FROM Hasta");
      while ($h = $hastalar->fetch_assoc()) {
          echo "<option value='{$h['Hasta_ID']}' data-sigorta='{$h['SigortaTuru']}'>{$h['Hasta_Ad']} {$h['Hasta_Soyad']}</option>";
      }
      ?>
    </select>

    <select name="receteID" onchange="fiyatHesapla()">
      <option value="">Reçete Seç (Opsiyonel)</option>
      <?php
      $receteler = $conn->query("SELECT Recete_ID FROM Recete");
      while ($r = $receteler->fetch_assoc()) {
          echo "<option value='{$r['Recete_ID']}'>Reçete #{$r['Recete_ID']}</option>";
      }
      ?>
    </select>

    <select name="ilacID" required onchange="fiyatHesapla()">
      <option value="">İlaç Seç</option>
      <?php
      $ilaclar = $conn->query("SELECT Ilac_ID, Urun_Ad, Fiyat FROM Ilac");
      while ($i = $ilaclar->fetch_assoc()) {
          echo "<option value='{$i['Ilac_ID']}' data-fiyat='{$i['Fiyat']}'>{$i['Urun_Ad']}</option>";
      }
      ?>
    </select>

    <div class="fiyat" id="fiyatGoster">Satış Fiyatı: ₺0.00</div>
    <button type="submit">💾 Satışı Kaydet</button>
  </form>

  <h3>📋 Son Yapılan Satışlar</h3>
  <table>
    <tr>
      <th>Satış ID</th>
      <th>İlaç</th>
      <th>Reçete</th>
      <th>Satış Fiyatı</th>
      <th>Tarih</th>
    </tr>
    <?php
    $satislar = $conn->query("
      SELECT ri.Receteli_Ilac_ID, i.Urun_Ad, ri.SatisFiyati, ri.Recete_ID, r.Tarih
      FROM Receteli_Ilac ri
      LEFT JOIN Ilac i ON ri.Ilac_ID = i.Ilac_ID
      LEFT JOIN Recete r ON ri.Recete_ID = r.Recete_ID
      ORDER BY ri.Receteli_Ilac_ID DESC LIMIT 5
    ");

    while ($s = $satislar->fetch_assoc()) {
        echo "<tr>
                <td>{$s['Receteli_Ilac_ID']}</td>
                <td>{$s['Urun_Ad']}</td>
                <td>" . ($s['Recete_ID'] ?? 'Reçetesiz') . "</td>
                <td>₺" . number_format($s['SatisFiyati'], 2) . "</td>
                <td>" . ($s['Tarih'] ?? '-') . "</td>
              </tr>";
    }
    ?>
  </table>

  <h3>📈 Günlük Satış Özeti</h3>
  <?php
 $bugun = date("Y-m-d");
$ozet = $conn->query("
  SELECT COUNT(*) AS Sayi, SUM(SatisFiyati) AS Toplam
  FROM Receteli_Ilac
  WHERE DATE(EklenmeTarihi) = '$bugun'
")->fetch_assoc();

  $adet = $ozet["Sayi"] ?? 0;
  $toplam = number_format($ozet["Toplam"] ?? 0, 2);

  echo "<p>Bugünkü toplam satış adedi: <strong>$adet</strong></p>";
  echo "<p>Bugünkü toplam satış tutarı: <strong>₺$toplam</strong></p>";
  ?>
</div>
</body>
</html>
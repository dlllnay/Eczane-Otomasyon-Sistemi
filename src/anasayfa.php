<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["personelID"])) {
    header("Location: login.php");
    exit;
}
$personelAd = $_SESSION["personelAd"];

// Azalan stoklar
$azalanSorgu = $conn->query("SELECT i.Urun_Ad, s.Adet FROM stok s
JOIN ilac i ON s.Ilac_ID = i.Ilac_ID
WHERE s.Adet < 15
ORDER BY s.Adet ASC LIMIT 4");
$azalanlar = $azalanSorgu->fetch_all(MYSQLI_ASSOC);

// Günlük satış özeti
$satisSorgu = $conn->query("
SELECT SUM(ri.SatisFiyati) AS ToplamSatis
FROM receteli_ilac ri
JOIN recete r ON ri.Recete_ID = r.Recete_ID
WHERE DATE(r.Tarih) = CURDATE()
");$toplamSatis = $satisSorgu->fetch_assoc()["ToplamSatis"] ?? 0;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Anasayfa - Eczane Paneli</title>
  <style>

    .calendar-card {
  width: 50%;
  max width: 450px;
  text-align: center;
  padding: 20px;
}

.calendar {
  width: 100%;
  border-collapse: collapse;
  margin: auto;
}

.calendar th {
  background-color: #e0e7ff;
  color: #3C49C9;
  padding: 8px;
  font-weight: 600;
}

.calendar td {
  padding: 8px;
  border: 1px solid #ddd;
  font-size: 14px;
}

.calendar td.today {
  background-color: #3C49C9;
  color: white;
  font-weight: bold;
  border-radius: 4px;
}
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
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

    .main-content {
      flex: 1;
      padding: 30px;
    }

    .header {
      font-size: 24px;
      margin-bottom: 30px;
    }

    .dashboard {
      display: flex;
      gap: 30px;
      margin-bottom: 30px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .stok-bar {
      height: 10px;
      background: #eee;
      border-radius: 4px;
      margin-top: 5px;
    }

    .stok-bar-inner {
      height: 100%;
      background: #4d74f9;
      border-radius: 4px;
    }

    .stok-item {
      margin-bottom: 15px;
    }

    .stok-label {
      display: flex;
      justify-content: space-between;
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

  <!-- Ana İçerik -->
  <div class="main-content">
    <div class="header">Hoş geldin, <strong><?php echo $personelAd; ?></strong> 👋</div>

    <div class="dashboard">

      <!-- Stokta Azalanlar -->
      <div class="card" style="width: 45%;">
        <h3>📉 Stokta Azalanlar</h3>
        <?php foreach($azalanlar as $ilac): ?>
          <div class="stok-item">
            <div class="stok-label">
              <span><?php echo $ilac['Urun_Ad']; ?></span>
              <span><?php echo $ilac['Adet']; ?></span>
            </div>
            <div class="stok-bar">
              <div class="stok-bar-inner" style="width: <?php echo $ilac['Adet'] * 6; ?>%;"></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Takvim -->
      <div class="card calendar-card">
    <h3 style="margin-bottom: 25px;">📅 Takvim</h3>
    <table class="calendar">
      <tr>
        <th>Pzt</th>
        <th>Sal</th>
        <th>Çar</th>
        <th>Per</th>
        <th>Cum</th>
        <th>Cmt</th>
        <th>Paz</th>
      </tr>
      <?php
      $ay = date('m');
      $yil = date('Y');
      $gunSayisi = cal_days_in_month(CAL_GREGORIAN, $ay, $yil);
      $ilkGun = date('N', strtotime("$yil-$ay-01"));
      $gun = 1;

      for ($satir = 0; $satir < 6; $satir++) {
          echo "<tr>";
          for ($sutun = 1; $sutun <= 7; $sutun++) {
              if (($satir == 0 && $sutun < $ilkGun) || $gun > $gunSayisi) {
                  echo "<td></td>";
              } else {
                  $bugun = date('j') == $gun ? 'class="today"' : '';
                  echo "<td $bugun>$gun</td>";
                  $gun++;
              }
          }
          echo "</tr>";
          if ($gun > $gunSayisi) break;
      }
      ?>
    </table>
    <p style="margin-top:10px; color: gray;"><?php echo date("F Y", strtotime("$yil-$ay-01")); ?></p>
  </div>
</div>

      <!-- Satış Özeti -->
      <div class="card" style="width: 45%; text-align: center;">
        <h3>💸 Bugünkü Satış</h3>
        <div style="font-size: 28px; font-weight: bold; color: #4d74f9;">
          ₺<?php echo number_format($toplamSatis, 2); ?>
        </div>
        <p style="font-size: 24px; color: gray;"><?php echo date("d F Y"); ?></p>
      </div>

      

    </div>
  </div>

</body>
</html>
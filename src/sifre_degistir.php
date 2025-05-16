<?php
include("baglanti.php");

$bilgi = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullaniciAdi = $_POST["kullaniciAdi"];
    $yeniSifre = $_POST["yeniSifre"];

    $kontrol = $conn->prepare("SELECT * FROM Personel WHERE KullaniciAdi = ?");
    $kontrol->bind_param("s", $kullaniciAdi);
    $kontrol->execute();
    $sonuc = $kontrol->get_result();

    if ($sonuc->num_rows > 0) {
        $guncelle = $conn->prepare("UPDATE Personel SET Sifre = ? WHERE KullaniciAdi = ?");
        $guncelle->bind_param("ss", $yeniSifre, $kullaniciAdi);
        $guncelle->execute();
        $bilgi = "✅ Şifre başarıyla güncellendi. <a href='login.php'>Giriş yap</a>";
    } else {
        $bilgi = "❌ Böyle bir kullanıcı bulunamadı.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Şifre Değiştir</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f1f5fb;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .box {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
      width: 400px;
    }

    h2 {
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    button {
      background-color: #4755e2;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
    }

    .info {
      margin-top: 15px;
      color: #333;
    }
  </style>
</head>
<body>

<div class="box">
  <h2>Şifre Yenile</h2>
  <form method="POST">
    <input type="text" name="kullaniciAdi" placeholder="Kullanıcı adı" required>
    <input type="password" name="yeniSifre" placeholder="Yeni şifre" required>
    <button type="submit">🔄 Şifreyi Güncelle</button>
  </form>
  <div class="info"><?php echo $bilgi; ?></div>
</div>

</body>
</html>
<?php
session_start();
include("baglanti.php");

$hata = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullaniciAdi = $_POST["kullaniciAdi"];
    $sifre = $_POST["sifre"];

    $sorgu = $conn->prepare("SELECT * FROM Personel WHERE KullaniciAdi = ?");
    $sorgu->bind_param("s", $kullaniciAdi);
    $sorgu->execute();
    $sonuc = $sorgu->get_result();

    if ($sonuc->num_rows == 1) {
        $personel = $sonuc->fetch_assoc();
        if ($sifre === $personel["Sifre"]) { // ileride hashle değiştirebilirsin
            $_SESSION["personelID"] = $personel["Personel_ID"];
            $_SESSION["personelAd"] = $personel["Personel_Ad"];
            header("Location: anasayfa.php");
            exit;
        } else {
            $hata = "Şifre hatalı!";
        }
    } else {
        $hata = "Kullanıcı adı bulunamadı!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Giriş Yap - Eczane Otomasyonu</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #e0ecff, #ffffff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: Arial, sans-serif;
    }

    .login-container {
      width: 900px;
      height: 500px;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      display: flex;
      overflow: hidden;
    }

    .form-side {
      flex: 1;
      padding: 40px;
    }

    .form-side h2 {
      margin-bottom: 10px;
    }

    .form-side input {
      width: 100%;
      padding: 12px;
      margin: 15px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .form-side button {
      width: 100%;
      padding: 12px;
      background-color: #407BFF;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
    }

    .form-side .forgot {
      text-align: right;
      margin-top: 10px;
      font-size: 13px;
    }

    .form-side .error {
      color: red;
      margin-top: 10px;
    }

.image-side {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f5faff;
  padding: 40px;
}

.image-side img {
  max-width: 160%;
  max-height: 160%;
  width: 1000px;  /* BURADA İSTEDİĞİN GİBİ BÜYÜTÜP KÜÇÜLTEBİLİRSİN */
  height: auto;
  margin-left: -120px;
}
    
    
    
  </style>
</head>
<body>
  <div class="login-container">
    <div class="form-side">
      <h2>Login</h2>
      <p>Nilüfer Eczanesi</p>
      <form method="POST">
        <input type="text" name="kullaniciAdi" placeholder="Kullanıcı adı" required>
        <input type="password" name="sifre" placeholder="Şifre" required>
<a href="sifre_degistir.php" style="float: right;">Şifreni mi unuttun?</a>        <button type="submit">Login</button>
        <?php if($hata != "") echo "<div class='error'>$hata</div>"; ?>
      </form>
    </div>
    <div class="image-side">
  <img src="images/kindpng_3997736.png" alt="eczane görseli">
</div>
  </div>
</body>
</html>
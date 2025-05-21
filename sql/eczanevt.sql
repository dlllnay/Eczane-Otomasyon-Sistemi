-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 16 May 2025, 17:54:11
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `eczanevt`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doktor`
--

CREATE TABLE `doktor` (
  `Doktor_ID` int(11) NOT NULL,
  `Doktor_Ad` varchar(50) DEFAULT NULL,
  `Doktor_Soyad` varchar(50) DEFAULT NULL,
  `UzmanlikAlani` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `doktor`
--

INSERT INTO `doktor` (`Doktor_ID`, `Doktor_Ad`, `Doktor_Soyad`, `UzmanlikAlani`) VALUES
(1, 'Ahmet', 'Yıldız', 'Dahiliye'),
(2, 'Zeynep', 'Kara', 'Çocuk Sağlığı'),
(3, 'Mehmet', 'Demir', 'Kardiyoloji'),
(4, 'Elif', 'Koç', 'Ortopedi'),
(5, 'Burak', 'Aslan', 'Göz Hastalıkları');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `eczane`
--

CREATE TABLE `eczane` (
  `Eczane_ID` int(11) NOT NULL,
  `Eczane_Ad` varchar(100) DEFAULT NULL,
  `EczaneAdres` text DEFAULT NULL,
  `PersonelSayisi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `eczane`
--

INSERT INTO `eczane` (`Eczane_ID`, `Eczane_Ad`, `EczaneAdres`, `PersonelSayisi`) VALUES
(1, 'Nilüfer Eczanesi', 'Nilüfer, Bursa', 5);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hasta`
--

CREATE TABLE `hasta` (
  `Hasta_ID` int(11) NOT NULL,
  `Hasta_Ad` varchar(50) DEFAULT NULL,
  `Hasta_Soyad` varchar(50) DEFAULT NULL,
  `DogumTarihi` date DEFAULT NULL,
  `HastaTC` char(11) DEFAULT NULL,
  `SigortaTuru` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `hasta`
--

INSERT INTO `hasta` (`Hasta_ID`, `Hasta_Ad`, `Hasta_Soyad`, `DogumTarihi`, `HastaTC`, `SigortaTuru`) VALUES
(1, 'Ali', 'Vural', '1990-05-12', '12345678901', 'SGK'),
(2, 'Ayşe', 'Kılıç', '1985-02-28', '98765432100', 'Özel'),
(3, 'Fatma', 'Çetin', '1972-10-09', '11122334455', 'SGK'),
(4, 'Kemal', 'Toprak', '2000-07-15', '33322211100', 'Yok'),
(5, 'Merve', 'Sarı', '1998-11-03', '44455566677', 'SGK');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ilac`
--

CREATE TABLE `ilac` (
  `Ilac_ID` int(11) NOT NULL,
  `Barkod` varchar(50) DEFAULT NULL,
  `Urun_Ad` varchar(100) DEFAULT NULL,
  `EtkenMadde` varchar(100) DEFAULT NULL,
  `ATCKodu` varchar(20) DEFAULT NULL,
  `RuhsatNo` varchar(30) DEFAULT NULL,
  `KullanimYasi` varchar(20) DEFAULT NULL,
  `ReceteTuru` varchar(20) DEFAULT NULL,
  `Fiyat` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ilac`
--

INSERT INTO `ilac` (`Ilac_ID`, `Barkod`, `Urun_Ad`, `EtkenMadde`, `ATCKodu`, `RuhsatNo`, `KullanimYasi`, `ReceteTuru`, `Fiyat`) VALUES
(1, '8690000000001', 'Parol 500mg', 'Parasetamol', 'N02BE01', 'R12345', '12+', 'Normal', 15.00),
(2, '8690000000002', 'Augmentin 1000mg', 'Amoksisilin', 'J01CR02', 'R54321', '18+', 'Kırmızı', 90.00),
(3, '8690000000003', 'Ventolin Nebül', 'Salbutamol', 'R03AC02', 'R67890', '6+', 'Yeşil', 70.00),
(4, '8690000000004', 'Nexium 40mg', 'Esomeprazol', 'A02BC05', 'R99999', '18+', 'Normal', 85.00),
(5, '8690000000005', 'Dolorex 25mg', 'Dexketoprofen', 'M01AE17', 'R10101', '16+', 'Sarı', 40.00),
(6, '8690000000006', 'Biteral 500mg', 'Metronidazol', 'J01XD01', 'R20202', '18+', 'Normal', 25.00),
(7, '8690000000007', 'Zyrtec 10mg', 'Setirizin', 'R06AE07', 'R30303', '6+', 'Yeşil', 35.00),
(8, '8690000000008', 'Arveles', 'Dexketoprofen', 'M01AE17', 'R40404', '12+', 'Sarı', 38.50),
(9, '8690000000009', 'Xanax 0.5mg', 'Alprazolam', 'N05BA12', 'R50505', '18+', 'Kırmızı', 110.00),
(10, '8690000000010', 'Talcid', 'Magnezyum hidroksit', 'A02AD03', 'R60606', '16+', 'Normal', 22.00),
(11, '8690000000011', 'Muscoril', 'Tiyokolşikosid', 'M03BX05', 'R70707', '18+', 'Yeşil', 62.00),
(12, '8690000000012', 'Glifor 1000', 'Metformin', 'A10BA02', 'R80808', '16+', 'Normal', 18.75),
(13, '8690000000013', 'Cipro 500mg', 'Siprofloksasin', 'J01MA02', 'R90909', '18+', 'Kırmızı', 96.00),
(14, '8690000000014', 'Seroxat', 'Paroksetin', 'N06AB05', 'R11111', '18+', 'Yeşil', 75.00),
(15, '8690000000015', 'Minoset Plus', 'Parasetamol + Kafein', 'N02BE51', 'R12121', '12+', 'Normal', 26.00),
(16, '8690000000016', 'Tylol Hot', 'Parasetamol + Fenilefrin', 'N02BE71', 'R13131', '12+', 'Normal', 21.00),
(17, '8690000000017', 'Ferrosanol', 'Demir sülfat', 'B03AA07', 'R14141', '6+', 'Normal', 32.00),
(18, '8690000000018', 'Enflu Cold', 'Fenilefrin + Antihistamin', 'R05DA20', 'R15151', '16+', 'Normal', 17.50),
(19, '8690000000019', 'A-ferin', 'Parasetamol + Antihistamin', 'N02BE71', 'R16161', '12+', 'Normal', 18.00),
(20, '8690000000020', 'Voltaren', 'Diklofenak', 'M01AB05', 'R17171', '16+', 'Sarı', 44.00),
(21, '8690000000021', 'Prozac', 'Fluoksetin', 'N06AB03', 'R18181', '18+', 'Yeşil', 85.00),
(22, '8690000000022', 'Aspirin 100mg', 'Asetilsalisilik Asit', 'B01AC06', 'R19191', '16+', 'Normal', 12.00),
(23, '8690000000023', 'Eferalgan', 'Parasetamol', 'N02BE01', 'R20202', '6+', 'Normal', 13.00),
(24, '8690000000024', 'Rennie Duo', 'Magnezyum + Kalsiyum Karbonat', 'A02AD01', 'R21212', '12+', 'Normal', 24.00),
(25, '8690000000025', 'Leodex', 'Deksketoprofen', 'M01AE17', 'R22222', '18+', 'Sarı', 39.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personel`
--

CREATE TABLE `personel` (
  `Personel_ID` int(11) NOT NULL,
  `Personel_Ad` varchar(50) DEFAULT NULL,
  `Personel_Soyad` varchar(50) DEFAULT NULL,
  `Unvan` varchar(50) DEFAULT NULL,
  `IseGirisTarihi` date DEFAULT NULL,
  `CepNo` varchar(15) DEFAULT NULL,
  `Maas` decimal(10,2) DEFAULT NULL,
  `KullaniciAdi` varchar(50) DEFAULT NULL,
  `Sifre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `personel`
--

INSERT INTO `personel` (`Personel_ID`, `Personel_Ad`, `Personel_Soyad`, `Unvan`, `IseGirisTarihi`, `CepNo`, `Maas`, `KullaniciAdi`, `Sifre`) VALUES
(1, 'Ayşe', 'Kaya', 'Eczacı', '2022-03-15', '05551112233', 18500.00, 'ayse.kaya', '1234'),
(2, 'Mehmet', 'Yılmaz', 'Eczacı Kalfa', '2021-07-22', '05552223344', 14500.00, 'mehmet.yilmaz', '1234'),
(3, 'Zeynep', 'Demir', 'Teknisyen', '2023-01-10', '05553334455', 12500.00, 'zeynep.demir', '1234'),
(4, 'Burak', 'Koç', 'Eczacı', '2020-09-05', '05554445566', 19000.00, 'burak.koc', '1234'),
(5, 'Elif', 'Çetin', 'Eczacı Kalfa', '2019-12-01', '05556667788', 14000.00, 'elif.cetin', '1234'),
(6, 'Dolunay', 'Aksoy', 'Yönetici', '2025-05-13', '(551) 457 1171', 0.00, 'dolunay.aksoy', '1234'),
(8, 'Şükran', 'Başaran', 'Yönetici', '2025-05-14', '5748576898', 0.00, 'sukbasa', '1234'),
(9, 'Barkın', 'Kanbur', 'Yönetici', '2025-05-14', '54765845745', 0.00, 'barkın.kanbur', '1234');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personellog`
--

CREATE TABLE `personellog` (
  `Log_ID` int(11) NOT NULL,
  `Personel_ID` int(11) DEFAULT NULL,
  `Tarih` datetime DEFAULT NULL,
  `Aciklama` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `personellog`
--

INSERT INTO `personellog` (`Log_ID`, `Personel_ID`, `Tarih`, `Aciklama`) VALUES
(1, 1, '2025-05-13 17:51:51', 'Ayşe adlı personel sisteme eklendi.'),
(2, 2, '2025-05-13 17:51:51', 'Mehmet adlı personel sisteme eklendi.'),
(3, 3, '2025-05-13 17:51:51', 'Zeynep adlı personel sisteme eklendi.'),
(4, 4, '2025-05-13 17:51:51', 'Burak adlı personel sisteme eklendi.'),
(5, 5, '2025-05-13 17:51:51', 'Elif adlı personel sisteme eklendi.'),
(6, 6, '2025-05-13 18:18:31', 'Dolunay adlı personel sisteme eklendi.'),
(7, 8, '2025-05-14 13:35:30', 'Şükran adlı personel sisteme eklendi.'),
(8, 9, '2025-05-14 13:36:10', 'Barkın adlı personel sisteme eklendi.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `recete`
--

CREATE TABLE `recete` (
  `Recete_ID` int(11) NOT NULL,
  `Hasta_ID` int(11) DEFAULT NULL,
  `Tarih` date DEFAULT NULL,
  `Doktor_ID` int(11) DEFAULT NULL,
  `Recete_Turu` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `recete`
--

INSERT INTO `recete` (`Recete_ID`, `Hasta_ID`, `Tarih`, `Doktor_ID`, `Recete_Turu`) VALUES
(1, 1, '2025-05-01', 2, 'Kırmızı'),
(2, 2, '2025-05-02', 1, 'Yeşil'),
(3, 3, '2025-05-03', 3, 'Normal'),
(4, 4, '2025-05-04', 4, 'Sarı');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `receteli_ilac`
--

CREATE TABLE `receteli_ilac` (
  `Receteli_Ilac_ID` int(11) NOT NULL,
  `Recete_ID` int(11) DEFAULT NULL,
  `Ilac_ID` int(11) DEFAULT NULL,
  `Ilac_Adeti` int(11) DEFAULT NULL,
  `OdemeTipi` varchar(50) DEFAULT NULL,
  `SatisFiyati` decimal(10,2) DEFAULT NULL,
  `NormalFiyat` decimal(10,2) DEFAULT NULL,
  `IndirimliFiyat` decimal(10,2) DEFAULT NULL,
  `SigortaKarsilamaOrani` decimal(5,2) DEFAULT NULL,
  `EklenmeTarihi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `receteli_ilac`
--

INSERT INTO `receteli_ilac` (`Receteli_Ilac_ID`, `Recete_ID`, `Ilac_ID`, `Ilac_Adeti`, `OdemeTipi`, `SatisFiyati`, `NormalFiyat`, `IndirimliFiyat`, `SigortaKarsilamaOrani`, `EklenmeTarihi`) VALUES
(11, 1, 2, 1, 'Nakit', 90.00, 90.00, 90.00, 0.00, '2025-05-16 14:36:33'),
(12, 2, 3, 1, 'Nakit', 70.00, 70.00, 70.00, 0.00, '2025-05-16 14:36:33'),
(13, 3, 1, 2, 'Nakit', 15.00, 15.00, 15.00, 0.00, '2025-05-16 14:36:33'),
(14, 4, 5, 1, 'Nakit', 40.00, 40.00, 40.00, 0.00, '2025-05-16 14:36:33'),
(15, NULL, 1, 1, 'Nakit', 15.00, 15.00, 15.00, 0.00, '2025-05-16 14:36:33'),
(16, NULL, 1, 1, 'Nakit', 15.00, 15.00, 15.00, 0.00, '2025-05-16 14:36:33'),
(17, NULL, 1, 1, 'Nakit', 15.00, 15.00, 15.00, 0.00, '2025-05-16 14:36:33'),
(18, NULL, 12, 1, 'Nakit', 18.75, 18.75, 18.75, 0.00, '2025-05-16 14:36:33'),
(19, NULL, 12, 1, 'Nakit', 18.75, 18.75, 18.75, 0.00, '2025-05-16 14:36:33'),
(20, NULL, 12, 1, 'Nakit', 18.75, 18.75, 18.75, 0.00, '2025-05-16 14:36:33'),
(21, NULL, 12, 1, 'Nakit', 18.75, 18.75, 18.75, 0.00, '2025-05-16 14:36:33'),
(22, 1, 2, 1, 'Nakit', 18.00, 90.00, 18.00, 0.80, '2025-05-16 14:36:33'),
(23, 4, 2, 1, 'Nakit', 45.00, 90.00, 45.00, 0.50, '2025-05-16 14:36:33');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stok`
--

CREATE TABLE `stok` (
  `Stok_ID` int(11) NOT NULL,
  `Ilac_ID` int(11) DEFAULT NULL,
  `Eczane_ID` int(11) DEFAULT NULL,
  `Tedarikci_ID` int(11) DEFAULT NULL,
  `Adet` int(11) DEFAULT NULL,
  `AlimTarihi` date DEFAULT NULL,
  `UretimTarihi` date DEFAULT NULL,
  `SKT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `stok`
--

INSERT INTO `stok` (`Stok_ID`, `Ilac_ID`, `Eczane_ID`, `Tedarikci_ID`, `Adet`, `AlimTarihi`, `UretimTarihi`, `SKT`) VALUES
(11, 1, 1, 1, 22, '2025-04-01', '2024-06-01', '2026-06-01'),
(12, 2, 1, 2, 13, '2025-04-02', '2024-07-01', '2026-07-01'),
(13, 3, 1, 1, 8, '2025-04-03', '2024-03-01', '2026-03-01'),
(14, 4, 1, 3, 12, '2025-04-04', '2024-05-01', '2026-05-01'),
(15, 5, 1, 2, 30, '2025-04-05', '2024-09-01', '2026-09-01'),
(16, 6, 1, 1, 20, '2025-04-06', '2024-04-01', '2026-04-01'),
(17, 7, 1, 2, 5, '2025-04-07', '2024-06-01', '2026-06-01'),
(18, 8, 1, 3, 10, '2025-04-08', '2024-07-01', '2026-07-01'),
(19, 9, 1, 1, 18, '2025-04-09', '2024-10-01', '2026-10-01'),
(20, 10, 1, 3, 40, '2025-04-10', '2024-08-01', '2026-08-01'),
(21, 11, 1, 2, 7, '2025-04-11', '2024-09-01', '2026-09-01'),
(22, 12, 1, 1, 9, '2025-04-12', '2024-08-01', '2026-08-01'),
(23, 13, 1, 3, 9, '2025-04-13', '2024-11-01', '2026-11-01'),
(24, 14, 1, 1, 22, '2025-04-14', '2024-10-01', '2026-10-01'),
(25, 15, 1, 2, 6, '2025-04-15', '2024-05-01', '2026-05-01');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tedarikci`
--

CREATE TABLE `tedarikci` (
  `Tedarikci_ID` int(11) NOT NULL,
  `Tedarikci_Ad` varchar(100) DEFAULT NULL,
  `TedarikciTelNo` varchar(15) DEFAULT NULL,
  `TedarikciAdres` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tedarikci`
--

INSERT INTO `tedarikci` (`Tedarikci_ID`, `Tedarikci_Ad`, `TedarikciTelNo`, `TedarikciAdres`) VALUES
(1, 'Farmalog İlaç Dağıtım', '0212 555 1234', 'Organize Sanayi, İstanbul'),
(2, 'Selçuk Ecza Deposu', '0232 444 8877', 'İzmir Gaziemir Ecza Depo Bölgesi'),
(3, 'Vefa Medikal', '0312 222 6677', 'Ankara Ostim OSB 3. Cadde');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyarilog`
--

CREATE TABLE `uyarilog` (
  `Uyari_ID` int(11) NOT NULL,
  `Mesaj` text DEFAULT NULL,
  `Tarih` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `uyarilog`
--

INSERT INTO `uyarilog` (`Uyari_ID`, `Mesaj`, `Tarih`) VALUES
(1, 'Parol 500mg stok adedi 5 kaldı.', '2025-05-14 13:30:54'),
(2, 'Xanax 0.5mg için minimum stok sınırı aşıldı.', '2025-05-14 13:30:54'),
(3, 'Personel #3 kırmızı reçeteli ilaca erişmeye çalıştı.', '2025-05-14 13:30:54'),
(4, 'Reçetesiz satılamayan ilaç reçetesiz satıldı.', '2025-05-14 13:30:54');

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `vw_azalanstok`
-- (Asıl görünüm için aşağıya bakın)
--
CREATE TABLE `vw_azalanstok` (
`Stok_ID` int(11)
,`Urun_Ad` varchar(100)
,`Adet` int(11)
);

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `vw_gunluksatisozeti`
-- (Asıl görünüm için aşağıya bakın)
--
CREATE TABLE `vw_gunluksatisozeti` (
`Tarih` date
,`ToplamIlacAdedi` bigint(21)
,`ToplamTutar` decimal(32,2)
);

--  --------------------------------------------------------

--
-- Stok Azalınca Uyarı Gösteren Trigger
DELIMITER //

CREATE TRIGGER trg_stok_uyarisi
AFTER UPDATE ON stok
FOR EACH ROW
BEGIN
  IF NEW.Adet < 10 THEN
    INSERT INTO uyarilog (Mesaj, Tarih)
    VALUES (
      CONCAT((SELECT Urun_Ad FROM ilac WHERE Ilac_ID = NEW.Ilac_ID), ' stoğu azaldı. Lütfen sipariş verin.'),
      NOW()
    );
  END IF;
END;
//

DELIMITER ;
--
--  ---------------------------------------------------------

--
--
--2. Satış Fiyatı Sistemi için (Reçete + Sigorta Kontrolü)
DELIMITER //

CREATE TRIGGER trg_fiyat_belirle
BEFORE INSERT ON receteli_ilac
FOR EACH ROW
BEGIN
  DECLARE sigortaTuru VARCHAR(50);
  
  SELECT h.SigortaTuru INTO sigortaTuru
  FROM recete r
  JOIN hasta h ON r.Hasta_ID = h.Hasta_ID
  WHERE r.Recete_ID = NEW.Recete_ID;

  IF NEW.Recete_ID IS NOT NULL AND sigortaTuru = 'SGK' THEN
    SET NEW.IndirimliFiyat = NEW.NormalFiyat * 0.20;
    SET NEW.SatisFiyati = NEW.NormalFiyat * 0.20;
    SET NEW.SigortaKarsilamaOrani = 0.80;
    
  ELSEIF NEW.Recete_ID IS NOT NULL AND sigortaTuru = 'Özel' THEN
    SET NEW.IndirimliFiyat = NEW.NormalFiyat * 0.50;
    SET NEW.SatisFiyati = NEW.NormalFiyat * 0.50;
    SET NEW.SigortaKarsilamaOrani = 0.50;

  ELSE
    SET NEW.IndirimliFiyat = NEW.NormalFiyat;
    SET NEW.SatisFiyati = NEW.NormalFiyat;
    SET NEW.SigortaKarsilamaOrani = 0.00;
  END IF;
END;
//

DELIMITER ;
--
--   ---------------------------------------------------------------
--
--
--
--3. Personel Loglama Trigger’ı
--Yeni personel eklendiğinde otomatik olarak personellog tablosuna log kaydı düşer
DELIMITER //

CREATE TRIGGER trg_personel_ekleme
AFTER INSERT ON personel
FOR EACH ROW
BEGIN
  INSERT INTO personellog (Personel_ID, Tarih)
  VALUES (NEW.Personel_ID, NOW());
END;
//

DELIMITER ;


-------------------------------------------------------------------------------------
--
--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `doktor`
--
ALTER TABLE `doktor`
  ADD PRIMARY KEY (`Doktor_ID`);

--
-- Tablo için indeksler `eczane`
--
ALTER TABLE `eczane`
  ADD PRIMARY KEY (`Eczane_ID`);

--
-- Tablo için indeksler `hasta`
--
ALTER TABLE `hasta`
  ADD PRIMARY KEY (`Hasta_ID`),
  ADD UNIQUE KEY `HastaTC` (`HastaTC`),
  ADD KEY `idx_HastaTC` (`HastaTC`);

--
-- Tablo için indeksler `ilac`
--
ALTER TABLE `ilac`
  ADD PRIMARY KEY (`Ilac_ID`),
  ADD UNIQUE KEY `Barkod` (`Barkod`),
  ADD KEY `idx_IlacBarkod` (`Barkod`);

--
-- Tablo için indeksler `personel`
--
ALTER TABLE `personel`
  ADD PRIMARY KEY (`Personel_ID`),
  ADD UNIQUE KEY `KullaniciAdi` (`KullaniciAdi`);

--
-- Tablo için indeksler `personellog`
--
ALTER TABLE `personellog`
  ADD PRIMARY KEY (`Log_ID`);

--
-- Tablo için indeksler `recete`
--
ALTER TABLE `recete`
  ADD PRIMARY KEY (`Recete_ID`),
  ADD KEY `Doktor_ID` (`Doktor_ID`);

--
-- Tablo için indeksler `receteli_ilac`
--
ALTER TABLE `receteli_ilac`
  ADD PRIMARY KEY (`Receteli_Ilac_ID`),
  ADD KEY `Ilac_ID` (`Ilac_ID`),
  ADD KEY `idx_ReceteIlac_ReceteID` (`Recete_ID`);

--
-- Tablo için indeksler `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`Stok_ID`),
  ADD KEY `Ilac_ID` (`Ilac_ID`),
  ADD KEY `Eczane_ID` (`Eczane_ID`),
  ADD KEY `Tedarikci_ID` (`Tedarikci_ID`);

--
-- Tablo için indeksler `tedarikci`
--
ALTER TABLE `tedarikci`
  ADD PRIMARY KEY (`Tedarikci_ID`);

--
-- Tablo için indeksler `uyarilog`
--
ALTER TABLE `uyarilog`
  ADD PRIMARY KEY (`Uyari_ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `doktor`
--
ALTER TABLE `doktor`
  MODIFY `Doktor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `eczane`
--
ALTER TABLE `eczane`
  MODIFY `Eczane_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `hasta`
--
ALTER TABLE `hasta`
  MODIFY `Hasta_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `ilac`
--
ALTER TABLE `ilac`
  MODIFY `Ilac_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Tablo için AUTO_INCREMENT değeri `personel`
--
ALTER TABLE `personel`
  MODIFY `Personel_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `personellog`
--
ALTER TABLE `personellog`
  MODIFY `Log_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `recete`
--
ALTER TABLE `recete`
  MODIFY `Recete_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `receteli_ilac`
--
ALTER TABLE `receteli_ilac`
  MODIFY `Receteli_Ilac_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `stok`
--
ALTER TABLE `stok`
  MODIFY `Stok_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Tablo için AUTO_INCREMENT değeri `tedarikci`
--
ALTER TABLE `tedarikci`
  MODIFY `Tedarikci_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `uyarilog`
--
ALTER TABLE `uyarilog`
  MODIFY `Uyari_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `recete`
--
ALTER TABLE `recete`
  ADD CONSTRAINT `recete_ibfk_1` FOREIGN KEY (`Doktor_ID`) REFERENCES `doktor` (`Doktor_ID`);

--
-- Tablo kısıtlamaları `receteli_ilac`
--
ALTER TABLE `receteli_ilac`
  ADD CONSTRAINT `receteli_ilac_ibfk_1` FOREIGN KEY (`Recete_ID`) REFERENCES `recete` (`Recete_ID`),
  ADD CONSTRAINT `receteli_ilac_ibfk_2` FOREIGN KEY (`Ilac_ID`) REFERENCES `ilac` (`Ilac_ID`);

--
-- Tablo kısıtlamaları `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`Ilac_ID`) REFERENCES `ilac` (`Ilac_ID`),
  ADD CONSTRAINT `stok_ibfk_2` FOREIGN KEY (`Eczane_ID`) REFERENCES `eczane` (`Eczane_ID`),
  ADD CONSTRAINT `stok_ibfk_3` FOREIGN KEY (`Tedarikci_ID`) REFERENCES `tedarikci` (`Tedarikci_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

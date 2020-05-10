-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2020 at 09:14 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `namestajdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `anketa`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `anketa` (
  `id` int(11) NOT NULL,
  `pitanje` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktivna` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `anketa`:
--

--
-- Dumping data for table `anketa`
--

INSERT INTO `anketa` (`id`, `pitanje`, `aktivna`) VALUES
(1, 'Kako ste čuli za naš salon nameštaja?', b'1'),
(2, 'Kako ste?', b'0'),
(6, 'Kako cemo?', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `karakteristike`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `karakteristike` (
  `id` int(11) NOT NULL,
  `naziv` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `karakteristike`:
--

--
-- Dumping data for table `karakteristike`
--

INSERT INTO `karakteristike` (`id`, `naziv`) VALUES
(1, 'Sirina'),
(2, 'Visina'),
(3, 'Dužina'),
(4, 'Materijal'),
(5, 'Dubina');

-- --------------------------------------------------------

--
-- Table structure for table `kategorije`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `kategorije` (
  `id` int(11) NOT NULL,
  `naziv` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `kategorije`:
--

--
-- Dumping data for table `kategorije`
--

INSERT INTO `kategorije` (`id`, `naziv`) VALUES
(1, 'Fotelje'),
(2, 'Dvosedi'),
(3, 'Ugaone garniture'),
(4, 'Stolovi'),
(5, 'Stolice'),
(6, 'Kreveti'),
(8, 'Ormari');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--
-- Creation: Apr 27, 2020 at 04:59 PM
--

CREATE TABLE `korisnici` (
  `id` int(4) NOT NULL,
  `ime` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prezime` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresa` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefon` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grad` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `korIme` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sifra` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datumRegistracije` timestamp NOT NULL DEFAULT current_timestamp(),
  `ulogaId` int(3) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `korisnici`:
--   `ulogaId`
--       `uloge` -> `id`
--

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `adresa`, `telefon`, `grad`, `korIme`, `email`, `sifra`, `datumRegistracije`, `ulogaId`) VALUES
(11, 'Djordje', 'Antanaskovic', 'Radncika 6A', '060333555', 'Beograd', 'djole123', 'djolo123@gmail.com', 'f1dc735ee3581693489eaf286088b916', '2020-03-27 18:19:09', 1),
(12, 'Paja', 'Patak', 'Patkova', '0633335551', 'Patkov Grad', 'pjPatak', 'patak@gmail.com', 'f1dc735ee3581693489eaf286088b916', '2020-03-30 18:23:33', 2),
(13, 'Pera', 'Peric', 'Perina ulica', '063456789', 'Smederevo', 'djole', 'pera@gmail.com', 'f1dc735ee3581693489eaf286088b916', '2020-04-07 16:31:37', 2),
(14, 'Pera', 'Petrovic', 'Perina', '063456789', 'Kraljevo', 'pera', 'pera123@gmail.com', 'f1dc735ee3581693489eaf286088b916', '2020-04-07 16:34:56', 2),
(15, 'Mika', 'Mikic', 'Mikina 10', '0647890123', 'Mladenovac', 'mika', 'mika@yahoo.com', 'f1dc735ee3581693489eaf286088b916', '2020-04-07 16:57:18', 2),
(18, 'Miroslav', 'Milenkovic', 'Pajina adresa 6a', '061333555', 'Pancevo', 'miroslav', 'mika@gmail.com', '30931699d4fdbc3836e918f01721b57d', '2020-04-18 17:24:45', 2),
(19, 'Kismo', 'Djolevic', 'Maserikova', '06111500131', 'Beograd', 'pjpataks', 'kismo@gmail.com', 'f1dc735ee3581693489eaf286088b916', '2020-04-19 12:15:18', 2);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik_odgovor`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `korisnik_odgovor` (
  `id` int(11) NOT NULL,
  `idOdg` int(11) NOT NULL,
  `idKor` int(11) NOT NULL,
  `idAnketa` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `korisnik_odgovor`:
--   `idOdg`
--       `odgovori` -> `id`
--   `idKor`
--       `korisnici` -> `id`
--

--
-- Dumping data for table `korisnik_odgovor`
--

INSERT INTO `korisnik_odgovor` (`id`, `idOdg`, `idKor`, `idAnketa`, `datum`) VALUES
(1, 1, 13, 1, '2020-04-17 21:21:39'),
(2, 4, 11, 1, '2020-04-17 21:33:33'),
(3, 2, 15, 1, '2020-04-18 09:17:19'),
(4, 6, 11, 2, '2020-04-18 20:46:09'),
(5, 6, 15, 2, '2020-04-19 12:08:19'),
(6, 7, 12, 2, '2020-04-19 12:13:35'),
(7, 4, 19, 1, '2020-04-24 10:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `mejlovi`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `mejlovi` (
  `id` int(11) NOT NULL,
  `posiljalac` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poruka` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `datumSlanja` timestamp NOT NULL DEFAULT current_timestamp(),
  `odgovor` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datumOdg` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `mejlovi`:
--

--
-- Dumping data for table `mejlovi`
--

INSERT INTO `mejlovi` (`id`, `posiljalac`, `mail`, `poruka`, `datumSlanja`, `odgovor`, `datumOdg`) VALUES
(1, 'Djolo', 'djolo@gmail.com', 'Da li vrsite dostavu na kucnu adresu posle 17h casova?Hvala unapred!', '2020-04-12 20:03:44', NULL, NULL),
(2, 'Paja Patak', 'paja@patak.com', 'Da li se naplacuje dostava?', '2020-04-12 20:05:44', NULL, NULL),
(3, 'Miki Maus', 'miki@gmail.com', 'Da li je moguce placanje na rate?', '2020-04-12 22:30:50', 'naravo', '2020-04-16 14:25:40'),
(4, 'Miki Mećava', 'mecava@gmail.com', 'Da li je moguće plaćanje kreditnim karticama?', '2020-04-16 14:47:57', 'Naravno,kreditnim karticama svih banak u Srbiji.', '2020-04-17 19:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `navigacija`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `navigacija` (
  `id` int(11) NOT NULL,
  `imeLinka` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioritet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `navigacija`:
--

--
-- Dumping data for table `navigacija`
--

INSERT INTO `navigacija` (`id`, `imeLinka`, `link`, `prioritet`) VALUES
(1, 'Pocetna', 'index.php', 1),
(2, 'O nama', 'aboutUss.php', 2),
(3, 'Proizvodi', 'proizvodi.php', 3),
(4, 'Kontakt', 'kontakt.php', 4);

-- --------------------------------------------------------

--
-- Table structure for table `odgovori`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `odgovori` (
  `id` int(11) NOT NULL,
  `tekst` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anketaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `odgovori`:
--   `anketaId`
--       `anketa` -> `id`
--

--
-- Dumping data for table `odgovori`
--

INSERT INTO `odgovori` (`id`, `tekst`, `anketaId`) VALUES
(1, 'Društvene mreže', 1),
(2, 'Dnevna štampa', 1),
(3, 'Preporuka prijatelja', 1),
(4, 'TV reklama', 1),
(5, 'Dobro', 2),
(6, 'Onako', 2),
(7, 'Loše', 2),
(17, 'Lako cemo', 6),
(18, 'Teško bogami', 6),
(19, 'Trio za rio', 6);

-- --------------------------------------------------------

--
-- Table structure for table `porudzbine`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `porudzbine` (
  `id` int(11) NOT NULL,
  `korisnikId` int(11) NOT NULL,
  `adresa` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grad` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datumPorudzbine` timestamp NOT NULL DEFAULT current_timestamp(),
  `datumIsporuke` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `porudzbine`:
--   `korisnikId`
--       `korisnici` -> `id`
--

--
-- Dumping data for table `porudzbine`
--

INSERT INTO `porudzbine` (`id`, `korisnikId`, `adresa`, `grad`, `datumPorudzbine`, `datumIsporuke`) VALUES
(4, 12, 'Patkova', 'Patkov Grad', '2020-03-30 19:42:44', '2020-04-02 17:37:58'),
(5, 12, 'Patkova', 'Patkov Grad', '2020-03-30 19:50:02', '2020-04-02 17:38:24'),
(6, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:03:06', '2020-04-02 17:38:24'),
(7, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:09:42', '2020-04-02 17:38:24'),
(8, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:11:55', '2020-04-02 17:38:24'),
(9, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:13:14', '2020-04-02 17:38:24'),
(10, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:15:00', '2020-04-02 17:38:24'),
(11, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:15:32', '2020-04-02 17:38:24'),
(12, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:18:07', '2020-04-02 17:38:24'),
(13, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:18:27', '2020-04-02 17:38:24'),
(14, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:24:02', '2020-04-02 17:38:24'),
(15, 11, 'Radncika 6A', 'Beograd', '2020-03-30 20:28:14', '2020-04-02 17:38:24'),
(16, 11, 'Radncika 6A', 'Beograd', '2020-04-04 12:55:46', '2020-04-07 17:39:11'),
(17, 13, 'Perina 2', 'Smederevo', '2020-04-12 17:23:50', '2020-04-15 17:39:26'),
(18, 11, 'Radncika 6 A', 'Beograd', '2020-04-18 17:35:55', '2020-04-21 17:39:32'),
(19, 19, 'Maserikova', 'Beograd', '2020-04-22 19:16:15', '2020-04-25 17:39:37'),
(20, 19, 'Maserikova', 'Beograd', '2020-04-22 19:17:49', '2020-04-25 17:39:44'),
(21, 19, 'Maserikova', 'Beograd', '2020-04-22 19:20:42', '2020-04-25 17:39:55'),
(22, 19, 'Maserikova', 'Beograd', '2020-04-22 19:21:48', '2020-04-25 17:39:59'),
(23, 19, 'Maserikova', 'Beograd', '2020-04-24 19:51:38', '2020-04-27 20:44:17'),
(24, 19, 'Maserikova', 'Beograd', '2020-04-24 19:52:59', '2020-04-27 19:52:59');

-- --------------------------------------------------------

--
-- Table structure for table `proizvodi`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `proizvodi` (
  `id` int(10) NOT NULL,
  `imeProizvoda` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategorijaId` int(10) NOT NULL,
  `cena` decimal(10,0) NOT NULL,
  `opis` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datumUnosa` timestamp NULL DEFAULT current_timestamp(),
  `obrisan` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `proizvodi`:
--   `kategorijaId`
--       `kategorije` -> `id`
--

--
-- Dumping data for table `proizvodi`
--

INSERT INTO `proizvodi` (`id`, `imeProizvoda`, `kategorijaId`, `cena`, `opis`, `datumUnosa`, `obrisan`) VALUES
(1, 'Knez', 1, '7299', 'Knez model je jedan od predstavnika savremenog dizajna fotelja. Ovaj komad nameštaja u crnoj boji uneće eleganciju u Vaš dom i dati Vašoj dnevnoj sobi karakter.', '2020-03-19 20:18:48', b'0'),
(2, 'Modena', 2, '39990', 'Ukoliko ste u potrazi za moćnim komadom nameštaja koji će pružiti Vašem telu potporu i mekoću, Modena dvosed je onda pravi izbor za Vas. Unesite eleganciju u svoj dom, ne štedeći na udobnosti.', '2020-03-19 20:21:04', b'0'),
(3, 'Kancelarijski sto', 4, '12000', 'Jednostavan, a opet tako moćan, kancelarijski sto je pravi izbor ukoliko želite veliku radnu površinu bez previše detalja.', '2020-03-19 20:47:27', b'0'),
(4, 'Mari', 3, '24999', NULL, '2020-03-19 20:47:27', b'0'),
(5, 'Roberta', 5, '5000', 'Zahvaljujući materijalima od kojih su napravljene i modernom dizanu, stolice Roberta su veoma brzo pronašle put do kupaca. Nogari stolica su izrađeni od fino obrađenog bukovog drveta, a stolica je presvučena eko-kožom koja omogućava koži da diše usled višečasovnog sedenja. Stolice Roberta Bež namenjene su, pored upotrebe u kućnom i ugostiteljskom programu, i u kancelarijske svrhe.\r\nImate mogućnost odabira dezena stopica stolice.', '2020-03-19 20:55:33', b'0'),
(6, 'Vitorog 2K', 8, '15850', 'Jednostavnost je ključ lake organizacije garderobe. Uz 2K model, sasvim smo sigurni da nećete imati problem da sortirate svoje omiljene komade odeće.', '2020-04-01 19:34:45', b'0'),
(89, 'Plakar P1PN', 8, '15783', 'Sve vidne povrsine elementa lakirane UV lakom u visokom sjaju i cetiri puta otpornije na fizicka ostecenja u odnosu na standardno lakiranje', '2020-04-12 17:22:53', b'0'),
(91, 'Polufotelji Silvija KL', 1, '14500', 'Model na koji nije potrebno trošiti reči svaki detalj na polufotelji Silvija KL. je pažljivo osmišljen, od odabira materijala, boja sve do oblika rukonaslona.', '2020-04-12 20:29:19', b'0'),
(92, 'Lux', 6, '21500', 'Luksuz je odraz stabilnosti i kvaliteta i upravo su ovo osobine koje krase Lux krevet.\nPrepustite se mirnoj noći uz pouzdan model kreveta koji Vas sigurno neće izdati.', '2020-04-12 22:56:16', b'0'),
(94, 'Kanzona', 5, '2500', 'Nekada je Vašem trpezarijskom boravku potrebno samo malo svetlosti. Uvedite prozračnost u Vašu trpezariju uz Kanzona model.', '2020-04-20 12:20:28', b'0'),
(95, 'Saviola', 6, '22000', 'Oble linije Saviola kreveta upotpunjene su tamnom nijansom rama i uzglavlja kreveta. Ovaj model sa sandukom za odlaganje posteljine će se savršeno uklopiti u svaki dom. U cenu je uključen dušek.', '2020-04-22 15:16:29', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `proizvod_porudzbina`
--
-- Creation: Apr 26, 2020 at 05:04 PM
-- Last update: Apr 27, 2020 at 06:54 PM
--

CREATE TABLE `proizvod_porudzbina` (
  `porudzbinaId` int(11) NOT NULL,
  `proizvodId` int(11) NOT NULL,
  `kolicina` int(11) NOT NULL,
  `cenaProizvoda` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `proizvod_porudzbina`:
--   `proizvodId`
--       `proizvodi` -> `id`
--   `porudzbinaId`
--       `porudzbine` -> `id`
--

--
-- Dumping data for table `proizvod_porudzbina`
--

INSERT INTO `proizvod_porudzbina` (`porudzbinaId`, `proizvodId`, `kolicina`, `cenaProizvoda`) VALUES
(5, 2, 1, '39990'),
(7, 2, 1, '39990'),
(8, 2, 1, '39990'),
(9, 2, 1, '39990'),
(10, 2, 1, '39990'),
(11, 2, 1, '39990'),
(21, 2, 1, '39990'),
(5, 3, 1, '12999'),
(6, 3, 2, '12999'),
(10, 3, 1, '12999'),
(11, 3, 2, '12999'),
(12, 3, 1, '12999'),
(13, 3, 1, '12999'),
(18, 3, 1, '12000'),
(21, 3, 1, '12000'),
(5, 4, 2, '24999'),
(15, 4, 2, '24999'),
(23, 4, 1, '24999'),
(7, 5, 1, '4990'),
(8, 5, 2, '4990'),
(9, 5, 2, '4990'),
(10, 5, 1, '4990'),
(11, 5, 1, '4990'),
(12, 5, 1, '4990'),
(14, 5, 5, '4990'),
(24, 5, 2, '5000'),
(17, 89, 2, '15783'),
(20, 91, 1, '14500'),
(23, 92, 2, '21500'),
(19, 94, 2, '2500'),
(19, 95, 1, '22000');

-- --------------------------------------------------------

--
-- Table structure for table `slike`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `slike` (
  `id` int(11) NOT NULL,
  `src` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proizvodId` int(11) DEFAULT NULL,
  `uslugaId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `slike`:
--   `uslugaId`
--       `usluge` -> `id`
--   `proizvodId`
--       `proizvodi` -> `id`
--

--
-- Dumping data for table `slike`
--

INSERT INTO `slike` (`id`, `src`, `alt`, `tip`, `proizvodId`, `uslugaId`) VALUES
(1, 'kancSto.jpg', 'Slika proizvoda', 'proizvod', 3, NULL),
(2, 'knez.jpg', 'Slika proizvoda', 'proizvod', 1, NULL),
(3, 'Mari.jpg', 'Slika proizvoda', 'proizvod', 4, NULL),
(4, 'Modena.jpg', 'Slika proizvoda', 'proizvod', 2, NULL),
(5, 'roberta.jpg', 'Slika proizvoda', 'proizvod', 5, NULL),
(6, 'slide1.jpg', 'slider image', 'slider', NULL, NULL),
(7, 'slide2.jpg', 'slider image', 'slider', NULL, NULL),
(8, 'slide3.jpg', 'slider image', 'slider', NULL, NULL),
(9, 'mera.jpg', 'nameštaj po meri', 'usluga', NULL, 1),
(10, 'isporuka.jpg', 'Isporuka nameštaja', 'usluga', NULL, 2),
(11, 'montaza.jpg', 'Montaža nameštaja', 'usluga', NULL, 3),
(12, 'kvalitet.jpg', 'Kvalitet nameštaja', 'usluga', NULL, 4),
(16, 'vitorogOrmar.jpg', 'Vitorog ormar 2k', 'proizvod', 6, NULL),
(52, '1586712173.jpg', 'Slika proizvoda', 'proizvod', 89, NULL),
(54, '1586723359.jpg', 'Slika proizvoda', 'proizvod', 91, NULL),
(55, '1586732176.jpg', 'Slika proizvoda', 'proizvod', 92, NULL),
(57, '1587385228.jpg', 'Slika proizvoda', 'proizvod', 94, NULL),
(58, '1587568631.jpg', 'Slika proizvoda', 'proizvod', 95, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `specifikacije`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `specifikacije` (
  `proizvodId` int(11) NOT NULL,
  `karakId` int(11) NOT NULL,
  `vrednost` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `specifikacije`:
--   `karakId`
--       `karakteristike` -> `id`
--   `proizvodId`
--       `proizvodi` -> `id`
--

--
-- Dumping data for table `specifikacije`
--

INSERT INTO `specifikacije` (`proizvodId`, `karakId`, `vrednost`) VALUES
(1, 1, '68 cm'),
(1, 2, '79 cm'),
(1, 5, '58 cm'),
(2, 1, '175 cm'),
(2, 2, '93 cm'),
(2, 5, '85 cm'),
(3, 1, '160 cm'),
(3, 2, '75 cm'),
(3, 3, '80 cm'),
(4, 1, '235 cm'),
(4, 2, '77 cm'),
(4, 5, '140 cm'),
(5, 1, '55 cm'),
(5, 2, '85 cm'),
(5, 5, '48 cm'),
(6, 1, '80 cm'),
(6, 2, '200 cm'),
(6, 5, '54 cm'),
(89, 1, '47cm'),
(89, 2, '224cm'),
(89, 5, '165cm'),
(91, 1, '70 cm'),
(91, 2, '85 cm'),
(91, 5, '62 cm'),
(92, 1, '160 cm'),
(92, 2, '35 cm'),
(92, 5, '204 cm'),
(94, 1, '45 cm'),
(94, 2, '90 cm'),
(94, 5, '51 cm'),
(95, 1, '140 cm'),
(95, 2, '48 cm'),
(95, 5, '207 cm');

-- --------------------------------------------------------

--
-- Table structure for table `uloge`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `uloge` (
  `id` int(11) NOT NULL,
  `naziv` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `uloge`:
--

--
-- Dumping data for table `uloge`
--

INSERT INTO `uloge` (`id`, `naziv`) VALUES
(1, 'admin'),
(2, 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `usluge`
--
-- Creation: Apr 26, 2020 at 05:04 PM
--

CREATE TABLE `usluge` (
  `id` int(11) NOT NULL,
  `naslov` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tekst` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `usluge`:
--

--
-- Dumping data for table `usluge`
--

INSERT INTO `usluge` (`id`, `naslov`, `tekst`) VALUES
(1, 'Nameštaj po meri', 'Dozvolite našem timu da Vam pomogne u odabiru, planiranju i izradi nameštaja po Vašoj želji.'),
(2, 'Isporuka nameštaja', 'Naš salon nameštaja vrši isporuku nameštaja na Vašu kućnu adresu.Na skoro celoj teritoriji Srbije.'),
(3, 'Montaža nameštaja', 'Svaki kupljeni komad nameštaja u nasem salonu biće uredno montiran u vašem domu od strane naših profesionalno obučenih radnika.'),
(4, 'Pouzdanost i kvalitet', 'Svaki komad našeg nameštaja odlikuje kvalitet i pouzdanost koju potrvđujemo brojnim osvojenim nagrdama.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anketa`
--
ALTER TABLE `anketa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karakteristike`
--
ALTER TABLE `karakteristike`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategorije`
--
ALTER TABLE `kategorije`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `korIme` (`korIme`),
  ADD KEY `ulogaId` (`ulogaId`);

--
-- Indexes for table `korisnik_odgovor`
--
ALTER TABLE `korisnik_odgovor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOdg` (`idOdg`,`idKor`),
  ADD KEY `idKor` (`idKor`);

--
-- Indexes for table `mejlovi`
--
ALTER TABLE `mejlovi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigacija`
--
ALTER TABLE `navigacija`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `odgovori`
--
ALTER TABLE `odgovori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anketaId` (`anketaId`);

--
-- Indexes for table `porudzbine`
--
ALTER TABLE `porudzbine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `korisnikId` (`korisnikId`);

--
-- Indexes for table `proizvodi`
--
ALTER TABLE `proizvodi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_proizvodi_kategorije` (`kategorijaId`);

--
-- Indexes for table `proizvod_porudzbina`
--
ALTER TABLE `proizvod_porudzbina`
  ADD PRIMARY KEY (`proizvodId`,`porudzbinaId`),
  ADD KEY `porudzbinaId` (`porudzbinaId`);

--
-- Indexes for table `slike`
--
ALTER TABLE `slike`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_slikeUsluge` (`uslugaId`),
  ADD KEY `proizvodId` (`proizvodId`);

--
-- Indexes for table `specifikacije`
--
ALTER TABLE `specifikacije`
  ADD PRIMARY KEY (`proizvodId`,`karakId`),
  ADD KEY `karakId` (`karakId`);

--
-- Indexes for table `uloge`
--
ALTER TABLE `uloge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usluge`
--
ALTER TABLE `usluge`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anketa`
--
ALTER TABLE `anketa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `karakteristike`
--
ALTER TABLE `karakteristike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategorije`
--
ALTER TABLE `kategorije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `korisnik_odgovor`
--
ALTER TABLE `korisnik_odgovor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mejlovi`
--
ALTER TABLE `mejlovi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `navigacija`
--
ALTER TABLE `navigacija`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `odgovori`
--
ALTER TABLE `odgovori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `porudzbine`
--
ALTER TABLE `porudzbine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `proizvodi`
--
ALTER TABLE `proizvodi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `slike`
--
ALTER TABLE `slike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `uloge`
--
ALTER TABLE `uloge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usluge`
--
ALTER TABLE `usluge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD CONSTRAINT `korisnici_ibfk_1` FOREIGN KEY (`ulogaId`) REFERENCES `uloge` (`id`);

--
-- Constraints for table `korisnik_odgovor`
--
ALTER TABLE `korisnik_odgovor`
  ADD CONSTRAINT `korisnik_odgovor_ibfk_1` FOREIGN KEY (`idOdg`) REFERENCES `odgovori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `korisnik_odgovor_ibfk_2` FOREIGN KEY (`idKor`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `odgovori`
--
ALTER TABLE `odgovori`
  ADD CONSTRAINT `odgovori_ibfk_1` FOREIGN KEY (`anketaId`) REFERENCES `anketa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `porudzbine`
--
ALTER TABLE `porudzbine`
  ADD CONSTRAINT `porudzbine_ibfk_1` FOREIGN KEY (`korisnikId`) REFERENCES `korisnici` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `proizvodi`
--
ALTER TABLE `proizvodi`
  ADD CONSTRAINT `FK_proizvodi_kategorije` FOREIGN KEY (`kategorijaId`) REFERENCES `kategorije` (`id`);

--
-- Constraints for table `proizvod_porudzbina`
--
ALTER TABLE `proizvod_porudzbina`
  ADD CONSTRAINT `proizvod_porudzbina_ibfk_1` FOREIGN KEY (`proizvodId`) REFERENCES `proizvodi` (`id`),
  ADD CONSTRAINT `proizvod_porudzbina_ibfk_2` FOREIGN KEY (`porudzbinaId`) REFERENCES `porudzbine` (`id`);

--
-- Constraints for table `slike`
--
ALTER TABLE `slike`
  ADD CONSTRAINT `FK_slikeUsluge` FOREIGN KEY (`uslugaId`) REFERENCES `usluge` (`id`),
  ADD CONSTRAINT `slike_ibfk_1` FOREIGN KEY (`proizvodId`) REFERENCES `proizvodi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `specifikacije`
--
ALTER TABLE `specifikacije`
  ADD CONSTRAINT `specifikacije_ibfk_2` FOREIGN KEY (`karakId`) REFERENCES `karakteristike` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `specifikacije_ibfk_3` FOREIGN KEY (`proizvodId`) REFERENCES `proizvodi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

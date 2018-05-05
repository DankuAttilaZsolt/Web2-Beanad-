SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `web2`
--
CREATE DATABASE IF NOT EXISTS `web2` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `web2`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `motor_blokkok`
--

CREATE TABLE IF NOT EXISTS `motor_blokkok` (
  `mb_id` int(11) NOT NULL,
  `mb_sorrend` int(11) NOT NULL,
  `mb_cim` varchar(200) COLLATE utf8_hungarian_ci NOT NULL,
  `mb_jogok` varchar(5) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `motor_blokkok`
--

INSERT INTO `motor_blokkok` (`mb_id`, `mb_sorrend`, `mb_cim`, `mb_jogok`) VALUES
(1, 1, 'Kedvencek', '111');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `motor_felhasznalok`
--

CREATE TABLE IF NOT EXISTS `motor_felhasznalok` (
  `fh_id` int(11) NOT NULL AUTO_INCREMENT,
  `fh_fnev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `fh_jelszo` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `fh_tnev` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `fh_email` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `fh_aktiv` smallint(6) NOT NULL,
  `fh_szint` int(11) NOT NULL,
  `fh_lastlogin` datetime NOT NULL,
  PRIMARY KEY (`fh_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=3 ;

--
-- A tábla adatainak kiíratása `motor_felhasznalok`
--

INSERT INTO `motor_felhasznalok` (`fh_id`, `fh_fnev`, `fh_jelszo`, `fh_tnev`, `fh_email`, `fh_aktiv`, `fh_szint`, `fh_lastlogin`) VALUES
(1, 'admin', sha1('proba1'), 'Webmester', 'webmester@szoa.hu', 1, 3, '2012-03-03 13:54:16'),
(2, 'danku', sha1('proba2'), 'Danku Attila', 'dankuattilazsolt@gmail.com', 1, 2, '2011-09-13 04:13:49');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `motor_oldalak`
--

CREATE TABLE IF NOT EXISTS `motor_oldalak` (
  `mo_id` int(11) NOT NULL,
  `mo_alias` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `mo_cim` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `mo_sorrend` int(11) NOT NULL,
  `mo_felettes` int(11) NOT NULL,
  `mo_aktiv` int(11) NOT NULL,
  `mo_pubdate` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  `mo_unpubdate` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  `mo_fk_blokkid` int(11) NOT NULL,
  `mo_bsorrend` int(11) NOT NULL,
  `mo_jogok` varchar(5) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`mo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `motor_oldalak`
--

INSERT INTO `motor_oldalak` (`mo_id`, `mo_alias`, `mo_cim`, `mo_sorrend`, `mo_felettes`, `mo_aktiv`, `mo_pubdate`, `mo_unpubdate`, `mo_fk_blokkid`, `mo_bsorrend`, `mo_jogok`) VALUES
(1, 'nyitolap', 'Nyitólap', 1, 0, 1, '2011-03-11 00:00:00', '2111-03-11 00:00:00', 1, 0, '111' ),
(2, 'elerhetoseg', 'Elérhetőség', 30, 0, 1, '2011-03-11 00:00:00', '2111-03-11 00:00:00', 1, 0, '110'),
(3, 'linkek', 'Linkek', 40, 0, 1, '2011-03-11 00:00:00', '2111-03-11 00:00:00', 0, 0, '111'),
(4, 'alapinfok', 'Alapinfók', 1, 1, 1, '2011-03-11 00:00:00', '2111-03-11 00:00:00', 0, 0, '111' ),
(5, 'videok', 'Videók', 20, 0, 1, '2018-03-09 00:00:00', '2020-03-09 00:00:00', 1, 1, '011'),
(6, 'belepes', 'Belépés', 99, 0, 1, '2011-03-11 00:00:00', '2111-03-11 00:00:00', 1, 5, '100'),
(7, 'kilepes', 'Kilépés', 99, 1, 1, '2012-03-01 00:00:00', '2112-03-01 00:00:00', 1, 5, '011'),
(8, 'admin', 'Admin', 90, 0, 1, '2012-01-01 00:00:00', '2100-12-31 23:59:59', 1, 0, '001'),
(9, 'regisztracio', 'Regisztráció', 90, 0, 1, '2018-03-08 00:00:00', '2020-03-08 00:00:00', 1, 4, '100'),
(10, 'vapek', 'Vapek', 10, 0, 1, '2018-03-08 00:00:00', '2020-03-08 00:00:00', 1, 0, '011'),
(11, 'vaporesso', 'Vaporesso', 1, 10, 1, '2018-03-08 00:00:00', '2020-03-08 00:00:00', 0, 0, '011'),
(12, 'smok', 'Smok', 2, 10, 1, '2018-03-08 00:00:00', '2020-03-08 00:00:00', 0, 0, '011'),
(13, 'vandy', 'Vandy Vape', 3, 10, 1, '2018-03-08 00:00:00', '2020-03-08 00:00:00', 0, 0, '011'),
(14, 'wismec', 'Wismec', 4, 10, 1, '2018-03-08 00:00:00', '2020-03-08 00:00:00', 0, 0, '011'),
(15, 'vgod', 'VGOD', 5, 10, 1, '2018-03-08 00:00:00', '2020-03-08 00:00:00', 0, 0, '011'),
(404, 'hiba', '', 0, 0, 1, '2011-01-01 00:00:00', '2111-01-01 00:00:00', 0, 0, '111'),
(16, 'kommnet', 'Kommentek', 70, 1, 1, '2011-01-01 00:00:00', '2111-01-01 00:00:00', 1, 4, '011');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `motor_szintek`
--

CREATE TABLE IF NOT EXISTS `motor_szintek` (
  `msz_id` int(11) NOT NULL,
  `msz_nev` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `msz_rovid` varchar(10) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`msz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `motor_szintek`
--

INSERT INTO `motor_szintek` (`msz_id`, `msz_nev`, `msz_rovid`) VALUES
(1, 'anonim', 'af'),
(2, 'bejelentkezett', 'bf'),
(3, 'admin', 'ad');

CREATE TABLE IF NOT EXISTS `motor_hozzaszolas` (
  `mh_id` int(11) NOT NULL,
  `mh_fnev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `mh_hozzaszol` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `mh_date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

INSERT INTO `motor_hozzaszolas` (`mh_id`, `mh_fnev`, `mh_hozzaszol`, `mh_date`) VALUES
(1, 'admin', 'Üdv mindenkinek!
   Itt tudtok kommenteket írni és olvasni.','2018-03-11 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


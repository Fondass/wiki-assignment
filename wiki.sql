-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 24 jun 2016 om 10:33
-- Serverversie: 5.6.17
-- PHP-versie: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `wiki`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `content` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastedit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=22 ;

--
-- Gegevens worden geëxporteerd voor tabel `pages`
--

INSERT INTO `pages` (`id`, `name`, `content`, `users_id`, `createdate`, `lastedit`) VALUES
(1, 'Doritos', '[h3]Doritos is maar een placeholder pagina[/h3]\r\n[br]\r\n[b]plaatje:[/b]\r\n[br]\r\n[img]https://img.buzzfeed.com/buzzfeed-static/static/2015-09/23/13/enhanced/webdr07/enhanced-10715-1443028462-5.jpg[/img]\r\n[br]\r\nen dan nu de [b]link die[/b] hier zou moeten komen:\r\n[br]\r\n[link]https://www.google.nl[linktext]to google![/link]', 1, '2016-06-01 07:20:19', '2016-06-08 11:48:57'),
(18, 'dingen', 'dingend ingeninesionfe kaj ', 9, '2016-06-21 07:55:32', NULL),
(19, 'sgsdfdsffasdfs', 'sfdsfSgd', 9, '2016-06-21 13:38:38', NULL),
(4, 'winnen in mijn ziel', 'dingen in mijn hart', 0, '2016-06-03 08:28:52', NULL),
(12, 'sfsdf', 'dvdsvvvdsvds', 2, '2016-06-08 13:16:04', NULL),
(5, 'Warcraft', 'Make love not warcraft, or maybe do i dunno you decide', 0, '2016-06-06 07:57:56', NULL),
(6, 'info', 'This is an information page made to display information about the site...\r\n\r\nIsn''t it a marvelous piece of website building.... HUUUURAAAAY.\r\n\r\nlong live the king.\r\n\r\n\r\n\r\ndinge die aanpassen enzo wawawawawafesfesfaw lololol fesfdasdaesfes ff[br][br]\r\n\r\n[youtube]https://www.youtube.com/watch?v=BuTXN7jm6MQ[/youtube]', 0, '2016-06-06 13:18:13', '2016-06-20 12:18:27'),
(9, 'grgrdgh', 'thtrshtsrhtsrhtrhtrhtr', 0, '2016-06-07 07:37:28', NULL),
(8, ' &lt;fjengrdsng&gt;', 'fesrgnjrdnvkljenwkgndfjnvjkdsnvlknk &lt;div id=&quot;menubutton&quot;&gt; fheshks &lt;/div&gt;', 0, '2016-06-07 07:15:00', NULL),
(10, 'testestestes', 'testestestestestestestestestestestestestest', 0, '2016-06-07 07:53:42', NULL),
(11, 'gbfbngfnn', 'ngfxnxgfmgmcgyn', 1, '2016-06-07 12:54:54', NULL),
(13, 'Editor Input test', '[h1]h1 title Test[/h1]\r\n[br]\r\nSome sample text and stuff\r\n[br]\r\n[img]http://www.opnlttr.com/sites/default/files/woman-crying_4.jpg[/img]\r\n[br]\r\n[b]Bunch of metalheads agreeing with this test[/b]\r\n[br][br]\r\n[h2]h2 test in preparation for the test[/h2]\r\n[br]\r\n[br]\r\n[youtube]https://www.youtube.com/watch?v=v3Rbr3JvIMg[/youtube]\r\n[br]\r\n[h3]h3 text here[/h3]\r\n[br]\r\n[h4]h4 text here[/h4]\r\n', 2, '2016-06-09 09:38:24', '2016-06-22 09:33:41'),
(14, 'dfasfesfes', '[br][img]image link here[/img][link]Link here[linktext]Link text here[/link][h3]h3 text here[/h3]', 9, '2016-06-15 17:32:59', NULL),
(15, 'New page test', 'eksgnsdongrdshkjdxogjlhjfsklfjkraljhto;/ldzlsjf;ot/koeisjrh;hf', 9, '2016-06-20 08:13:50', NULL),
(16, 'sdad', 'sadsadsafasfsad', 9, '2016-06-20 08:15:25', NULL),
(17, 'safsdfs', 'fsfesfeGegrdfzrfrzf', 9, '2016-06-20 12:18:19', NULL),
(20, 'dsfdsfdsfd', 'fffsfdsfd', 9, '2016-06-22 09:40:48', NULL),
(21, 'dsfdgd', 'sffdsfdsfdsfds', 9, '2016-06-22 09:40:57', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pages_tags`
--

CREATE TABLE IF NOT EXISTS `pages_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pages_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=92 ;

--
-- Gegevens worden geëxporteerd voor tabel `pages_tags`
--

INSERT INTO `pages_tags` (`id`, `pages_id`, `tags_id`) VALUES
(89, 13, 2),
(45, 12, 1),
(44, 1, 3),
(4, 3, 4),
(5, 3, 5),
(6, 4, 3),
(29, 8, 4),
(13, 5, 3),
(12, 5, 2),
(11, 5, 1),
(14, 5, 4),
(15, 5, 5),
(43, 1, 2),
(42, 1, 1),
(85, 6, 5),
(84, 6, 2),
(30, 9, 1),
(31, 9, 2),
(32, 10, 3),
(35, 11, 1),
(88, 13, 1),
(50, 14, 2),
(51, 14, 3),
(52, 14, 4),
(81, 15, 2),
(82, 16, 3),
(83, 17, 4),
(86, 18, 2),
(87, 19, 3),
(90, 20, 3),
(91, 21, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `pages_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=YTF8 AUTO_INCREMENT=151 ;

--
-- Gegevens worden geëxporteerd voor tabel `rating`
--

INSERT INTO `rating` (`id`, `pages_id`, `rating`, `users_id`) VALUES
(136, 6, 10, 9),
(137, 6, 1, 9),
(138, 6, 1, 9),
(139, 6, 10, 9),
(140, 6, 10, 9),
(141, 1, 1, 9),
(142, 1, 1, 9),
(143, 1, 1, 9),
(144, 1, 9, 9),
(145, 13, 8, 9),
(146, 4, 7, 9),
(147, 4, 7, 9),
(148, 4, 7, 9),
(149, 12, 7, 9),
(150, 5, 8, 9);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=6 ;

--
-- Gegevens worden geëxporteerd voor tabel `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'Magic'),
(2, 'Swords'),
(3, 'Monsters'),
(4, 'Siege Engine'),
(5, 'Kingdoms');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `password` varchar(68) NOT NULL,
  `permission` int(11) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastlogin` timestamp NULL DEFAULT NULL,
  `salt` varchar(34) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=12 ;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `permission`, `regdate`, `lastlogin`, `salt`) VALUES
(1, 'Foo', 'bar', 1, '2016-06-01 07:16:57', NULL, ''),
(2, 'sybren', 'bos', 2, '2016-06-07 08:59:34', NULL, ''),
(3, 'bloop', '72de11ae99dc5e5bfafb3437c9e93f42968', 1, '2016-06-09 10:25:43', NULL, ''),
(4, 'fondas', '4dfdd799ec61842e46271ad45a729c13bfca5419d313bcfb2c9a78fb33b43dc8', 2, '2016-06-09 10:34:31', NULL, 'šõ;¬K¶ì»ü®†3M÷+Y2­Sx§Àd‘tn'),
(5, 'blabla', '0541610897890a30f11144b4e321498e40b320d6613687ef3fe4b8f055d90a5d', 1, '2016-06-09 10:37:25', NULL, 'Õið8™#3ÙËDg·+aÊN•q£fiÑ•1•×9·'),
(6, 'hok', '2699089e64272fe0f7ce190b1cdbd1efef6ab327cf08050489cd763a8d7b2ede', 1, '2016-06-09 11:16:15', NULL, '‡5&\r‡ßE‡U’é7B¹E‰,’—''û,Póæ]\Z'),
(7, 'wat', '2f9753d2eb387b8a8cf64aecea2447aa64653d9a1db28812063df031b24416ec', 1, '2016-06-09 11:17:31', NULL, 'ƒ]æµ™¼äKNõÞU	¹»ý\0¡?‹¦Íl°tê{'),
(8, 'apapap', '7f760524b28a750426eb1be93346c682098f9a42869486504316cf4cca2137ed', 1, '2016-06-09 11:17:58', NULL, 'I²Ê¼ª½xÇnœ³€üùÃÙÉŽ8¤¡ùàX_ª'),
(9, 'emperer', '71e2b4eea37ebd818a2dc7b7da4d77274a84b5b75aa8b06d7ba373c95b02989c', 2, '2016-06-13 08:01:30', NULL, 'TÈp´Ý¾iÕAÊ¬_$ÖÜ€?½ðü™æÄëT {³'),
(10, 'ding', 'a8c8bf94b0687b01c82b05766bffd0f14e34a86248a91046eef2c3ea0ffdcd28', 1, '2016-06-21 07:55:53', NULL, 'knÀ¼Y$xõArV	ë¦£vBÄM`Â@ÝÉ'),
(11, 'wow', 'd84ee13b38bf00683ebc8337aac87c581ba364a5dbbb8b2e45ed6f18342625fd', 1, '2016-06-21 07:56:05', NULL, 'g	 s¥˜ ¸›qPÓ{tÎ‹••F-”ô’x–éç«j_');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

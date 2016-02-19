-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 19 feb 2016 om 21:20
-- Serverversie: 5.6.21
-- PHP-versie: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `school`
--

--
-- Gegevens worden geëxporteerd voor tabel `cursus`
--

INSERT INTO `cursus` (`id`, `begin_datum`, `eind_datum`, `image`, `soort_cursus_id`) VALUES
(2, '2016-02-22', '2016-02-26', 'http://www.vrijwilligersacademiehaarlem.nl/images/iStock_000018516780Medium.jpg', 5),
(3, '2016-02-22', '2016-02-26', 'https://www.centrumvoorafstandsonderwijs.be/wp-content/uploads/2012/09/cursus-paarden-dierenzorg.jpg', 6),
(4, '2016-02-22', '2016-02-26', 'http://www.swapsupport.nl/wordpress/wp-content/uploads/2015/08/motor-iStock_000034948636_Large-e1438873453713.jpg', 8),
(6, '2016-02-29', '2016-03-04', 'http://www.dehuisaanhuis.nl/files/2012/02/fh-huis-en-tuin.jpg', 7),
(7, '2016-02-29', '2016-03-04', 'http://www.vabi.be/vabi_video/screenshot_dierenzorg.jpg', 6),
(8, '2016-02-29', '2016-03-04', 'http://www.briljantemislukkingen.nl/wp-content/uploads/2011/12/techniek.jpg', 8),
(9, '2016-02-29', '2016-03-04', 'http://www.baylan.nl/images/temp/slide3.jpg', 5);

--
-- Gegevens worden geëxporteerd voor tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `role`) VALUES
(1, 'cursist', 'ROLE_USER'),
(2, 'admin', 'ROLE_ADMIN');

--
-- Gegevens worden geëxporteerd voor tabel `soortcursus`
--

INSERT INTO `soortcursus` (`id`, `naam`, `prijs`) VALUES
(5, 'Administratie', 6500),
(6, 'Dierenzorg', 7500),
(7, 'Huis en tuin', 5000),
(8, 'Techniek', 8900);

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `voornaam`, `tussen_voegsels`, `achternaam`, `password`, `adres`, `woonplaats`, `telefoon`, `is_active`) VALUES
(1, 'alwintje', 'alwinkroesen@gmail.com', 'Alwin', '', 'Kroesen', '$2y$12$kP.d/Gc5nbA8QKwJk3F4VOtiJ9ZPqlXkKSPEoZJOQZz0y8oHNOH1u', 'Parallelweg 82', 'De Krim', '0626667079', 1),
(5, 'gerr', 'gboersma@gmail.com', 'Gerrit', '', 'Boersma', '$2y$12$5W16hoV5XM86KbQYb79BpO9Td2Weln2YBCUkgj5ewhJuZzzbGrwE2', 'Kastendijk 88', 'Nijmegen', '0612345678', 1),
(6, 'simon', 'sloos@gmail.com', 'Simon', '', 'Loos', '$2y$12$DWcQQk5FhD9y0RJGPUb1DOAf/T6dQqZKvDNBbqltAxpPHazoVXfbW', 'Lange Poten 21', 'Den Haag', '0612345678', 1),
(7, 'jan', 'jschoppe@gmail.com', 'Jan', '', 'Schoppe', '$2y$12$R5rMITg6D8V5kpMBCsYVveyLbihIKRqo4IRuNWOu4cfpbAJpWEJLO', 'Sloopbaan 1', 'Scheveningen', '0612345678', 0),
(8, 'Admin', 'admin@omega.com', 'Admin', '', 'Beheerder', '$2y$12$r.toonuQV2kKmjP87xxTbuaki1ILs7U0/bgukHqTdzbwzfU04Pn4y', 'geen', 'geen', '+31612345678', 1);

--
-- Gegevens worden geëxporteerd voor tabel `user_cursus`
--

INSERT INTO `user_cursus` (`user_id`, `cursus_id`) VALUES
(1, 2);

--
-- Gegevens worden geëxporteerd voor tabel `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(1, 2),
(5, 1),
(6, 1),
(7, 1),
(8, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

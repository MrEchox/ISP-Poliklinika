-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 11:58 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ataskaita`
--

CREATE TABLE `ataskaita` (
  `Data` date NOT NULL,
  `AtaskaitosId` int(10) NOT NULL,
  `GydytojoKomentarai` text NOT NULL,
  `fk_Pacientas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `ataskaita`
--

INSERT INTO `ataskaita` (`Data`, `AtaskaitosId`, `GydytojoKomentarai`, `fk_Pacientas_id`) VALUES
('2023-12-03', 1, 'Lorem ipsum', 1),
('2023-12-14', 2, 'Neveikia', 2),
('2023-12-14', 3, 'VEIKIA PIRMAS', 1),
('2023-12-14', 4, 'VEIKIA ANTRAS', 2),
('2023-12-14', 5, 'a', 1),
('2023-12-14', 6, 'a', 1),
('2023-12-14', 7, 'Test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `atsiliepimas`
--

CREATE TABLE `atsiliepimas` (
  `id` int(11) NOT NULL,
  `Data` date DEFAULT NULL,
  `Ivertis` int(1) NOT NULL,
  `Komentaras` text NOT NULL,
  `fk_Naudotojas_EPastas` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `atsiliepimas`
--

INSERT INTO `atsiliepimas` (`id`, `Data`, `Ivertis`, `Komentaras`, `fk_Naudotojas_EPastas`) VALUES
(2, '0000-00-00', 4, 'aa', 'Svecias@Svecias.lt'),
(3, '2023-11-30', 2, 'Lorem Ipsum', 'Svecias@Svecias.lt');

-- --------------------------------------------------------

--
-- Table structure for table `gydytojas`
--

CREATE TABLE `gydytojas` (
  `id` int(11) NOT NULL,
  `Pareigos` varchar(40) NOT NULL,
  `Kabinetas` varchar(20) NOT NULL,
  `fk_Naudotojas_EPastas` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `gydytojas`
--

INSERT INTO `gydytojas` (`id`, `Pareigos`, `Kabinetas`, `fk_Naudotojas_EPastas`) VALUES
(1, 'Dermatologas', '111', 'Gydytojas@Gydytojas.lt'),
(3, 'Chirurgas', 'Nepriskirtas', 'john@cena.com'),
(4, 'Šeimos Gyd.', 'Nepriskirtas', 'mantas@mantas.com');

-- --------------------------------------------------------

--
-- Table structure for table `inventorius`
--

CREATE TABLE `inventorius` (
  `Pavadinimas` varchar(40) NOT NULL,
  `Kiekis` int(10) NOT NULL,
  `PaskutinisPildymas` date NOT NULL,
  `Bukle` enum('Puiki','Gera','Patenkinama','ReikiaKeisti') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `inventorius`
--

INSERT INTO `inventorius` (`Pavadinimas`, `Kiekis`, `PaskutinisPildymas`, `Bukle`) VALUES
('Švirkštai', 12, '2023-11-08', 'Gera'),
('Pleistras', 500, '2023-10-10', 'Patenkinama');

-- --------------------------------------------------------

--
-- Table structure for table `konsultacija`
--

CREATE TABLE `konsultacija` (
  `Data` date NOT NULL,
  `Laikas` time NOT NULL,
  `fk_Pacientas_AsmensKodas` int(11) NOT NULL,
  `fk_Gydytojas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `konsultacija`
--

INSERT INTO `konsultacija` (`Data`, `Laikas`, `fk_Pacientas_AsmensKodas`, `fk_Gydytojas_id`) VALUES
('2023-12-20', '16:00:00', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lankymas`
--

CREATE TABLE `lankymas` (
  `paciento_varpav` varchar(30) NOT NULL,
  `data` date NOT NULL,
  `fk_Naudotojas_EPastas` varchar(30) NOT NULL,
  `santykis` varchar(20) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `naudotojas`
--

CREATE TABLE `naudotojas` (
  `Vardas` varchar(20) NOT NULL,
  `Pavarde` varchar(20) NOT NULL,
  `EPastas` varchar(30) NOT NULL,
  `TelefonoNr` varchar(11) NOT NULL,
  `Slaptazodis` varchar(500) NOT NULL,
  `Role` enum('Svecias','Pacientas','Gydytojas','Administratorius') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `naudotojas`
--

INSERT INTO `naudotojas` (`Vardas`, `Pavarde`, `EPastas`, `TelefonoNr`, `Slaptazodis`, `Role`) VALUES
('Administratorius', 'Administratorius', 'Admin@Admin.lt', '+1234567891', 'demo', 'Administratorius'),
('Gydytojas', 'Gydytojas', 'Gydytojas@Gydytojas.lt', '+1234567891', 'demo', 'Gydytojas'),
('John', 'Cena', 'john@cena.com', '+3708612345', 'demo', 'Gydytojas'),
('Mantas', 'Test', 'mantas@mantas.com', '+3708684624', 'm', 'Gydytojas'),
('Pacientas', 'Pacientas', 'Pacientas@Pacientas.lt', '+1234567891', 'demo', 'Pacientas'),
('Pacientas2', 'Pacientas2', 'Pacientas2@Pacientas.lt', '+1234567891', 'demo', 'Pacientas'),
('Svecias', 'Svecias', 'Svecias@Svecias.lt', '+1234567891', 'demo', 'Svecias');

-- --------------------------------------------------------

--
-- Table structure for table `pacientas`
--

CREATE TABLE `pacientas` (
  `Adresas` varchar(50) NOT NULL,
  `AsmensKodas` int(11) NOT NULL,
  `Darboviete` varchar(50) NOT NULL,
  `Amzius` int(3) NOT NULL,
  `Svoris` int(3) NOT NULL,
  `Ugis` int(3) NOT NULL,
  `KraujoGr` varchar(4) NOT NULL,
  `Alergijos` tinyint(1) NOT NULL,
  `fk_Gydytojas_id` int(11) NOT NULL,
  `fk_Naudotojas_EPastas` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `pacientas`
--

INSERT INTO `pacientas` (`Adresas`, `AsmensKodas`, `Darboviete`, `Amzius`, `Svoris`, `Ugis`, `KraujoGr`, `Alergijos`, `fk_Gydytojas_id`, `fk_Naudotojas_EPastas`) VALUES
('Miesto g. 1, Miestas', 1, 'Darbo g. 1, Darbomiestis', 22, 80, 180, 'AB+', 0, 4, 'Pacientas@Pacientas.lt'),
('Kaimo g. 2, Kaimas', 2, 'Darbo g. 1, Darbomiestis', 36, 110, 174, 'O+', 0, 1, 'Pacientas2@Pacientas.lt');

-- --------------------------------------------------------

--
-- Table structure for table `siuntimas`
--

CREATE TABLE `siuntimas` (
  `Data` date NOT NULL,
  `KlinikineDiagnoze` varchar(40) NOT NULL,
  `Skyrius` varchar(20) NOT NULL,
  `PagrindineDiagnoze` text NOT NULL,
  `fk_Gydytojas-id` int(11) NOT NULL,
  `fk_Pacientas-AsmensKodas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `siuntimas`
--

INSERT INTO `siuntimas` (`Data`, `KlinikineDiagnoze`, `Skyrius`, `PagrindineDiagnoze`, `fk_Gydytojas-id`, `fk_Pacientas-AsmensKodas`) VALUES
('2023-12-10', 'Lorem ipsum', 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae venenatis elit. Fusce eu purus ac nibh lacinia eleifend. Duis pretium tempor auctor. Sed id ante feugiat, placerat dui id, commodo purus. Sed non convallis dui. Donec elit ipsum, bibendum vitae tristique ac, ornare ac nunc. Duis et felis porta, interdum lacus aliquam, bibendum justo. Cras ultrices urna sit amet elit iaculis, nec fringilla eros aliquet. Suspendisse eget aliquet leo, et volutpat libero. Proin nec orci dapibus, congue mauris at, luctus turpis. Praesent id quam a turpis dapibus malesuada vel eu magna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras finibus lacus justo, eu ultrices magna commodo id.', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tyrimas`
--

CREATE TABLE `tyrimas` (
  `Pavadinimas` varchar(40) NOT NULL,
  `Analize` text NOT NULL,
  `Svarba` varchar(10) NOT NULL,
  `Kaina` int(10) NOT NULL,
  `Busena` tinyint(1) NOT NULL,
  `fk_Naudotojas_EPastas` varchar(30) NOT NULL,
  `fk_Gydytojas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `tyrimas`
--

INSERT INTO `tyrimas` (`Pavadinimas`, `Analize`, `Svarba`, `Kaina`, `Busena`, `fk_Naudotojas_EPastas`, `fk_Gydytojas_id`) VALUES
('Lorem Ipsum', 'aaasqasadasdasd', 'aa', 11, 0, 'mantas@mantas.com', 4),
('Tyrimas Test 1', 'aaaaaaa', 'Svarbu', 1174, 0, 'Svecias@Svecias.lt', 4),
('Tyrimas Test 2', 'bbbb', 'Svarbu', 22, 0, 'Svecias@Svecias.lt', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tyrimo_uzsakymas`
--

CREATE TABLE `tyrimo_uzsakymas` (
  `id` int(50) NOT NULL,
  `fk_Naudotojas_EPastas` varchar(30) NOT NULL,
  `Reikalavimas` varchar(20) DEFAULT NULL,
  `Skausmai` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `tyrimo_uzsakymas`
--

INSERT INTO `tyrimo_uzsakymas` (`id`, `fk_Naudotojas_EPastas`, `Reikalavimas`, `Skausmai`) VALUES
(1, 'Svecias@Svecias.lt', 'aaa', 'bbb');

-- --------------------------------------------------------

--
-- Table structure for table `uzsakymas`
--

CREATE TABLE `uzsakymas` (
  `Pavadinimas` varchar(40) NOT NULL,
  `Kiekis` int(10) NOT NULL,
  `fk_Naudotojas-EPastas` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaistas`
--

CREATE TABLE `vaistas` (
  `Pavadinimas` varchar(20) NOT NULL,
  `GaliojimoData` date NOT NULL,
  `Receptinis` tinyint(1) NOT NULL,
  `Pavidalas` enum('Tabletes','Kapsules','Skystis','Milteliai') NOT NULL,
  `fk_Pacientas_AsmensKodas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `vaistas`
--

INSERT INTO `vaistas` (`Pavadinimas`, `GaliojimoData`, `Receptinis`, `Pavidalas`, `fk_Pacientas_AsmensKodas`) VALUES
('Lorem Ipsum', '2025-12-10', 1, 'Kapsules', 1),
('Gelamirtol', '2024-12-14', 2, '', 1),
('Kazkas', '2024-12-14', 3, '', 2),
('Test', '2024-12-14', 4, '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ataskaita`
--
ALTER TABLE `ataskaita`
  ADD PRIMARY KEY (`AtaskaitosId`),
  ADD KEY `fk_Pacientas_id` (`fk_Pacientas_id`);

--
-- Indexes for table `atsiliepimas`
--
ALTER TABLE `atsiliepimas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Naudotojas_EPastas` (`fk_Naudotojas_EPastas`);

--
-- Indexes for table `gydytojas`
--
ALTER TABLE `gydytojas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Naudotojas_EPastas` (`fk_Naudotojas_EPastas`) USING BTREE;

--
-- Indexes for table `konsultacija`
--
ALTER TABLE `konsultacija`
  ADD KEY `fk_Gydytojas-id` (`fk_Gydytojas_id`),
  ADD KEY `fk_Pacientas-AsmensKodas` (`fk_Pacientas_AsmensKodas`);

--
-- Indexes for table `lankymas`
--
ALTER TABLE `lankymas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Naudotojas-EPastas` (`fk_Naudotojas_EPastas`);

--
-- Indexes for table `naudotojas`
--
ALTER TABLE `naudotojas`
  ADD PRIMARY KEY (`EPastas`);

--
-- Indexes for table `pacientas`
--
ALTER TABLE `pacientas`
  ADD PRIMARY KEY (`AsmensKodas`),
  ADD KEY `fk_Naudotojas_EPastas` (`fk_Naudotojas_EPastas`) USING BTREE,
  ADD KEY `fk_Gydytojas_id` (`fk_Gydytojas_id`) USING BTREE;

--
-- Indexes for table `siuntimas`
--
ALTER TABLE `siuntimas`
  ADD KEY `fk_Pacientas_AsmensKodas` (`fk_Pacientas-AsmensKodas`) USING BTREE,
  ADD KEY `fk_Gydytojas_id` (`fk_Gydytojas-id`) USING BTREE;

--
-- Indexes for table `tyrimas`
--
ALTER TABLE `tyrimas`
  ADD PRIMARY KEY (`Pavadinimas`),
  ADD KEY `fk_Gydytojas-id` (`fk_Gydytojas_id`),
  ADD KEY `fk_Naudotojas-EPastas` (`fk_Naudotojas_EPastas`);

--
-- Indexes for table `tyrimo_uzsakymas`
--
ALTER TABLE `tyrimo_uzsakymas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uzsakymas`
--
ALTER TABLE `uzsakymas`
  ADD KEY `fk_Naudotojas-EPastas` (`fk_Naudotojas-EPastas`);

--
-- Indexes for table `vaistas`
--
ALTER TABLE `vaistas`
  ADD PRIMARY KEY (`Receptinis`),
  ADD KEY `fk_Pacientas-AsmensKodas` (`fk_Pacientas_AsmensKodas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ataskaita`
--
ALTER TABLE `ataskaita`
  MODIFY `AtaskaitosId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `atsiliepimas`
--
ALTER TABLE `atsiliepimas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gydytojas`
--
ALTER TABLE `gydytojas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lankymas`
--
ALTER TABLE `lankymas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tyrimo_uzsakymas`
--
ALTER TABLE `tyrimo_uzsakymas`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vaistas`
--
ALTER TABLE `vaistas`
  MODIFY `Receptinis` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ataskaita`
--
ALTER TABLE `ataskaita`
  ADD CONSTRAINT `fk_Pacientas` FOREIGN KEY (`fk_Pacientas_id`) REFERENCES `pacientas` (`AsmensKodas`);

--
-- Constraints for table `atsiliepimas`
--
ALTER TABLE `atsiliepimas`
  ADD CONSTRAINT `atsiliepimas_ibfk_1` FOREIGN KEY (`fk_Naudotojas_EPastas`) REFERENCES `naudotojas` (`EPastas`);

--
-- Constraints for table `gydytojas`
--
ALTER TABLE `gydytojas`
  ADD CONSTRAINT `gydytojas_ibfk_1` FOREIGN KEY (`fk_Naudotojas_EPastas`) REFERENCES `naudotojas` (`EPastas`);

--
-- Constraints for table `konsultacija`
--
ALTER TABLE `konsultacija`
  ADD CONSTRAINT `konsultacija_ibfk_1` FOREIGN KEY (`fk_Gydytojas_id`) REFERENCES `gydytojas` (`id`),
  ADD CONSTRAINT `konsultacija_ibfk_2` FOREIGN KEY (`fk_Pacientas_AsmensKodas`) REFERENCES `pacientas` (`AsmensKodas`);

--
-- Constraints for table `lankymas`
--
ALTER TABLE `lankymas`
  ADD CONSTRAINT `lankymas_ibfk_1` FOREIGN KEY (`fk_Naudotojas_EPastas`) REFERENCES `naudotojas` (`EPastas`);

--
-- Constraints for table `pacientas`
--
ALTER TABLE `pacientas`
  ADD CONSTRAINT `pacientas_ibfk_1` FOREIGN KEY (`fk_Naudotojas_EPastas`) REFERENCES `naudotojas` (`EPastas`),
  ADD CONSTRAINT `pacientas_ibfk_2` FOREIGN KEY (`fk_Gydytojas_id`) REFERENCES `gydytojas` (`id`);

--
-- Constraints for table `siuntimas`
--
ALTER TABLE `siuntimas`
  ADD CONSTRAINT `siuntimas_ibfk_1` FOREIGN KEY (`fk_Gydytojas-id`) REFERENCES `gydytojas` (`id`),
  ADD CONSTRAINT `siuntimas_ibfk_2` FOREIGN KEY (`fk_Pacientas-AsmensKodas`) REFERENCES `pacientas` (`AsmensKodas`);

--
-- Constraints for table `tyrimas`
--
ALTER TABLE `tyrimas`
  ADD CONSTRAINT `tyrimas_ibfk_1` FOREIGN KEY (`fk_Gydytojas_id`) REFERENCES `gydytojas` (`id`),
  ADD CONSTRAINT `tyrimas_ibfk_2` FOREIGN KEY (`fk_Naudotojas_EPastas`) REFERENCES `naudotojas` (`EPastas`);

--
-- Constraints for table `uzsakymas`
--
ALTER TABLE `uzsakymas`
  ADD CONSTRAINT `uzsakymas_ibfk_1` FOREIGN KEY (`fk_Naudotojas-EPastas`) REFERENCES `naudotojas` (`EPastas`);

--
-- Constraints for table `vaistas`
--
ALTER TABLE `vaistas`
  ADD CONSTRAINT `vaistas_ibfk_1` FOREIGN KEY (`fk_Pacientas_AsmensKodas`) REFERENCES `pacientas` (`AsmensKodas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

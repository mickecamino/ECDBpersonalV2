-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 14, 2018 at 08:49 PM
-- Server version: 5.5.57-0+deb8u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ecdb`
--
CREATE DATABASE IF NOT EXISTS `ecdb` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_swedish_ci;
USE `ecdb`;

-- --------------------------------------------------------

--
-- Table structure for table `category_head`
--
-- Creation: Dec 23, 2017 at 04:51 PM
-- Last update: Dec 23, 2017 at 04:51 PM
--

CREATE TABLE IF NOT EXISTS `category_head` (
  `id` smallint UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_head`
--

INSERT INTO `category_head` (`id`, `name`) VALUES(1, 'Cable');
INSERT INTO `category_head` (`id`, `name`) VALUES(2, 'Capacitor');
INSERT INTO `category_head` (`id`, `name`) VALUES(3, 'Connector');
INSERT INTO `category_head` (`id`, `name`) VALUES(4, 'Diode');
INSERT INTO `category_head` (`id`, `name`) VALUES(5, 'IC');
INSERT INTO `category_head` (`id`, `name`) VALUES(6, 'Inductor');
INSERT INTO `category_head` (`id`, `name`) VALUES(7, 'Mechanic');
INSERT INTO `category_head` (`id`, `name`) VALUES(8, 'Optical');
INSERT INTO `category_head` (`id`, `name`) VALUES(9, 'Vaccum tubes');
INSERT INTO `category_head` (`id`, `name`) VALUES(10, 'Switch');
INSERT INTO `category_head` (`id`, `name`) VALUES(11, 'Power');
INSERT INTO `category_head` (`id`, `name`) VALUES(13, 'Resistor');
INSERT INTO `category_head` (`id`, `name`) VALUES(12, 'Transistor');
INSERT INTO `category_head` (`id`, `name`) VALUES(14, 'Display');
INSERT INTO `category_head` (`id`, `name`) VALUES(15, 'Sensor');
INSERT INTO `category_head` (`id`, `name`) VALUES(16, 'Module');
INSERT INTO `category_head` (`id`, `name`) VALUES(17, 'Miscellaneous');
INSERT INTO `category_head` (`id`, `name`) VALUES(18, 'Oscillator');
-- --------------------------------------------------------

--
-- Table structure for table `category_sub`
--
-- Creation: Dec 23, 2017 at 04:51 PM
-- Last update: Dec 23, 2017 at 04:51 PM
--

CREATE TABLE IF NOT EXISTS `category_sub` (
  `id` smallint UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_sub`
--

INSERT INTO `category_sub` (`id`, `name`) VALUES(101, 'Ribbon');
INSERT INTO `category_sub` (`id`, `name`) VALUES(102, 'Coax');
INSERT INTO `category_sub` (`id`, `name`) VALUES(103, 'Standard');
INSERT INTO `category_sub` (`id`, `name`) VALUES(104, 'Mains');
INSERT INTO `category_sub` (`id`, `name`) VALUES(105, 'Signal/Data');
INSERT INTO `category_sub` (`id`, `name`) VALUES(106, 'Fiber optic');
INSERT INTO `category_sub` (`id`, `name`) VALUES(199, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(201, 'Ceramic');
INSERT INTO `category_sub` (`id`, `name`) VALUES(202, 'Electrolytic');
INSERT INTO `category_sub` (`id`, `name`) VALUES(203, 'Polyester');
INSERT INTO `category_sub` (`id`, `name`) VALUES(204, 'Tantalum');
INSERT INTO `category_sub` (`id`, `name`) VALUES(205, 'Variable');
INSERT INTO `category_sub` (`id`, `name`) VALUES(299, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(301, 'Audio');
INSERT INTO `category_sub` (`id`, `name`) VALUES(302, 'Coax');
INSERT INTO `category_sub` (`id`, `name`) VALUES(303, 'DC');
INSERT INTO `category_sub` (`id`, `name`) VALUES(304, 'D-Sub');
INSERT INTO `category_sub` (`id`, `name`) VALUES(305, 'HF');
INSERT INTO `category_sub` (`id`, `name`) VALUES(306, 'PCB');
INSERT INTO `category_sub` (`id`, `name`) VALUES(307, 'Mains');
INSERT INTO `category_sub` (`id`, `name`) VALUES(308, 'Data');
INSERT INTO `category_sub` (`id`, `name`) VALUES(399, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(401, 'Rectifier');
INSERT INTO `category_sub` (`id`, `name`) VALUES(402, 'Schottky');
INSERT INTO `category_sub` (`id`, `name`) VALUES(403, 'Small Signal');
INSERT INTO `category_sub` (`id`, `name`) VALUES(404, 'Zener');
INSERT INTO `category_sub` (`id`, `name`) VALUES(406, 'Bridge');
INSERT INTO `category_sub` (`id`, `name`) VALUES(407, 'Triac');
INSERT INTO `category_sub` (`id`, `name`) VALUES(408, 'Diac');
INSERT INTO `category_sub` (`id`, `name`) VALUES(409, 'Sidac');
INSERT INTO `category_sub` (`id`, `name`) VALUES(410, 'Photo');
INSERT INTO `category_sub` (`id`, `name`) VALUES(411, 'SCR');
INSERT INTO `category_sub` (`id`, `name`) VALUES(499, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(501, '4xxx');
INSERT INTO `category_sub` (`id`, `name`) VALUES(502, '74xx');
INSERT INTO `category_sub` (`id`, `name`) VALUES(503, '74HC4xxx');
INSERT INTO `category_sub` (`id`, `name`) VALUES(504, 'Comparator');
INSERT INTO `category_sub` (`id`, `name`) VALUES(505, 'Op. Amp.');
INSERT INTO `category_sub` (`id`, `name`) VALUES(506, 'Temperature');
INSERT INTO `category_sub` (`id`, `name`) VALUES(507, 'Timer & Osc.');
INSERT INTO `category_sub` (`id`, `name`) VALUES(508, 'Voltage Ref.');
INSERT INTO `category_sub` (`id`, `name`) VALUES(509, 'Voltage Reg.');
INSERT INTO `category_sub` (`id`, `name`) VALUES(510, 'A/D-D/A');
INSERT INTO `category_sub` (`id`, `name`) VALUES(511, 'Switching');
INSERT INTO `category_sub` (`id`, `name`) VALUES(512, 'Driver');
INSERT INTO `category_sub` (`id`, `name`) VALUES(513, 'DataComm');
INSERT INTO `category_sub` (`id`, `name`) VALUES(514, 'DC/DC Converter');
INSERT INTO `category_sub` (`id`, `name`) VALUES(515, 'Audio/Video');
INSERT INTO `category_sub` (`id`, `name`) VALUES(516, 'Memory');
INSERT INTO `category_sub` (`id`, `name`) VALUES(517, 'Logic');
INSERT INTO `category_sub` (`id`, `name`) VALUES(518, 'Microcontroller');
INSERT INTO `category_sub` (`id`, `name`) VALUES(519, 'Microprocessor');
INSERT INTO `category_sub` (`id`, `name`) VALUES(520, 'I2C');
INSERT INTO `category_sub` (`id`, `name`) VALUES(521, '1-wire');
INSERT INTO `category_sub` (`id`, `name`) VALUES(522, 'Isolator');
INSERT INTO `category_sub` (`id`, `name`) VALUES(523, 'Endode/Decode');
INSERT INTO `category_sub` (`id`, `name`) VALUES(524, 'Converter');
INSERT INTO `category_sub` (`id`, `name`) VALUES(525, 'EPROM');
INSERT INTO `category_sub` (`id`, `name`) VALUES(526, 'RAM');
INSERT INTO `category_sub` (`id`, `name`) VALUES(527, 'Counter/Timer');
INSERT INTO `category_sub` (`id`, `name`) VALUES(528, 'PIO');
INSERT INTO `category_sub` (`id`, `name`) VALUES(529, 'VIA');
INSERT INTO `category_sub` (`id`, `name`) VALUES(530, 'PTM');
INSERT INTO `category_sub` (`id`, `name`) VALUES(531, 'CTC');
INSERT INTO `category_sub` (`id`, `name`) VALUES(532, 'ACIA');
INSERT INTO `category_sub` (`id`, `name`) VALUES(533, 'PIA');
INSERT INTO `category_sub` (`id`, `name`) VALUES(534, 'Real Time Clock');
INSERT INTO `category_sub` (`id`, `name`) VALUES(599, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(601, 'Ferrite');
INSERT INTO `category_sub` (`id`, `name`) VALUES(602, 'Filter');
INSERT INTO `category_sub` (`id`, `name`) VALUES(603, 'Inductor');
INSERT INTO `category_sub` (`id`, `name`) VALUES(604, 'Transformer');
INSERT INTO `category_sub` (`id`, `name`) VALUES(699, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(701, 'Box');
INSERT INTO `category_sub` (`id`, `name`) VALUES(702, 'Distance');
INSERT INTO `category_sub` (`id`, `name`) VALUES(703, 'Fuse');
INSERT INTO `category_sub` (`id`, `name`) VALUES(704, 'Motor');
INSERT INTO `category_sub` (`id`, `name`) VALUES(705, 'Screw');
INSERT INTO `category_sub` (`id`, `name`) VALUES(708, 'IC Socket');
INSERT INTO `category_sub` (`id`, `name`) VALUES(709, 'Heat Sink');
INSERT INTO `category_sub` (`id`, `name`) VALUES(710, 'Knob');
INSERT INTO `category_sub` (`id`, `name`) VALUES(711, 'Meter');
INSERT INTO `category_sub` (`id`, `name`) VALUES(799, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(801, 'SSR[Relay]');
INSERT INTO `category_sub` (`id`, `name`) VALUES(802, 'Laser');
INSERT INTO `category_sub` (`id`, `name`) VALUES(803, 'LED');
INSERT INTO `category_sub` (`id`, `name`) VALUES(804, 'LED 3mm');
INSERT INTO `category_sub` (`id`, `name`) VALUES(805, 'LED 5mm');
INSERT INTO `category_sub` (`id`, `name`) VALUES(806, 'Optocoupler');
INSERT INTO `category_sub` (`id`, `name`) VALUES(807, 'IR LED');
INSERT INTO `category_sub` (`id`, `name`) VALUES(808, '7-segment LED');
INSERT INTO `category_sub` (`id`, `name`) VALUES(899, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(901, 'Octal');
INSERT INTO `category_sub` (`id`, `name`) VALUES(902, 'Loctal B8G');
INSERT INTO `category_sub` (`id`, `name`) VALUES(903, 'Heptal B7G');
INSERT INTO `category_sub` (`id`, `name`) VALUES(904, 'Noval B9A');
INSERT INTO `category_sub` (`id`, `name`) VALUES(905, 'Nixie');
INSERT INTO `category_sub` (`id`, `name`) VALUES(999, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1001, 'Keypad');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1002, 'Momentary');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1003, 'PCB Mounted');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1004, 'Rotary Encoder');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1005, 'Toggle Switch');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1006, 'Relay');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1007, 'DIP');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1099, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1101, 'Power Supply');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1102, 'Transformer');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1103, 'Wall Adapter');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1199, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1201, 'IGBT');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1202, 'MOSFET N');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1203, 'MOSFET P');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1204, 'NPN');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1205, 'PNP');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1206, 'UJT');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1207, 'PUT');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1208, 'JFET N');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1209, 'JFET P');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1210, 'SIPMOS');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1299, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1301, '0,25W Carbon 5%');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1302, '0,25W Metal 1%');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1303, '0,6W Metal 1%');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1304, '1W Carbon 5%');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1305, '0,1W SMD 0603');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1306, '0,125W SMD 0805');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1307, '0,25W SMD 1206');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1308, 'Effect');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1309, 'Photo');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1310, 'Network');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1311, 'Temperature');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1312, 'Potentiometer');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1313, 'Trimpots');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1314, 'Trimpots multiturn');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1315, 'Precision');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1399, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1401, 'LCD');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1402, 'VFD');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1403, 'TFT');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1404, 'LED');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1405, 'Nixie tubes');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1499, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1501, 'Moisture');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1502, 'Temperature');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1503, 'Pressure');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1504, 'Magnetic');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1505, 'Hall Effect');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1506, 'Gas');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1507, 'Accelerometer');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1508, 'Light');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1509, 'Proximity');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1599, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1601, 'GSM');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1602, 'GPS');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1603, 'Bluetooth');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1604, 'WiFi');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1605, 'ZigBee');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1606, 'RFID');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1607, 'Arduino');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1608, 'MSP430');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1609, 'chipKIT');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1610, 'Raspberry Pi');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1611, 'BeagleBone');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1699, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1799, 'Misc');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1801, 'Crystal');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1802, 'Resonator');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1803, 'TCXO');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1804, 'Clock Module');
INSERT INTO `category_sub` (`id`, `name`) VALUES(1899, 'Misc');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--
-- Creation: Dec 23, 2017 at 04:51 PM
-- Last update: May 15, 2018 at 12:41 AM
-- Last check: Dec 23, 2017 at 04:51 PM
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` smallint UNSIGNED NOT NULL,
  `owner` smallint UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `manufacturer` varchar(64) NOT NULL,
  `package` varchar(64) NOT NULL,
  `pins` smallint UNSIGNED NOT NULL,
  `quantity` smallint UNSIGNED NOT NULL DEFAULT '0',
  `order_quantity` smallint UNSIGNED NOT NULL DEFAULT '0',
  `location` varchar(32) NOT NULL,
  `scrap` varchar(3) NOT NULL DEFAULT 'No',
  `datasheet` varchar(256) NOT NULL,
  `comment` tinytext NOT NULL,
  `category` smallint UNSIGNED NOT NULL,
  `cimage` varchar(256) NOT NULL,
  `appnote` varchar(256) NOT NULL,
  `price` varchar(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=702 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `members`
--
-- Creation: Dec 23, 2017 at 04:51 PM
-- Last update: Dec 23, 2017 at 04:51 PM
--

CREATE TABLE IF NOT EXISTS `members` (
  `member_id` smallint UNSIGNED NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `login` varchar(32) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `language` varchar(10) NOT NULL DEFAULT 'sv_SE.utf8'
) ENGINE=MyISAM AUTO_INCREMENT=1801 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `firstname`, `lastname`, `login`, `passwd`, `currency`, `language`) VALUES(4, 'Demo', 'Demo', 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'USD', 'en_US.utf8');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--
-- Creation: Dec 23, 2017 at 04:51 PM
-- Last update: Dec 23, 2017 at 04:51 PM
--

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` smallint UNSIGNED NOT NULL,
  `project_owner` smallint UNSIGNED NOT NULL,
  `project_name` varchar(64) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_owner`, `project_name`) VALUES(1, 4, 'Robot');

-- --------------------------------------------------------

--
-- Table structure for table `projects_data`
--
-- Creation: Dec 23, 2017 at 04:51 PM
-- Last update: Dec 23, 2017 at 04:51 PM
--

CREATE TABLE IF NOT EXISTS `projects_data` (
  `projects_data_id` smallint UNSIGNED NOT NULL,
  `projects_data_owner_id` smallint UNSIGNED NOT NULL,
  `projects_data_project_id` smallint UNSIGNED NOT NULL,
  `projects_data_component_id` smallint UNSIGNED NOT NULL,
  `projects_data_quantity` smallint UNSIGNED NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects_data`
--

INSERT INTO `projects_data` (`projects_data_id`, `projects_data_owner_id`, `projects_data_project_id`, `projects_data_component_id`, `projects_data_quantity`) VALUES(2, 4, 1, 1, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_head`
--
ALTER TABLE `category_head`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `category_sub`
--
ALTER TABLE `category_sub`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_2` (`id`), ADD UNIQUE KEY `id_3` (`id`), ADD KEY `Id` (`id`), ADD KEY `owner` (`owner`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
 ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
 ADD PRIMARY KEY (`project_id`), ADD KEY `project_owner` (`project_owner`);

--
-- Indexes for table `projects_data`
--
ALTER TABLE `projects_data`
 ADD PRIMARY KEY (`projects_data_id`), ADD KEY `owner_id` (`projects_data_owner_id`), ADD KEY `project_id` (`projects_data_project_id`), ADD KEY `component_id` (`projects_data_component_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=702;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
MODIFY `member_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1801;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
MODIFY `project_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `projects_data`
--
ALTER TABLE `projects_data`
MODIFY `projects_data_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

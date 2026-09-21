-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ecdb
-- ------------------------------------------------------
-- Server version       11.8.6-MariaDB-0+deb13u1 from Debian

--
-- Table structure for table `category_head`
--

CREATE TABLE `category_head` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `category_head`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `category_head` WRITE;
INSERT INTO `category_head` VALUES
(1,'Cable'),
(2,'Capacitor'),
(3,'Connector'),
(4,'Diode'),
(5,'IC'),
(6,'Inductor'),
(7,'Mechanic'),
(8,'Optical'),
(9,'Vaccum tubes'),
(10,'Switch'),
(11,'Power'),
(13,'Resistor'),
(12,'Transistor'),
(14,'Display'),
(15,'Sensor'),
(16,'SBC'),
(17,'Miscellaneous'),
(18,'Oscillator'),
(19,'Instruments');
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `category_sub`
--

CREATE TABLE `category_sub` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `category_sub`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `category_sub` WRITE;
INSERT INTO `category_sub` VALUES
(101,'Ribbon'),
(102,'Coax'),
(103,'Standard'),
(104,'Mains'),
(105,'Signal/Data'),
(106,'Fiber optic'),
(199,'Misc'),
(201,'Ceramic'),
(202,'Electrolytic'),
(203,'Polyester'),
(204,'Tantalum'),
(205,'Variable'),
(299,'Misc'),
(301,'Audio'),
(302,'Coax'),
(303,'DC'),
(304,'D-Sub'),
(305,'HF'),
(306,'PCB'),
(307,'Mains'),
(308,'Data'),
(399,'Misc'),
(401,'Rectifier'),
(402,'Schottky'),
(403,'Small Signal'),
(404,'Zener'),
(406,'Bridge'),
(407,'Triac'),
(408,'Diac'),
(409,'Sidac'),
(410,'Photo'),
(411,'SCR'),
(499,'Misc'),
(501,'4xxx'),
(502,'74xx'),
(503,'74HC4xxx'),
(504,'Comparator'),
(505,'Op. Amp.'),
(506,'Temperature'),
(507,'Timer & Osc.'),
(508,'Voltage Ref.'),
(509,'Voltage Reg.'),
(510,'A/D-D/A'),
(511,'Switching'),
(512,'Driver'),
(513,'DataComm'),
(514,'DC/DC Converter'),
(515,'Audio/Video'),
(516,'Memory'),
(517,'Logic'),
(518,'Microcontroller'),
(519,'Microprocessor'),
(520,'I2C'),
(521,'1-wire'),
(522,'Isolator'),
(523,'Endode/Decode'),
(524,'Converter'),
(525,'EPROM'),
(526,'RAM'),
(527,'Counter/Timer'),
(528,'PIO'),
(529,'VIA'),
(530,'PTM'),
(531,'CTC'),
(532,'ACIA'),
(533,'PIA'),
(534,'Real Time Clock'),
(599,'Misc'),
(601,'Ferrite'),
(602,'Filter'),
(603,'Inductor'),
(604,'Transformer'),
(699,'Misc'),
(701,'Box'),
(702,'Distance'),
(703,'Fuse'),
(704,'Motor'),
(705,'Screw'),
(708,'IC Socket'),
(709,'Heat Sink'),
(710,'Knob'),
(711,'Meter'),
(799,'Misc'),
(801,'SSR[Relay]'),
(802,'Laser'),
(803,'LED'),
(804,'LED 3mm'),
(805,'LED 5mm'),
(806,'Optocoupler'),
(807,'IR LED'),
(808,'7-segment LED'),
(899,'Misc'),
(901,'Octal'),
(902,'Loctal B8G'),
(903,'Heptal B7G'),
(904,'Noval B9A'),
(905,'Nixie'),
(999,'Misc'),
(1001,'Keypad'),
(1002,'Momentary'),
(1003,'PCB Mounted'),
(1004,'Rotary Encoder'),
(1005,'Toggle Switch'),
(1006,'Relay'),
(1007,'DIP'),
(1099,'Misc'),
(1101,'Power Supply'),
(1102,'Transformer'),
(1103,'Wall Adapter'),
(1199,'Misc'),
(1201,'IGBT'),
(1202,'MOSFET N'),
(1203,'MOSFET P'),
(1204,'NPN'),
(1205,'PNP'),
(1206,'UJT'),
(1207,'PUT'),
(1208,'JFET N'),
(1209,'JFET P'),
(1210,'SIPMOS'),
(1299,'Misc'),
(1301,'0,25W Carbon 5%'),
(1302,'0,25W Metal 1%'),
(1303,'0,6W Metal 1%'),
(1304,'1W Carbon 5%'),
(1305,'0,1W SMD 0603'),
(1306,'0,125W SMD 0805'),
(1307,'0,25W SMD 1206'),
(1308,'Effect'),
(1309,'Photo'),
(1310,'Network'),
(1311,'Temperature'),
(1312,'Potentiometer'),
(1313,'Trimpots'),
(1314,'Trimpots multiturn'),
(1315,'Precision'),
(1399,'Misc'),
(1401,'LCD'),
(1402,'VFD'),
(1403,'TFT'),
(1404,'LED'),
(1405,'Nixie tubes'),
(1499,'Misc'),
(1501,'Moisture'),
(1502,'Temperature'),
(1503,'Pressure'),
(1504,'Magnetic'),
(1505,'Hall Effect'),
(1506,'Gas'),
(1507,'Accelerometer'),
(1508,'Light'),
(1509,'Proximity'),
(1599,'Misc'),
(1601,'GSM'),
(1602,'GPS'),
(1603,'Bluetooth'),
(1604,'WiFi'),
(1605,'ZigBee'),
(1606,'RFID'),
(1607,'Arduino'),
(1608,'MSP430'),
(1609,'chipKIT'),
(1610,'Raspberry Pi'),
(1611,'BeagleBone'),
(1699,'Misc'),
(1799,'Misc'),
(1801,'Crystal'),
(1802,'Resonator'),
(1803,'TCXO'),
(1804,'Clock Module'),
(1899,'Misc'),
(1901,'VU meter'),
(1902,'Volt meter'),
(1903,'Ampere meter'),
(1904,'Frequency meter');
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `owner` smallint(5) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `manufacturer` varchar(64) NOT NULL,
  `package` varchar(64) NOT NULL,
  `pins` smallint(5) unsigned NOT NULL,
  `quantity` smallint(5) unsigned NOT NULL,
  `order_quantity` smallint(5) unsigned NOT NULL,
  `location` varchar(32) NOT NULL,
  `scrap` varchar(3) NOT NULL DEFAULT 'No',
  `datasheet` varchar(256) NOT NULL,
  `comment` tinytext NOT NULL,
  `category` smallint(5) unsigned NOT NULL,
  `cimage` varchar(256) NOT NULL,
  `appnote` varchar(256) NOT NULL,
  `price` varchar(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `Id` (`id`),
  KEY `owner` (`owner`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `login` varchar(32) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `language` varchar(10) NOT NULL DEFAULT 'en_US.utf8',
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `members`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `members` WRITE;
INSERT INTO `members` VALUES
(4,'Demo','Demo','demo','fe01ce2a7fbac8fafaed7c982a04e229','USD','en_US.utf8');
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `project_owner` smallint(5) unsigned NOT NULL,
  `project_name` varchar(64) NOT NULL,
  PRIMARY KEY (`project_id`),
  KEY `project_owner` (`project_owner`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Table structure for table `projects_data`
--

CREATE TABLE `projects_data` (
  `projects_data_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `projects_data_owner_id` smallint(5) unsigned DEFAULT NULL,
  `projects_data_project_id` smallint(5) unsigned DEFAULT NULL,
  `projects_data_component_id` smallint(5) unsigned DEFAULT NULL,
  `projects_data_quantity` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`projects_data_id`),
  KEY `owner_id` (`projects_data_owner_id`),
  KEY `project_id` (`projects_data_project_id`),
  KEY `component_id` (`projects_data_component_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


-- Dump completed on 2026-09-21 10:37:15

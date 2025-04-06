/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.1-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: pc_part_store
-- ------------------------------------------------------
-- Server version	11.8.1-MariaDB-2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','shipped','delivered') DEFAULT 'pending',
  `payment_data` text DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `orders` VALUES
(1,2,1,1,1599.99,'pending','CC: 4111111111111111, EXP: 12/25, CVV: 123','2025-04-05 13:43:04'),
(2,4,2,1,699.99,'shipped','CC: 5432101234567890, EXP: 09/26, CVV: 999','2025-04-05 13:45:44'),
(3,5,1,2,3199.98,'pending','CC: 4000000000000000, EXP: 06/26, CVV: 444','2025-04-05 13:45:44'),
(4,6,3,1,249.99,'delivered','CC: 4111222233334444, EXP: 01/25, CVV: 777','2025-04-05 13:45:44'),
(5,4,7,1,159.99,'pending','CC: 5555666677778888, EXP: 11/25, CVV: 222','2025-04-05 13:45:44'),
(6,2,8,1,399.99,'shipped','CC: 4111333344445555, EXP: 10/26, CVV: 111','2025-04-05 22:52:31'),
(7,3,10,2,259.98,'pending','CC: 4012888888881881, EXP: 05/25, CVV: 321','2025-04-05 22:52:31'),
(8,4,12,1,129.99,'pending','CC: 6011000990139424, EXP: 03/26, CVV: 963','2025-04-05 22:52:31'),
(9,6,9,1,179.99,'delivered','CC: 3530111333300000, EXP: 07/25, CVV: 555','2025-04-05 22:52:31');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` enum('CPU','GPU','RAM','Storage','Motherboard','PSU','Case') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `products` VALUES
(1,'NVIDIA RTX 4090','GPU',1599.99,'The fastest GPU for gaming!',10,'assets/img/products/placeholder.jpg'),
(2,'Ryzen 9 7950X','CPU',699.99,'16-core gaming monster.',20,'assets/img/products/placeholder.jpg'),
(3,'Samsung 980 Pro 2TB','Storage',249.99,'Blazing-fast NVMe SSD',40,'assets/img/products/placeholder.jpg'),
(4,'Intel i9-13900K','CPU',649.99,'A top-tier 13th-gen Intel CPU.',15,'assets/img/products/placeholder.jpg'),
(5,'Crucial Ballistix 16GB DDR5','RAM',109.99,'Reliable DDR5 memory kit.',30,'assets/img/products/placeholder.jpg'),
(6,'Corsair RM1000e Power Supply','PSU',159.99,'1000W Gold PSU for stable builds.',20,'assets/img/products/placeholder.jpg'),
(7,'MSI MAG B650 TOMAHAWK','Motherboard',249.99,'AM5 board for Ryzen 7000.',12,'assets/img/products/placeholder.jpg'),
(13,'ASUS ROG STRIX Z790-E','Motherboard',399.99,'High-end Z790 motherboard with Wi-Fi 6E.',15,'assets/img/products/placeholder.jpg'),
(14,'Cooler Master HAF 700 EVO','Case',299.99,'Massive full-tower case with RGB glass panel.',20,'assets/img/products/placeholder.jpg'),
(15,'G.Skill Trident Z5 32GB','RAM',179.99,'RGB DDR5 kit at 6000MHz.',25,'assets/img/products/placeholder.jpg'),
(16,'WD Black SN850X 1TB','Storage',129.99,'PCIe Gen4 SSD with blazing speeds.',50,'assets/img/products/placeholder.jpg'),
(17,'EVGA RTX 3080 FTW3','GPU',799.99,'Still a beast for high-end gaming.',10,'assets/img/products/placeholder.jpg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `reset_tokens`
--

DROP TABLE IF EXISTS `reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reset_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_tokens`
--

LOCK TABLES `reset_tokens` WRITE;
/*!40000 ALTER TABLE `reset_tokens` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `reset_tokens` VALUES
(1,1,'13032188833baa81fad1ca33808a3ee0','2025-04-06 03:49:40'),
(2,2,'c50bf4868eb3cb3db582ae9ad08aded6','2025-04-06 03:49:40'),
(3,3,'28c3313f2b851fb31e8c4c042c7457f6','2025-04-06 03:49:40'),
(4,4,'c693952b59807e7ce5a733f4a42f8657','2025-04-06 03:49:40'),
(5,5,'ef3e73a672a9104681567eb6d1c398bd','2025-04-06 03:49:40'),
(6,6,'06286c8dcb54757b784b79fa9ce20641','2025-04-06 03:49:40'),
(7,7,'9404109b92bb501fd08189798bda25a7','2025-04-06 03:49:40'),
(8,8,'8e8d7253e8bd6e2e2f82d31eefd017d0','2025-04-06 03:49:40'),
(9,9,'203149665f6ab06f3014e75cfe6b4625','2025-04-06 03:49:40'),
(10,10,'d3c86c5e9aef263a4476551e2e6edb44','2025-04-06 03:49:40'),
(11,11,'ac39fccda5d75bfe1e7b8104dd55cdfe','2025-04-06 03:49:40');
/*!40000 ALTER TABLE `reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `reviews` VALUES
(1,1,2,5,'Incredible performance!','2025-04-05 13:42:18'),
(2,2,3,4,'Great CPU but runs a bit hot.','2025-04-05 13:42:18'),
(3,1,4,5,'Best GPU ever for 4K gaming. Blazing-fast!','2025-04-05 13:45:37'),
(4,4,5,4,'Solid PSU, but a bit noisy under heavy load.','2025-04-05 13:45:37'),
(5,2,6,5,'Handles all my encoding tasks like a champ.','2025-04-05 13:45:37'),
(6,5,4,3,'Good motherboard, wish it had more fan headers.','2025-04-05 13:45:37'),
(7,3,5,5,'Excellent SSD, super quick for large game installs.','2025-04-05 13:45:37'),
(9,5,6,4,'Solid RAM, nice RGB, works flawlessly.','2025-04-05 22:52:38'),
(10,10,4,5,'Great value for 2TB NVMe storage!','2025-04-05 22:52:38'),
(11,2,2,1,'Product arrived dead. Do not buy!','2025-04-05 22:52:38'),
(12,8,5,3,'Nice board but BIOS is buggy.','2025-04-05 22:52:38'),
(13,1,2,5,'Insane performance on max settings!','2025-04-06 00:11:38'),
(14,1,3,4,'Quiet and fast. Love it.','2025-04-06 00:11:38'),
(15,2,4,4,'Boost clocks are great but it gets hot.','2025-04-06 00:11:38'),
(16,2,5,5,'Perfect for dev workloads.','2025-04-06 00:11:38'),
(17,3,6,5,'No issues installing. Super fast load times.','2025-04-06 00:11:38'),
(18,3,2,5,'SSD benchmarked at insane speeds.','2025-04-06 00:11:38'),
(19,4,3,4,'No complaints so far. Solid PSU.','2025-04-06 00:11:38'),
(20,5,4,3,'Mobo works but BIOS has quirks.','2025-04-06 00:11:38'),
(21,6,5,5,'My RAM is glowing like a rave.','2025-04-06 00:11:38'),
(22,6,6,5,'<img src=x onerror=alert(\"RAM XSS\")> RGB!','2025-04-06 00:11:38'),
(23,7,2,5,'CPU cooler support was great.','2025-04-06 00:11:38'),
(24,7,3,4,'Could use more fan headers.','2025-04-06 00:11:38'),
(25,8,4,3,'Affordable, gets the job done.','2025-04-06 00:11:38'),
(26,9,5,5,'PCIe Gen4 for the win.','2025-04-06 00:11:38'),
(27,9,6,5,'Fast delivery. Excellent packaging.','2025-04-06 00:11:38'),
(28,10,2,4,'2TB for this price? Take my money!','2025-04-06 00:11:38'),
(29,10,3,5,'<svg/onload=alert(\"SSD XSS\")> great NVMe!','2025-04-06 00:11:38');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `users` VALUES
(1,'admin','admin123','admin@pcparts.test','admin','2025-04-05 13:41:51'),
(2,'john_doe','password1','john@example.com','user','2025-04-05 13:41:51'),
(3,'test_user','qwerty','test@mail.com','user','2025-04-05 13:41:51'),
(4,'jane_doe','pass123','jane@example.com','user','2025-04-05 13:45:23'),
(5,'gamerz','abc123','gamerz@example.com','user','2025-04-05 13:45:23'),
(6,'hwtester','testtest','tester@hw.com','user','2025-04-05 13:45:23'),
(7,'exploit_dev','exploitme','dev@exploit.com','admin','2025-04-05 22:50:19'),
(8,'rootkitz','root123','root@rootkit.net','user','2025-04-05 22:50:19'),
(9,'xssqueen','s3cure!','xss@inject.me','user','2025-04-05 22:50:19'),
(10,'sqlinjector','dropdb','sqli@hack.net','user','2025-04-05 22:50:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-04-06  0:34:32

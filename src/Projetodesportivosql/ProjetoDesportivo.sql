-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: clube_reservas
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `campos`
--

DROP TABLE IF EXISTS `campos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `campos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(20) NOT NULL,
  `tipo_campo_id` int(11) NOT NULL,
  `estado` enum('disponivel','manutencao') DEFAULT 'disponivel',
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_campo_id` (`tipo_campo_id`),
  CONSTRAINT `campos_ibfk_1` FOREIGN KEY (`tipo_campo_id`) REFERENCES `tipos_campo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campos`
--

LOCK TABLES `campos` WRITE;
/*!40000 ALTER TABLE `campos` DISABLE KEYS */;
INSERT INTO `campos` VALUES (1,'P1',1,'disponivel','Campo P1 de pádel coberto.'),(2,'P2',1,'disponivel','Campo P2 de pádel coberto.'),(3,'P3',2,'disponivel','Campo P3 de pádel descoberto.'),(4,'T1',3,'disponivel','Campo T1 de ténis terra batida.'),(5,'T2',4,'disponivel','Campo T2 de ténis rápido coberto.');
/*!40000 ALTER TABLE `campos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilizador_id` int(11) DEFAULT NULL,
  `acao` varchar(255) NOT NULL,
  `data_acao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `utilizador_id` (`utilizador_id`),
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,1,'Registou pagamento da reserva 3','2026-06-16 19:48:30'),(2,1,'Confirmou check-in da reserva 3','2026-06-16 19:48:41'),(3,1,'Confirmou check-in da reserva 5','2026-06-17 02:13:09'),(4,1,'Registou pagamento da reserva 5','2026-06-17 02:13:31'),(5,1,'Registou pagamento da reserva 5','2026-06-17 02:13:35'),(6,1,'Registou pagamento da reserva 5','2026-06-17 02:23:12'),(7,1,'Registou pagamento da reserva 5','2026-06-17 02:29:19'),(8,1,'Registou pagamento da reserva 5','2026-06-17 02:31:12'),(9,1,'Registou pagamento da reserva 3','2026-06-17 02:31:28'),(10,1,'Registou pagamento da reserva 5','2026-06-17 02:37:40'),(11,1,'Registou pagamento da reserva 3','2026-06-17 02:39:37'),(12,1,'Confirmou check-in da reserva 7','2026-06-17 03:42:23'),(13,1,'Confirmou check-in da reserva 8','2026-06-17 03:44:47'),(14,1,'Confirmou check-in da reserva 9','2026-06-17 03:51:59'),(15,1,'Confirmou check-in da reserva 7','2026-06-17 03:54:44'),(16,2,'Confirmou check-in da reserva 10','2026-06-17 21:25:19'),(17,2,'Registou pagamento da reserva 10','2026-06-17 21:25:32'),(18,2,'Registou pagamento da reserva 10','2026-06-17 21:25:43'),(19,1,'Confirmou check-in da reserva 12','2026-06-17 22:05:50'),(20,1,'Registou pagamento da reserva 12','2026-06-17 22:06:16'),(21,2,'Confirmou check-in da reserva 11','2026-06-17 22:08:43'),(22,1,'Confirmou check-in da reserva 13','2026-06-17 22:17:34'),(23,1,'Registou pagamento da reserva 13','2026-06-17 22:17:47'),(24,2,'Confirmou check-in da reserva 16','2026-06-17 22:29:26'),(25,2,'Registou pagamento da reserva 16','2026-06-17 22:29:39');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reserva_id` int(11) NOT NULL,
  `operador_id` int(11) NOT NULL,
  `montante` decimal(8,2) NOT NULL,
  `tipo` enum('parcial','total') NOT NULL,
  `data_pagamento` timestamp NOT NULL DEFAULT current_timestamp(),
  `observacao` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reserva_id` (`reserva_id`),
  KEY `operador_id` (`operador_id`),
  CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`),
  CONSTRAINT `pagamentos_ibfk_2` FOREIGN KEY (`operador_id`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagamentos`
--

LOCK TABLES `pagamentos` WRITE;
/*!40000 ALTER TABLE `pagamentos` DISABLE KEYS */;
INSERT INTO `pagamentos` VALUES (1,3,1,48.00,'total','2026-06-16 19:48:30','Pagamento registado no backoffice'),(2,5,1,20.00,'parcial','2026-06-17 02:13:31','Pagamento registado no backoffice'),(3,5,1,20.00,'parcial','2026-06-17 02:13:35','Pagamento registado no backoffice'),(4,5,1,20.00,'parcial','2026-06-17 02:23:12','Pagamento registado no backoffice'),(5,5,1,20.00,'parcial','2026-06-17 02:29:19','Pagamento registado no backoffice'),(6,5,1,20.00,'parcial','2026-06-17 02:31:12','Pagamento registado no backoffice'),(7,3,1,48.00,'total','2026-06-17 02:31:28','Pagamento registado no backoffice'),(8,5,1,20.00,'total','2026-06-17 02:37:40','Pagamento registado no backoffice'),(9,3,1,48.00,'parcial','2026-06-17 02:39:37','Pagamento registado no backoffice'),(10,10,2,18.00,'total','2026-06-17 21:25:32','Pagamento registado no backoffice'),(11,10,2,1.00,'parcial','2026-06-17 21:25:43','Pagamento registado no backoffice'),(12,12,1,10.00,'total','2026-06-17 22:06:16','Pagamento registado no backoffice'),(13,13,1,10.00,'parcial','2026-06-17 22:17:47','Pagamento registado no backoffice'),(14,16,2,23.00,'total','2026-06-17 22:29:39','Pagamento registado no backoffice');
/*!40000 ALTER TABLE `pagamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilizador_id` int(11) NOT NULL,
  `campo_id` int(11) NOT NULL,
  `data_jogo` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `luz` tinyint(1) DEFAULT 0,
  `material_qtd` int(11) DEFAULT 0,
  `nif_faturacao` varchar(20) DEFAULT NULL,
  `valor_total` decimal(8,2) DEFAULT 0.00,
  `estado` enum('ativa','cancelada') DEFAULT 'ativa',
  `checkin` tinyint(1) DEFAULT 0,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `utilizador_id` (`utilizador_id`),
  KEY `campo_id` (`campo_id`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`),
  CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`campo_id`) REFERENCES `campos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservas`
--

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
INSERT INTO `reservas` VALUES (1,4,1,'2026-06-18','13:20:00','21:00:00',0,2,'234567',26.00,'cancelada',0,'2026-06-16 17:20:51'),(2,4,2,'2026-06-18','13:20:00','21:00:00',0,2,'234567',26.00,'cancelada',0,'2026-06-16 17:32:30'),(3,1,5,'2026-06-18','21:00:00','22:00:00',1,5,'123123',48.00,'ativa',1,'2026-06-16 19:42:57'),(4,8,4,'2026-07-25','18:00:00','20:00:00',1,0,'',24.00,'cancelada',0,'2026-06-17 00:54:56'),(5,8,3,'2026-06-30','16:00:00','17:00:00',1,0,'',20.00,'ativa',1,'2026-06-17 00:58:53'),(6,8,3,'2026-06-30','17:00:00','18:00:00',0,0,'',15.00,'cancelada',0,'2026-06-17 00:59:23'),(7,1,1,'2026-07-20','19:00:00','20:00:00',0,0,'',20.00,'ativa',1,'2026-06-17 02:26:27'),(8,1,4,'2026-06-18','13:00:00','14:00:00',0,2,'',26.00,'ativa',1,'2026-06-17 03:43:34'),(9,1,3,'2026-06-27','09:00:00','11:00:00',0,0,'',15.00,'ativa',1,'2026-06-17 03:51:21'),(10,8,1,'2026-08-06','20:00:00','21:00:00',0,0,'',18.00,'ativa',1,'2026-06-17 19:29:30'),(11,7,4,'2026-06-26','02:41:00','03:42:00',0,0,'',10.00,'ativa',1,'2026-06-17 21:36:27'),(12,9,5,'2026-06-19','11:00:00','12:00:00',0,0,'',10.00,'ativa',1,'2026-06-17 22:04:12'),(13,10,4,'2026-06-27','14:00:00','15:00:00',0,0,'',10.00,'ativa',1,'2026-06-17 22:15:45'),(14,4,1,'2026-06-24','17:00:00','18:00:00',0,0,'',15.00,'ativa',0,'2026-06-17 22:22:09'),(15,11,4,'2026-06-24','14:00:00','16:00:00',0,0,'',10.00,'ativa',0,'2026-06-17 22:27:40'),(16,11,1,'2026-06-28','18:00:00','19:00:00',1,1,'',23.00,'ativa',1,'2026-06-17 22:28:21'),(17,11,4,'2026-06-30','16:13:00','19:37:00',0,0,'',15.00,'ativa',0,'2026-06-17 22:32:55'),(18,11,5,'2026-06-22','14:36:00','15:37:00',0,0,'',20.00,'ativa',0,'2026-06-17 22:34:09');
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_campo`
--

DROP TABLE IF EXISTS `tipos_campo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_campo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `modalidade` varchar(50) NOT NULL,
  `piso` varchar(100) DEFAULT NULL,
  `cobertura` enum('coberto','descoberto') NOT NULL,
  `preco_base` decimal(8,2) NOT NULL,
  `preco_luz` decimal(8,2) DEFAULT 0.00,
  `preco_material` decimal(8,2) DEFAULT 0.00,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_campo`
--

LOCK TABLES `tipos_campo` WRITE;
/*!40000 ALTER TABLE `tipos_campo` DISABLE KEYS */;
INSERT INTO `tipos_campo` VALUES (1,'Padel Coberto','Pádel','Relva sintética','coberto',15.00,5.00,3.00,'Campo de pádel coberto com iluminação.'),(2,'Padel Descoberto','Pádel','Relva sintética','descoberto',15.00,5.00,3.00,'Campo de pádel descoberto.'),(3,'Ténis Terra Batida','Ténis','Terra batida','descoberto',15.00,6.00,4.00,'Campo de ténis em terra batida.'),(4,'Ténis Rápido','Ténis','Piso rápido','coberto',20.00,6.00,4.00,'Campo de ténis rápido coberto.');
/*!40000 ALTER TABLE `tipos_campo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilizadores`
--

DROP TABLE IF EXISTS `utilizadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilizadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `documento_tipo` varchar(50) DEFAULT NULL,
  `documento_numero` varchar(50) DEFAULT NULL,
  `nif` varchar(20) DEFAULT NULL,
  `perfil` enum('atleta','rececionista','gestor') DEFAULT 'atleta',
  `estado` enum('ativo','inativo') DEFAULT 'ativo',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilizadores`
--

LOCK TABLES `utilizadores` WRITE;
/*!40000 ALTER TABLE `utilizadores` DISABLE KEYS */;
INSERT INTO `utilizadores` VALUES (1,'Gestor Admin','gestor@clube.pt','$2y$10$AQFLHUbbNMNiCfS2auI0oeBejZYEmCG7v2frYGva4Cin./m4A1RWW','Cartão de Cidadão','00000000','000000000','gestor','ativo','2026-06-16 12:09:00'),(2,'Rececionista Clube','rececao@clube.pt','$2y$10$bKDtlDUefJVVJK362Tl/3.VgP68o2Cwq3tnxvnFLoOZufN2xE6J8y','Cartão de Cidadão','11111111','111111111','rececionista','ativo','2026-06-16 12:09:00'),(3,'Pedro Dias','pedro@email.com','123456','Cartão de Cidadão','22222222','222222222','atleta','inativo','2026-06-16 12:09:00'),(4,'pedro','joao@gmail.com','$2y$10$SUo.X/4waWJK7DuTYR448uSuj2UOzfAjGuFmVGWdGiLHgVbxi6y2y','cat?o','23432','1234543','atleta','ativo','2026-06-16 15:39:16'),(7,'tomas','tomas@gmail.com','$2y$10$1IJOqx/CB3fRevuXJvhqH.kpZoLhMhf1cmflMj4i1cIiI2hHpkirC','Cartão de Cidadão','24543','','atleta','inativo','2026-06-16 23:41:11'),(8,'dinis','dinis@gmail.com','$2y$10$YDZnD4r0a0IOKNEjTz/X/eDqqjoDNNaW1s5U0UE6yxqborvmMhYJ.','Passaporte','321','','atleta','inativo','2026-06-16 23:43:45'),(9,'iade','iade@gmail.com','$2y$10$HoGRNDPTfDy0fRXZyfvoCu.aT5slpExKKL.8DwCPQIfoUH9/5K8xO','Cartão de Cidadão','432','','atleta','inativo','2026-06-17 22:02:57'),(10,'jose','jose@gmail.com','$2y$10$ZMjtkKH4Xlcw3etIG7LOKuuKnTQuW2tplPlqj8PSLrAGlIYqAzN2.','Cartão de Cidadão','321','','atleta','ativo','2026-06-17 22:14:27'),(11,'ricardo','ricardo@gmail.com','$2y$10$hx7p0ObXtTCguPfNmCABd.L95mJXrTEJ/QkwxysHHBrV/1FhGrlNa','Cartão de Cidadão','43234','','atleta','ativo','2026-06-17 22:26:32');
/*!40000 ALTER TABLE `utilizadores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-17 23:47:52

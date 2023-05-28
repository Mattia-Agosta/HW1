-- MariaDB dump 10.19  Distrib 10.4.25-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: hw1
-- ------------------------------------------------------
-- Server version	10.4.25-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `likedgames`
--

DROP TABLE IF EXISTS `likedgames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likedgames` (
  `game_id` int(11) NOT NULL,
  `n_likes` int(11) DEFAULT 0,
  `titolo` varchar(60) DEFAULT NULL,
  `img` varchar(120) DEFAULT NULL,
  `genere` varchar(60) DEFAULT NULL,
  `data` varchar(15) DEFAULT NULL,
  `piattaforme` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likedgames`
--

LOCK TABLES `likedgames` WRITE;
/*!40000 ALTER TABLE `likedgames` DISABLE KEYS */;
INSERT INTO `likedgames` VALUES (3439,1,'Life is Strange','https://media.rawg.io/media/games/562/562553814dd54e001a541e4ee83a591c.jpg','Adventure','2015-01-29','PC, Xbox One, PlayStation 4, iOS, Android'),(13513,2,'STEINS;GATE','https://media.rawg.io/media/games/c60/c60be8ddf91ede65c65b13eff2e06c37.jpg','Adventure, RPG','2009-08-25','PC, PlayStation 4, Nintendo Switch, iOS, PlayStation 3'),(16700,1,'The Night of the Rabbit','https://media.rawg.io/media/screenshots/a16/a165c67bb75b40b5f8a310c55e9d34de.jpg','Indie, Adventure','2013-05-28','PC, macOS'),(23027,1,'The Walking Dead: Season 1','https://media.rawg.io/media/games/8d6/8d69eb6c32ed6acfd75f82d532144993.jpg','Adventure, Action','2012-04-23','PC, Xbox One, PlayStation 4, Nintendo Switch, iOS'),(23165,1,'Mario Kart 8 Deluxe','https://media.rawg.io/media/games/6f8/6f846e941c78cfbabe53cd67e55ced83.jpg','Racing','2017-04-27','Nintendo Switch'),(24030,1,'Super Mario Bros. 3','https://media.rawg.io/media/screenshots/092/092fc1910f067a95a07c0fbfdbe25f03.jpg','Platformer, Adventure, Action','1988-10-23','Nintendo Switch, Nintendo 3DS, Wii U, Wii, Game Boy Color'),(24899,1,'Super Mario World','https://media.rawg.io/media/games/3bb/3bb2c8d774c3a83eb2c17d0d3d51f020.jpg','Platformer, Arcade','1990-11-21','Nintendo Switch, Nintendo 3DS, Wii U, Wii, Game Boy Advance'),(24975,1,'Donkey Kong Country Returns','https://media.rawg.io/media/screenshots/833/833ed43c10cdcb03981b988c57786739.jpg','Platformer','2010-11-21','Nintendo 3DS, Wii U, Wii'),(25178,1,'Paper Mario (2000)','https://media.rawg.io/media/screenshots/062/0622bec29ae3ef0e8762a9c9f3e7b0f4.jpg','RPG','2000-08-11','Nintendo 64'),(26090,1,'Pokémon Mystery Dungeon: Esploratori del Cielo','https://media.rawg.io/media/screenshots/da9/da9d31d5e52d1d3fdcf3adb4209292ce.jpg','Adventure, Action, RPG','2009-10-12','Nintendo DS, Wii U'),(28026,1,'Super Mario Odyssey','https://media.rawg.io/media/games/267/267bd0dbc496f52692487d07d014c061.jpg','Platformer, Arcade','2017-10-27','Nintendo Switch'),(276685,1,'STEINS;GATE: Linear Bounded Phenogram','https://media.rawg.io/media/screenshots/c4a/c4a35ffac64e6550fac6a692910792d7.jpg','Adventure','2013-04-25','PC, PlayStation 4, iOS, Xbox 360, PlayStation 3'),(282828,1,'STEINS;GATE 0','https://media.rawg.io/media/screenshots/309/3098871f6c34615173edca785ebbf1d3.jpg','Adventure','2015-12-10','PC, Xbox One, PlayStation 4, Nintendo Switch, PlayStation 3'),(397507,1,'STEINS;GATE: My Darling\'s Embrace','https://media.rawg.io/media/screenshots/238/238e604c624909062ab66ebbb37b510d.jpg','Indie, Adventure, RPG','2011-12-10','PC, PlayStation 4, Nintendo Switch, iOS, PlayStation 3');
/*!40000 ALTER TABLE `likedgames` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`game_id`),
  KEY `user_index` (`user_id`),
  KEY `game_index` (`game_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `likedgames` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (8,3439),(8,13513),(8,16700),(8,23027),(8,23165),(8,24030),(8,24899),(8,24975),(8,25178),(8,26090),(11,13513),(11,28026),(11,276685),(11,282828),(11,397507);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mygames`
--

DROP TABLE IF EXISTS `mygames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mygames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `titolo` varchar(60) DEFAULT NULL,
  `img` varchar(120) DEFAULT NULL,
  `genere` varchar(60) DEFAULT NULL,
  `data` varchar(15) DEFAULT NULL,
  `piattaforme` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mygames`
--

LOCK TABLES `mygames` WRITE;
/*!40000 ALTER TABLE `mygames` DISABLE KEYS */;
INSERT INTO `mygames` VALUES (1,13513,'STEINS;GATE','https://media.rawg.io/media/games/c60/c60be8ddf91ede65c65b13eff2e06c37.jpg','Adventure, RPG','2009-08-25','PC, PlayStation 4, Nintendo Switch, iOS, PlayStation 3'),(2,26055,'Mario & Luigi: Viaggio al centro di Bowser','https://media.rawg.io/media/screenshots/57a/57a1551d54b04f08962a11c5a8f9083d.jpg','RPG','2009-09-14','Nintendo DS'),(3,479694,'Inscryption','https://media.rawg.io/media/games/73e/73efc5c0ac6f354271dae610276f617c.jpg','Indie, Strategy, Adventure','2021-19-10','PC, PlayStation 5, PlayStation 4, Nintendo Switch, macOS'),(4,26492,'Il Professor Layton ed il futuro perduto','https://media.rawg.io/media/screenshots/40d/40d59e4c2ee207c2798abbe303fa48f0.jpg','Adventure, Puzzle','2010-09-12','Nintendo DS, iOS, Android'),(5,1317,'GHOST TRICK: Detective Fantasma','https://media.rawg.io/media/screenshots/d28/d28f2dea4473d7abee535eb78bee71cf.jpg','Adventure, Puzzle','2010-08-16','Nintendo DS, iOS'),(6,1452,'Phoenix Wright: Ace Attorney Trilogy','https://media.rawg.io/media/games/3e5/3e55a40ff233aacf63f96ea80fcc7234.jpg','Adventure, Simulation','2013-05-30','PC, Xbox One, PlayStation 4, Nintendo Switch, iOS'),(7,1682,'The Wolf Among Us','https://media.rawg.io/media/games/be0/be084b850302abe81675bc4ffc08a0d0.jpg','Adventure','2013-10-10','PC, PlayStation 4, Xbox One, iOS, Android'),(8,23027,'The Walking Dead: Season 1','https://media.rawg.io/media/games/8d6/8d69eb6c32ed6acfd75f82d532144993.jpg','Adventure, Action','2012-04-23','PC, Xbox One, PlayStation 4, Nintendo Switch, iOS'),(9,28026,'Super Mario Odyssey','https://media.rawg.io/media/games/267/267bd0dbc496f52692487d07d014c061.jpg','Platformer, Arcade','2017-10-27','Nintendo Switch'),(10,331454,'Pokémon Nero 2, Bianco 2','https://media.rawg.io/media/games/abf/abf12c25d84b8853f219854ef6a2a1b2.jpg','Adventure, RPG','2012-10-07','Nintendo DS'),(11,26090,'Pokémon Mystery Dungeon: Esploratori del Cielo','https://media.rawg.io/media/screenshots/da9/da9d31d5e52d1d3fdcf3adb4209292ce.jpg','Adventure, Action, RPG','2009-10-12','Nintendo DS, Wii U'),(12,4200,'Portal 2','https://media.rawg.io/media/games/328/3283617cb7d75d67257fc58339188742.jpg','Shooter, Puzzle','2011-04-18','PC, Xbox One, macOS, Linux, Xbox 360'),(13,46956,'Doki Doki Literature Club!','https://media.rawg.io/media/games/972/972aea3c9eb253e893947bec2d2cfbb9.jpg','Indie, Adventure','2017-09-22','PC, macOS, Linux'),(14,16700,'The Night of the Rabbit','https://media.rawg.io/media/screenshots/a16/a165c67bb75b40b5f8a310c55e9d34de.jpg','Indie, Adventure','2013-05-28','PC, macOS'),(15,27390,'Metroid: Zero Mission','https://media.rawg.io/media/games/a27/a271644f234ff3397938c424f6859851.jpg','Platformer, Adventure, Action','2004-02-09','Wii U, Game Boy Advance'),(16,29177,'Detroit: Become Human','https://media.rawg.io/media/games/951/951572a3dd1e42544bd39a5d5b42d234.jpg','Adventure, Action','2004-02-09','Wii U, Game Boy Advance'),(17,3439,'Life is Strange','https://media.rawg.io/media/games/562/562553814dd54e001a541e4ee83a591c.jpg','Adventure','2015-01-29','PC, Xbox One, PlayStation 4, iOS, Android'),(18,459210,'Sim City 4','https://media.rawg.io/media/screenshots/c16/c16ecfdc4b1e6c085b71bacb194d7c39.jpg','Strategy, Simulation','2003-01-14','PC'),(19,24975,'Castlevania: Dawn of Sorrow','https://media.rawg.io/media/screenshots/579/5790020dbfad5acad35b421ea9e70d00.jpg','Strategy, Simulation','2005-10-04','Nintendo DS'),(20,24975,'Donkey Kong Country Returns','https://media.rawg.io/media/screenshots/833/833ed43c10cdcb03981b988c57786739.jpg','Platformer','2010-11-21','Nintendo 3DS, Wii U, Wii');
/*!40000 ALTER TABLE `mygames` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `cognome` varchar(60) DEFAULT NULL,
  `mail` varchar(60) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (8,'Mario','Mario','Mario','Mario@funghi.com','$2y$10$5.coRf98cw1jdMNWHl5MteBvgKgmEWdTIZrx5dpR0/a57hG8dJsUe'),(11,'Okarin','Rintaro','Okabe','steins@gate.it','$2y$10$mcTufuMjN8g374ZeH5DOfOrBXxyjSsbbFXYPvZLo.hj0p6JUgFri2');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-28 17:18:31

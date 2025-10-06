-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: mbc_website
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `blog_categories`
--

LOCK TABLES `blog_categories` WRITE;
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `created_at`) VALUES (1,'Création d\'entreprise','creation-entreprise','Articles sur la création d\'entreprise','2025-10-03 09:50:46'),(2,'Fiscalité','fiscalite','Articles sur la fiscalité et les impôts','2025-10-03 09:50:46'),(3,'Expertise Comptable','expertise-comptable','Articles sur l\'expertise comptable','2025-10-03 09:50:46'),(4,'Social & Paie','social-paie','Articles sur les charges sociales et la paie','2025-10-03 09:50:46'),(5,'Conseil','conseil','Articles de conseil en gestion','2025-10-03 09:50:46');
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `blog_post_categories`
--

LOCK TABLES `blog_post_categories` WRITE;
/*!40000 ALTER TABLE `blog_post_categories` DISABLE KEYS */;
INSERT INTO `blog_post_categories` (`post_id`, `category_id`) VALUES (1,1),(2,2),(3,3);
/*!40000 ALTER TABLE `blog_post_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` (`id`, `title`, `content`, `excerpt`, `cover_image`, `content_file`, `read_time`, `author_id`, `status`, `created_at`, `updated_at`, `category_id`, `image_url`) VALUES (1,'Comment créer une SARL en France : Guide complet 2024','<p>Découvrez toutes les étapes pour créer une SARL en France, de la rédaction des statuts à l\'immatriculation au RCS. Guide pratique avec conseils d\'expert.</p><p>La SARL (Société à Responsabilité Limitée) est l\'une des formes juridiques les plus populaires pour créer une entreprise en France. Elle offre de nombreux avantages...</p>','Découvrez toutes les étapes pour créer une SARL en France, de la rédaction des statuts à l\'immatriculation au RCS. Guide pratique avec conseils d\'expert.','assets/hero.jpg',NULL,5,1,'published','2025-10-03 09:50:46','2025-10-03 11:40:50',1,NULL),(2,'TVA 2024 : Nouveaux taux et obligations','<p>Les changements de la TVA en 2024 et leurs impacts sur votre entreprise.</p><p>La TVA (Taxe sur la Valeur Ajoutée) connaît chaque année des évolutions importantes...</p>','Les changements de la TVA en 2024 et leurs impacts sur votre entreprise.','assets/fiscalité.jpg',NULL,3,1,'published','2025-10-03 09:50:46','2025-10-03 11:40:50',2,NULL),(3,'Optimiser sa comptabilité : 10 conseils pratiques','<p>Découvrez nos conseils pour optimiser votre gestion comptable et réduire vos coûts.</p><p>Une comptabilité bien organisée est la clé du succès de votre entreprise...</p>','Découvrez nos conseils pour optimiser votre gestion comptable et réduire vos coûts.','assets/conseille.png',NULL,4,1,'published','2025-10-03 09:50:46','2025-10-03 11:40:50',3,NULL),(4,'Test','Test v3','test v2','','',6,1,'published','2025-10-03 10:44:03','2025-10-03 11:40:50',4,NULL),(5,'aazdzadzadzadzadaz','zaezaezaeza ezae zaeaz eaze azeaze aze azeaz eazez','zzaezaeaze azeaze azeza eza eaze zaeza e','68dfb7ad1de14.jpg','68dfb7ad1e163.txt',1,1,'published','2025-10-03 11:46:53','2025-10-03 11:50:41',NULL,NULL),(6,'Test Blog Post','This is a test blog post content','This is a test blog post content','','',5,1,'published','2025-10-03 11:51:41','2025-10-03 11:51:41',NULL,NULL),(7,'Test avec image','Article de test avec image','Article de test avec image','68dfb9db2996c.jpg','',3,1,'published','2025-10-03 11:56:11','2025-10-03 11:56:11',NULL,NULL);
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `contact_submissions`
--

LOCK TABLES `contact_submissions` WRITE;
/*!40000 ALTER TABLE `contact_submissions` DISABLE KEYS */;
INSERT INTO `contact_submissions` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES (1,'azxazxazazodijkazpodkpo','malek08699@gmailc.om','xqsxsqxq','conseil','azdazdazdazfazfazf','read','2025-10-03 10:47:08','2025-10-03 10:49:17'),(2,'azxazxazazodijkazpodkpo','malek08699@gmailc.om','xqsxsqxq','conseil','azdazdazdazfazfazfwsvdsvwdsvwdsvdsv','read','2025-10-03 10:47:13','2025-10-03 10:49:12'),(3,'Test','test@test.com','','test','test','new','2025-10-03 10:57:44','2025-10-03 10:57:44'),(4,'Test','test@test.com','','test','test','new','2025-10-03 10:57:51','2025-10-03 10:57:51'),(5,'Test','test@test.com','','test','test','new','2025-10-03 10:57:55','2025-10-03 10:57:55'),(6,'Test User','test@example.com','','test','Test message','new','2025-10-03 11:36:26','2025-10-03 11:36:26'),(7,'Test User','test@example.com','','test','Test message','new','2025-10-03 11:36:31','2025-10-03 11:36:31'),(8,'Test User','test@example.com','0123456789','Test subject','Test message','new','2025-10-03 11:36:55','2025-10-03 11:36:55'),(9,'Test User','test@example.com','','test','Test message','new','2025-10-03 11:43:41','2025-10-03 11:43:41'),(10,'Test User','test@example.com','','test','Test message','new','2025-10-03 11:43:46','2025-10-03 11:43:46'),(11,'Test User','test@example.com','0123456789','Test','Test message','new','2025-10-03 12:01:19','2025-10-03 12:01:19'),(12,'Test User','test@example.com','0123456789','Test','Test message','new','2025-10-03 12:01:25','2025-10-03 12:01:25'),(13,'Test User','test@example.com','0123456789','Test','Test message','new','2025-10-03 12:01:31','2025-10-03 12:01:31'),(14,'malek azezaeaze','malek08699@gmailc.om','12345678','social-paie','p_h nilnhulnhulnlnlhulnhulono,m,l,l','new','2025-10-03 12:08:18','2025-10-03 12:08:18'),(15,'Test User','test@example.com','0123456789','test','Test message','new','2025-10-03 12:25:57','2025-10-03 12:25:57'),(16,'Test User','test@example.com','0123456789','test','Test message','new','2025-10-03 12:26:01','2025-10-03 12:26:01'),(17,'Test User','test@example.com','0123456789','test','Test message','new','2025-10-03 12:26:52','2025-10-03 12:26:52'),(18,'Test User','test@example.com','0123456789','test','Test message','new','2025-10-03 12:26:56','2025-10-03 12:26:56'),(19,'Test User','test@example.com','0123456789','test','Test message','new','2025-10-03 12:27:01','2025-10-03 12:27:01'),(20,'Test User','test@example.com','0123456789','test','Test message','new','2025-10-03 12:27:29','2025-10-03 12:27:29'),(21,'Test User','test@example.com','0123456789','test','Test message','new','2025-10-03 12:27:48','2025-10-03 12:27:48'),(22,'malek azezaeaze','malek08699@gmailc.om','12345678','conseil','kjlbliubhliuhliuhjlguikk','new','2025-10-03 12:29:03','2025-10-03 12:29:03'),(23,'malek azezaeaze','malek08699@gmailc.om','12345678','conseil','kjlbliubhliuhliuhjlguikk','new','2025-10-03 12:29:03','2025-10-03 12:29:03'),(24,'Test User','test@example.com','0123456789','test','Test message','new','2025-10-03 12:38:57','2025-10-03 12:38:57'),(25,'aazeaze azezaeaze','azeazeazeza@ezaeazazeeaze.lm','12345678','fiscalite','pokùkolpplplpllplpplplplpllpplplpllppllpplpl','new','2025-10-03 12:42:57','2025-10-03 12:42:57');
/*!40000 ALTER TABLE `contact_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `newsletter_subscriptions`
--

LOCK TABLES `newsletter_subscriptions` WRITE;
/*!40000 ALTER TABLE `newsletter_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `full_name`, `role`, `created_at`, `updated_at`) VALUES (1,'admin','admin@mbc-expertcomptable.fr','$2y$10$CfmN4tJ2STDtTOknG6Mxa.Uv3QbpuSotnD9mojkOBGcBI7aBnE2Y6','Majdi Besbes','admin','2025-10-03 09:50:46','2025-10-03 10:36:07'),(2,'test','test@test.tn','$2y$10$uEhBzsBqhPdse/5E/6O0MOWZTt.i8AfMfGYoCZ1R6LcXh4taBfDZ.','test','admin','2025-10-03 10:44:39','2025-10-03 10:44:39');
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

-- Dump completed on 2025-10-03 16:09:04


DROP DATABASE IF EXISTS `login_facebook`;

CREATE DATABASE IF NOT EXISTS `login_facebook` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `login_facebook`;


CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `reset_passwords` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `code` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

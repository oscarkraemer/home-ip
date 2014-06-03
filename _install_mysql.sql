_install_mysql.sql

CREATE TABLE `ipUser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(10) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_2` (`username`),
  KEY `username` (`username`)
);

CREATE TABLE `ipHost` (
  `hostname` varchar(30) NOT NULL DEFAULT '',
  `IP` int(10) unsigned DEFAULT NULL,
  `idOwner` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`hostname`),
  UNIQUE KEY `hostname` (`hostname`),
  KEY `idOwner` (`idOwner`),
  CONSTRAINT `ipHost_ibfk_1` FOREIGN KEY (`idOwner`) REFERENCES `ipUser` (`id`)
);
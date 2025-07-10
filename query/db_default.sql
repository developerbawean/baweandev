CREATE TABLE IF NOT EXISTS `outlet` (
  `idoutlet` int(11) NOT NULL AUTO_INCREMENT,
  `idoutlet_province` int(11) NOT NULL DEFAULT '0',
  `idoutlet_city` int(11) DEFAULT NULL,
  `outlet_name` varchar(200) DEFAULT NULL,
  `outlet_address` varchar(200) DEFAULT NULL,
  `latlong` varchar(200) DEFAULT NULL,
  `outlet_province` varchar(200) DEFAULT NULL,
  `outlet_city` varchar(200) DEFAULT NULL,
  `outlet_email` varchar(200) DEFAULT NULL,
  `outlet_phone` varchar(200) DEFAULT NULL,
  `is_active` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`idoutlet`),
  KEY `outlet_name` (`outlet_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `role` (
  `idrole` int(11) NOT NULL AUTO_INCREMENT,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT '0',
  `parent` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user` (
  `iduser` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idoutlet` int(11) DEFAULT NULL,
  `idrole` int(11) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `is_active` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`iduser`),
  KEY `FK_user_role` (`idrole`),
  KEY `FK_user_outlet` (`idoutlet`),
  CONSTRAINT `FK_user_outlet` FOREIGN KEY (`idoutlet`) REFERENCES `outlet` (`idoutlet`),
  CONSTRAINT `FK_user_role` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=417 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_role` (
  `iduser_role` int(11) NOT NULL AUTO_INCREMENT,
  `idrole` int(11) DEFAULT NULL,
  `menu_name` varchar(200) DEFAULT NULL,
  `access` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedby` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`iduser_role`),
  KEY `FK_user_role_role` (`idrole`),
  CONSTRAINT `FK_user_role_role` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=2793 DEFAULT CHARSET=latin1;

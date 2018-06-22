# Host: localhost  (Version: 5.6.11)
# Date: 2016-08-14 09:34:27
# Generator: MySQL-Front 5.3  (Build 4.224)

/*!40101 SET NAMES latin1 */;

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "users"
#

INSERT INTO `users` VALUES ('admin','admin','admin'),('user','user','user'),('ade','ade','admin'),('soni','soni','admin'),('irfan','irfan','user');

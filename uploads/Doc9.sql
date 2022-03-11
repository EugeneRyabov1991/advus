/*
Navicat MySQL Data Transfer

Source Server         : Local Denwer
Source Server Version : 50525
Source Host           : localhost:3306
Source Database       : advus

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2021-11-21 23:11:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bids
-- ----------------------------
DROP TABLE IF EXISTS `bids`;
CREATE TABLE `bids` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `num` int(10) DEFAULT NULL,
  `dt` varchar(255) DEFAULT NULL,
  `custFullName` varchar(255) DEFAULT NULL,
  `custName` varchar(255) DEFAULT NULL,
  `custBoss` varchar(255) DEFAULT NULL,
  `custBossFullName` varchar(255) DEFAULT NULL,
  `custINN` varchar(13) DEFAULT NULL,
  `custKPP` varchar(10) DEFAULT NULL,
  `custAddress` varchar(255) DEFAULT NULL,
  `custBank` varchar(255) DEFAULT NULL,
  `custRS` varchar(20) DEFAULT NULL,
  `custKS` varchar(20) DEFAULT NULL,
  `custBIK` varchar(9) DEFAULT NULL,
  `custOGRN` varchar(255) DEFAULT NULL,
  `subjName` varchar(255) DEFAULT NULL,
  `price` int(255) DEFAULT NULL,
  `prepaid` int(11) DEFAULT NULL,
  `estimateDt` int(255) DEFAULT NULL,
  `estimatePaid` int(11) DEFAULT NULL,
  `custDocType` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `num_dog` varchar(20) DEFAULT NULL,
  `subjType` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bids
-- ----------------------------
INSERT INTO `bids` VALUES ('1', '1', '18.11.2021', 'АО «Совенго Плюс»', 'АО «Совенго Плюс»', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `bids` VALUES ('4', '16', '21.05.2021', '2222222222222222222222222222222222222222', '11111111111', '', '', '12312', '12312312', '3333333333333333333333333333333333333', '', '', '', '', '', '', '0', '0', '0', '0', '', '2', '', '5');
INSERT INTO `bids` VALUES ('12', '9999', '15.11.2021', '', '!!!Новый заказчик !!!', '', '', '', '', '', '', '', '', '', '', '', '0', '0', '0', '0', '', '0', '', '0');
INSERT INTO `bids` VALUES ('13', '88', '19.11.2021', 'Акционерное общество «Совенго Плюс»', 'АО «Совенго Плюс»', 'И.А. Буровиченко 111', 'генерального директора Буровиченко Ирины Александровны', '7743273106', '774301001', '125438, город Москва, улица Автомоторная, дом 7, этаж 3, помещение 323', 'Северо-Западном ОАО «Сбербанк России»', '40702810855000038407', '30101815000000000653', '044030653', 'ОГРН 1187746798546 от 07.09.2018 г.', 'земельных участков (далее — Объекты оценки)', '100000', '50000', '7', '3', 'Устава', '1', '', '1');

-- ----------------------------
-- Table structure for bid_subj
-- ----------------------------
DROP TABLE IF EXISTS `bid_subj`;
CREATE TABLE `bid_subj` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_bid` int(11) DEFAULT NULL,
  `num` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bid_subj
-- ----------------------------

-- ----------------------------
-- Table structure for bid_user
-- ----------------------------
DROP TABLE IF EXISTS `bid_user`;
CREATE TABLE `bid_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_bid` int(11) DEFAULT NULL,
  `id_user` int(255) DEFAULT NULL,
  `role` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bid_user
-- ----------------------------

-- ----------------------------
-- Table structure for documents
-- ----------------------------
DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) DEFAULT NULL,
  `id_user` int(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of documents
-- ----------------------------
INSERT INTO `documents` VALUES ('1', 'Лицензия', '0', 'Doc1.rtf');
INSERT INTO `documents` VALUES ('2', 'Устав', '0', 'Doc2.txt');
INSERT INTO `documents` VALUES ('4', '1111', '1', 'Doc4.html');
INSERT INTO `documents` VALUES ('5', '!!! Новый документ !!!', '1', 'Doc5.xlsx');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `insurance` varchar(255) DEFAULT NULL,
  `insuranceSum` varchar(255) DEFAULT NULL,
  `sro` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Звягина И.', 'Zv', '111', null, 'zviagina@list.ru', '+7(921)958-63-88', null, null, null);
INSERT INTO `users` VALUES ('2', 'Сморгонский Александр Борисович', 'Smor', '222', null, 'ab.smorgonskiy@gmail.com', '+7(921)8652828', '№7811R/776/00164/20 выдан АО «АльфаСтрахование» 08.01.2021 г., период страхования с 09.01.2021 г. по 08.01.2022 г', '3000000', 'НП СРО «Деловой Союз Оценщиков»');
INSERT INTO `users` VALUES ('3', 'Ильин Артем', 'Fiia', '333', null, 'fii@yandex.ru', '+7(921)998-59-59', null, null, null);
INSERT INTO `users` VALUES ('4', 'Фаттахов М.Д.', 'Fattakhov', '444', null, 'M.Fattahov@advus-neva.ru', '994-95-43', null, null, null);
INSERT INTO `users` VALUES ('5', 'Рябуха Анастасия', 'Anastasia', '555', null, null, null, null, null, null);
INSERT INTO `users` VALUES ('6', 'Ипатова Анна', 'Anna', '678', null, null, null, null, null, null);
INSERT INTO `users` VALUES ('7', 'Марина', 'Marina', '777', null, null, null, null, null, null);
INSERT INTO `users` VALUES ('8', 'Шарина Марина Михайловна', 'Shirina', '888', null, '', '', '№7811R/776/00163/20 выдан АО «АльфаСтрахование» 31.12.2020 г., период страхования с 01.01.2021 г. по 31.12.2021 г', '3000000', 'Саморегулируемая организация Ассоциация оценщиков «Сообщество профессионалов оценки»');
INSERT INTO `users` VALUES ('13', '111111111111112', '22222222', null, null, '44444', '5555555', '77777777777777', '555555555555', 'asdasasdcfw12w12e12');

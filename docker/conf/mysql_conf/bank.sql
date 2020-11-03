/*
 Navicat Premium Data Transfer

 Source Server         : Lab-centos7
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : 192.168.56.102:3306
 Source Schema         : symfony

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 29/10/2020 17:38:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bank
-- ----------------------------
DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `money` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO `bank` VALUES (1, 'User0', 499900);
INSERT INTO `bank` VALUES (2, 'User1', 498500);
INSERT INTO `bank` VALUES (3, 'User2', 501090);
INSERT INTO `bank` VALUES (4, 'User3', 0);
INSERT INTO `bank` VALUES (5, 'User4', 499700);

SET FOREIGN_KEY_CHECKS = 1;

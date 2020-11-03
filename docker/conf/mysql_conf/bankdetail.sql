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

 Date: 29/10/2020 17:38:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bankdetail
-- ----------------------------
DROP TABLE IF EXISTS `bankdetail`;
CREATE TABLE `bankdetail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notes` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modify_money` int(11) NOT NULL,
  `old_money` int(11) NOT NULL,
  `new_money` int(11) NOT NULL,
  `created_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 109 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

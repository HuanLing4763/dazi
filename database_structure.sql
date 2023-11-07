/*
 Navicat Premium Data Transfer

 Source Server         : dazi
 Source Server Type    : MySQL
 Source Server Version : 50562 (5.5.62-log)
 Source Host           : www.huan4763.top:3306
 Source Schema         : dazi

 Target Server Type    : MySQL
 Target Server Version : 50562 (5.5.62-log)
 File Encoding         : 65001

 Date: 16/12/2022 17:39:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for contest
-- ----------------------------
DROP TABLE IF EXISTS `contest`;
CREATE TABLE `contest`  (
  `id` int(10) UNSIGNED NOT NULL,
  `acticle` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `end_time` datetime NOT NULL,
  `time_limit` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contest
-- ----------------------------
INSERT INTO `contest` VALUES (114514, '桃花源记', '2022-09-18 16:06:36', 0);

-- ----------------------------
-- Table structure for contest_info
-- ----------------------------
DROP TABLE IF EXISTS `contest_info`;
CREATE TABLE `contest_info`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `contest_id` int(10) UNSIGNED NOT NULL,
  `acticle` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `word_count` int(11) NOT NULL,
  `time` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` date NOT NULL,
  `speed` int(11) NOT NULL,
  `accuracy` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `date`(`date`) USING BTREE,
  INDEX `name`(`name`) USING BTREE,
  INDEX `contest_id`(`contest_id`) USING BTREE,
  CONSTRAINT `contest_info_ibfk_1` FOREIGN KEY (`name`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `contest_info_ibfk_2` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contest_info
-- ----------------------------

-- ----------------------------
-- Table structure for grades
-- ----------------------------
DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `acticle` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `word_count` int(11) NOT NULL,
  `time` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` date NOT NULL,
  `speed` int(11) NOT NULL,
  `accuracy` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`name`, `date`) USING BTREE,
  CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`name`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of grades
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_password` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE INDEX `index_name`(`user_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'root', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `users` VALUES (2, 'test', '7c4a8d09ca3762af61e59520943dc26494f8941b');

SET FOREIGN_KEY_CHECKS = 1;
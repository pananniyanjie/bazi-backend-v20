/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726 (5.7.26)
 Source Host           : 127.0.0.1:3306
 Source Schema         : bazi

 Target Server Type    : MySQL
 Target Server Version : 50726 (5.7.26)
 File Encoding         : 65001

 Date: 22/04/2024 23:30:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for db_bazi
-- ----------------------------
DROP TABLE IF EXISTS `db_bazi`;
CREATE TABLE `db_bazi`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '靶子id',
  `display_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '显示名称',
  `mode` int(11) UNSIGNED NULL DEFAULT 1 COMMENT '工作模式(练习/比赛)',
  `type` int(11) NULL DEFAULT NULL COMMENT '手枪步枪靶',
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '绑定ip',
  `mac` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '绑定mac',
  `state` int(11) NULL DEFAULT 2 COMMENT '靶子状态',
  `link_user` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '绑定用户',
  `link_group` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '绑定分组',
  `config` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '靶子参数',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1927 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of db_bazi
-- ----------------------------
INSERT INTO `db_bazi` VALUES (1919, 'ZJJH-1234', 2, 1, '2.22.2.2', '11:22:33:44:55:66', 1, 1, 0, NULL, NULL, '2024-02-02 01:55:45');
INSERT INTO `db_bazi` VALUES (1920, 'WDZT-2333', 2, 2, '127.0.0.1', '55:66:77:88:99', 0, 1, 0, NULL, '2024-01-21 21:26:35', '2024-02-02 01:59:01');
INSERT INTO `db_bazi` VALUES (1921, 'XYTY-1451', 2, 1, '192.168.124.1', '11:33:55:77:00', 0, 1, 0, NULL, '2024-01-21 21:28:04', '2024-02-02 01:55:45');
INSERT INTO `db_bazi` VALUES (1922, '一号射击位', 1, 2, '4.4.4.4', '11', 0, 1, 0, NULL, '2024-01-21 21:46:18', '2024-02-02 01:48:19');
INSERT INTO `db_bazi` VALUES (1923, 'VIP-SHOT', 1, 1, '5.5.5.5', '22', 0, 0, 0, NULL, '2024-01-21 21:46:36', '2024-02-02 01:48:19');
INSERT INTO `db_bazi` VALUES (1924, 'SVIP射击位', 1, 2, '6.6.6.6', '33', 0, 0, 0, NULL, '2024-01-21 21:46:52', '2024-02-02 01:48:19');
INSERT INTO `db_bazi` VALUES (1925, '黄钻会员射击位', 1, 1, '7.7.7.7', '44', 0, 0, 0, NULL, '2024-01-21 22:26:59', '2024-02-02 01:48:19');
INSERT INTO `db_bazi` VALUES (1926, '老板专用靶位', 1, 2, '8.8.8.8', '55', 0, 0, 0, NULL, '2024-01-22 00:24:31', '2024-02-02 01:48:19');

-- ----------------------------
-- Table structure for db_game_list
-- ----------------------------
DROP TABLE IF EXISTS `db_game_list`;
CREATE TABLE `db_game_list`  (
  `id` int(11) NOT NULL COMMENT '场次id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '场次名字',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '所属用户',
  `start_time` datetime NULL DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime NULL DEFAULT NULL COMMENT '结束时间',
  `mode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '场次模式',
  `team_id` int(11) NULL DEFAULT NULL COMMENT '所属队伍',
  `scoure` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '总分',
  `time` datetime NULL DEFAULT NULL COMMENT '总用时',
  `shoot_list` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '射击列表',
  `bazi_list` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所用靶子列表',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of db_game_list
-- ----------------------------

-- ----------------------------
-- Table structure for db_link
-- ----------------------------
DROP TABLE IF EXISTS `db_link`;
CREATE TABLE `db_link`  (
  `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of db_link
-- ----------------------------
INSERT INTO `db_link` VALUES (1, '第一分组', NULL);
INSERT INTO `db_link` VALUES (2, '第二分组', NULL);

-- ----------------------------
-- Table structure for db_shoot_list
-- ----------------------------
DROP TABLE IF EXISTS `db_shoot_list`;
CREATE TABLE `db_shoot_list`  (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `shoot_time` bigint(20) NULL DEFAULT NULL,
  `user_id` bigint(11) NULL DEFAULT NULL,
  `bazi_id` bigint(11) NULL DEFAULT NULL,
  `point_x` int(255) NULL DEFAULT NULL,
  `point_y` int(255) NULL DEFAULT NULL,
  `scoure` int(255) NULL DEFAULT NULL COMMENT '成绩/百分位',
  `mode` int(255) NULL DEFAULT NULL,
  `type` int(255) NULL DEFAULT NULL,
  `state` int(255) NULL DEFAULT NULL,
  `team_id` bigint(20) NULL DEFAULT NULL,
  `contest_id` bigint(20) NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后编辑时间',
  `update_user` bigint(20) NULL DEFAULT NULL COMMENT '最后编辑人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1788 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of db_shoot_list
-- ----------------------------

-- ----------------------------
-- Table structure for db_subset
-- ----------------------------
DROP TABLE IF EXISTS `db_subset`;
CREATE TABLE `db_subset`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分组id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分组名',
  `menbers` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '分组成员',
  `creative_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of db_subset
-- ----------------------------

-- ----------------------------
-- Table structure for db_team
-- ----------------------------
DROP TABLE IF EXISTS `db_team`;
CREATE TABLE `db_team`  (
  `id` bigint(20) NOT NULL COMMENT '小队id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小队名',
  `menber` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小队成员数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of db_team
-- ----------------------------

-- ----------------------------
-- Table structure for db_user
-- ----------------------------
DROP TABLE IF EXISTS `db_user`;
CREATE TABLE `db_user`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `nick_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '昵称',
  `phone_num` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `salt` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密盐',
  `rule` int(32) NOT NULL COMMENT '用户权限',
  `state` int(32) NULL DEFAULT 1 COMMENT '用户状态',
  `link_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户令牌',
  `avatar` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `setting` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '用户设置',
  `create_time` datetime NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权令牌',
  PRIMARY KEY (`id`, `username`, `rule`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of db_user
-- ----------------------------
INSERT INTO `db_user` VALUES (1, 'admin', '超级管理员', '114514', '372b86deb0c526f37657ce841a3a2216', 'a30ea15e839d6cfa1e0a033781cc3053', 10, 1, '1', 'icon', '{\"user\":{},\"TTSspeed\":1.9,\"TTShz\":1.2,\"TTSvoiceid\":1,\"TTSstate\":1,\"TTSvolume\":1,\"decimal\":1,\"time\":612,\"round\":32,\"firsttype\":0,\"firstmode\":1,\"oemtitle\":\"祥源体育\"}', '2023-12-01 01:31:45', '2024-01-27 00:57:28', NULL);
INSERT INTO `db_user` VALUES (2, 'wdzt', '扎蹄叔叔', '13387866267', NULL, NULL, 5, 0, '2', NULL, '{\r\n    \"TTSspeed\": 1.2,\r\n    \"TTShz\": 1.2,\r\n    \"TTSvoiceid\": 1,\r\n    \"TTSstate\": 1,\r\n    \"TTSvolume\": 1,\r\n    \"decimal\": 1,\r\n    \"time\": 600,\r\n    \"round\": 20,\r\n    \"firsttype\": 0,\r\n    \"firstmode\": 1,\r\n    \"oemtitle\": \"祥源体育\"\r\n}', '2023-12-01 01:32:37', '2023-12-17 20:14:34', NULL);
INSERT INTO `db_user` VALUES (3, 'pananniyanjie', '法外狂徒', '13735896523', '372b86deb0c526f37657ce841a3a2216', 'a30ea15e839d6cfa1e0a033781cc3053', 1, 1, '', NULL, '{\r\n        \"user\": {},\r\n        \"TTSspeed\": 1.2,\r\n        \"TTShz\": 0.5,\r\n        \"TTSstate\": 2,\r\n        \"TTSvolume\": 1,\r\n        \"decimal\": 0,\r\n        \"time\": 650,\r\n        \"round\": 20,\r\n        \"firsttype\": 1,\r\n        \"firstmode\": 0,\r\n        \"oemtitle\": \"黑联科技\"\r\n    }', '2023-12-03 00:12:08', '2023-12-17 19:55:49', NULL);
INSERT INTO `db_user` VALUES (4, 'xiangyuan', '测试账号', '13735795079', NULL, NULL, 1, 1, NULL, NULL, NULL, '2023-12-17 19:58:01', '2023-12-17 20:14:43', NULL);
INSERT INTO `db_user` VALUES (0, 'NULLuser', '空闲', '11111111111', '1111111', '1111', 1, 1, NULL, NULL, '{\"user\":{},\"TTSspeed\":1.9,\"TTShz\":1.2,\"TTSvoiceid\":1,\"TTSstate\":1,\"TTSvolume\":1,\"decimal\":1,\"time\":612,\"round\":32,\"firsttype\":0,\"firstmode\":1,\"oemtitle\":\"祥源体育\"}', '2024-01-21 21:29:08', '2024-01-28 22:14:32', NULL);

-- ----------------------------
-- Table structure for db_user_link
-- ----------------------------
DROP TABLE IF EXISTS `db_user_link`;
CREATE TABLE `db_user_link`  (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(11) NULL DEFAULT NULL,
  `link_id` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of db_user_link
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;

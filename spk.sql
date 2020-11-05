/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : spk

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 01/11/2020 03:54:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ahp
-- ----------------------------
DROP TABLE IF EXISTS `ahp`;
CREATE TABLE `ahp`  (
  `id_ahp` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria1` int(11) NOT NULL,
  `id_kriteria2` int(11) NOT NULL,
  `nilai` float NOT NULL,
  PRIMARY KEY (`id_ahp`) USING BTREE,
  INDEX `id_kriteria`(`id_kriteria1`) USING BTREE,
  INDEX `id_kriteria2`(`id_kriteria2`) USING BTREE,
  CONSTRAINT `id_kriteria2` FOREIGN KEY (`id_kriteria2`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ahp
-- ----------------------------
INSERT INTO `ahp` VALUES (2, 7, 7, 1);
INSERT INTO `ahp` VALUES (3, 8, 8, 1);
INSERT INTO `ahp` VALUES (8, 7, 8, 2);
INSERT INTO `ahp` VALUES (9, 8, 7, 0.5);
INSERT INTO `ahp` VALUES (11, 9, 7, 0.333);
INSERT INTO `ahp` VALUES (13, 9, 8, 0.167);
INSERT INTO `ahp` VALUES (14, 10, 10, 1);
INSERT INTO `ahp` VALUES (15, 11, 11, 1);
INSERT INTO `ahp` VALUES (16, 7, 10, 3);
INSERT INTO `ahp` VALUES (17, 10, 7, 0.333);
INSERT INTO `ahp` VALUES (18, 8, 10, 3);
INSERT INTO `ahp` VALUES (19, 10, 8, 0.333);
INSERT INTO `ahp` VALUES (20, 7, 11, 2);
INSERT INTO `ahp` VALUES (21, 11, 7, 0.5);
INSERT INTO `ahp` VALUES (22, 8, 11, 2);
INSERT INTO `ahp` VALUES (23, 11, 8, 0.5);
INSERT INTO `ahp` VALUES (24, 11, 10, 2);
INSERT INTO `ahp` VALUES (25, 10, 11, 0.5);

-- ----------------------------
-- Table structure for alternatif
-- ----------------------------
DROP TABLE IF EXISTS `alternatif`;
CREATE TABLE `alternatif`  (
  `id_alternatif` int(11) NOT NULL AUTO_INCREMENT,
  `alternatif` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_alternatif`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of alternatif
-- ----------------------------
INSERT INTO `alternatif` VALUES (2, 'Ferdy Barliansyah R.');
INSERT INTO `alternatif` VALUES (3, 'Yuan Sa\'adati');
INSERT INTO `alternatif` VALUES (5, 'Rara Atlantika');

-- ----------------------------
-- Table structure for kriteria
-- ----------------------------
DROP TABLE IF EXISTS `kriteria`;
CREATE TABLE `kriteria`  (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kriteria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kriteria`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kriteria
-- ----------------------------
INSERT INTO `kriteria` VALUES (7, 'C1', 'IPK');
INSERT INTO `kriteria` VALUES (8, 'C2', 'Jumlah Penghasilan Orang Tua');
INSERT INTO `kriteria` VALUES (10, 'C3', 'Jumlah Tanggungan Orang Tua');
INSERT INTO `kriteria` VALUES (11, 'C4', 'Aktif di Kemahasiswaan');

-- ----------------------------
-- Table structure for nilai
-- ----------------------------
DROP TABLE IF EXISTS `nilai`;
CREATE TABLE `nilai`  (
  `id_nilai` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai` float NOT NULL,
  PRIMARY KEY (`id_nilai`) USING BTREE,
  INDEX `fk_alternatif`(`id_alternatif`) USING BTREE,
  INDEX `fk_kriteria`(`id_kriteria`) USING BTREE,
  CONSTRAINT `fk_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of nilai
-- ----------------------------
INSERT INTO `nilai` VALUES (1, 2, 7, 3.87);
INSERT INTO `nilai` VALUES (2, 2, 8, 40);
INSERT INTO `nilai` VALUES (3, 2, 10, 80);
INSERT INTO `nilai` VALUES (4, 2, 11, 70);
INSERT INTO `nilai` VALUES (5, 3, 7, 4);
INSERT INTO `nilai` VALUES (6, 3, 8, 90);
INSERT INTO `nilai` VALUES (7, 3, 10, 90);
INSERT INTO `nilai` VALUES (8, 3, 11, 90);
INSERT INTO `nilai` VALUES (9, 5, 7, 3.8);
INSERT INTO `nilai` VALUES (10, 5, 8, 20);
INSERT INTO `nilai` VALUES (11, 5, 10, 60);
INSERT INTO `nilai` VALUES (12, 5, 11, 50);

-- ----------------------------
-- Table structure for sekolah
-- ----------------------------
DROP TABLE IF EXISTS `sekolah`;
CREATE TABLE `sekolah`  (
  `id_sekolah` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nohp` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_sekolah`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sekolah
-- ----------------------------
INSERT INTO `sekolah` VALUES (1, 'Aplikasi SPK AHP', '', '', 'LOGO_STMIK_LOMBOK.png');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_role` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  INDEX `fk_role`(`id_role`) USING BTREE,
  CONSTRAINT `fk_role` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'Admin', '$2y$10$qzUVAmoXQZcpo6iNjjaKdOWXIFZq7GI/8zoorTahkgaDFqzl5Z76C', 1, 1);
INSERT INTO `user` VALUES (5, 'guru', '$2y$10$PV9PwxVePrhx.ZdowFRZQOG.vCXUVUC7VAMXT3o.J280XA6ik420K', 2, 1);
INSERT INTO `user` VALUES (6, 'siswa', '$2y$10$WxGq9hpPwRgMrfgwKAq9/.9FMvni6nPbC8E9V1mLR9xnW/bLl4ugS', 4, 1);

-- ----------------------------
-- Table structure for user_access
-- ----------------------------
DROP TABLE IF EXISTS `user_access`;
CREATE TABLE `user_access`  (
  `id_access` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id_access`) USING BTREE,
  INDEX `fk_a_role`(`id_role`) USING BTREE,
  INDEX `fk_a_menu`(`id_menu`) USING BTREE,
  CONSTRAINT `fk_a_menu` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_a_role` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 69 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_access
-- ----------------------------
INSERT INTO `user_access` VALUES (1, 1, 1);
INSERT INTO `user_access` VALUES (40, 6, 1);
INSERT INTO `user_access` VALUES (50, 6, 2);
INSERT INTO `user_access` VALUES (51, 6, 4);
INSERT INTO `user_access` VALUES (62, 9, 1);
INSERT INTO `user_access` VALUES (66, 10, 1);
INSERT INTO `user_access` VALUES (67, 10, 2);
INSERT INTO `user_access` VALUES (68, 9, 2);

-- ----------------------------
-- Table structure for user_menu
-- ----------------------------
DROP TABLE IF EXISTS `user_menu`;
CREATE TABLE `user_menu`  (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `icon` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `no_order` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_menu
-- ----------------------------
INSERT INTO `user_menu` VALUES (1, 'Admin Menu', 'fa fa-laptop', 1, 2);
INSERT INTO `user_menu` VALUES (6, 'Dashboard', 'fa fa-home', 1, 1);
INSERT INTO `user_menu` VALUES (9, 'Menu Aplikasi', 'fa fa-fw  fa-folder-open', 1, 3);
INSERT INTO `user_menu` VALUES (10, 'Menu SPK', 'fa fa-fw fa-desktop', 1, 4);

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role`  (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_role`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES (1, 'Admin');
INSERT INTO `user_role` VALUES (2, 'Dosen');
INSERT INTO `user_role` VALUES (4, 'Mahasiswa');

-- ----------------------------
-- Table structure for user_submenu
-- ----------------------------
DROP TABLE IF EXISTS `user_submenu`;
CREATE TABLE `user_submenu`  (
  `id_submenu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `title` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `icon` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `url` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `no_urut` int(11) NOT NULL,
  PRIMARY KEY (`id_submenu`) USING BTREE,
  INDEX `fk_menu`(`id_menu`) USING BTREE,
  CONSTRAINT `fk_menu` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_submenu
-- ----------------------------
INSERT INTO `user_submenu` VALUES (1, 1, 'User Management', 'fa fa-fw fa-users', 'user', 1, 2);
INSERT INTO `user_submenu` VALUES (2, 1, 'Role management', 'fa fa-fw fa-cogs', 'role', 1, 1);
INSERT INTO `user_submenu` VALUES (3, 1, 'Menu Management', 'fa fa-fw fa-code', 'menu', 1, 3);
INSERT INTO `user_submenu` VALUES (6, 1, 'Access Management', 'fa fa-fw fa-lock', 'access', 1, 4);
INSERT INTO `user_submenu` VALUES (12, 6, 'Dashboard', 'fa fa-fw fa-tachometer', 'admin/dashboard', 1, 1);
INSERT INTO `user_submenu` VALUES (38, 9, 'Profil Aplikasi', 'fa fa-fw fa-map', 'profil', 1, 1);
INSERT INTO `user_submenu` VALUES (46, 10, 'Kriteria', 'fa fa-fw fa-balance-scale', 'kriteria', 1, 1);
INSERT INTO `user_submenu` VALUES (47, 10, 'Perhitungan AHP', 'fa fa-fw fa-book', 'hitung', 1, 4);
INSERT INTO `user_submenu` VALUES (48, 10, 'Alternatif', 'fa fa-fw fa-black-tie', 'alternatif', 1, 2);
INSERT INTO `user_submenu` VALUES (49, 10, 'Nilai Alternatif', 'fa fa-fw fa-edit', 'nilai', 1, 3);
INSERT INTO `user_submenu` VALUES (50, 10, 'Perangkingan', 'fa fa-fw fa-bullhorn', 'rangking', 1, 5);

SET FOREIGN_KEY_CHECKS = 1;

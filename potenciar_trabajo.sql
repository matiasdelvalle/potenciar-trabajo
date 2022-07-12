/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50722
 Source Host           : localhost:3306
 Source Schema         : potenciar_trabajo

 Target Server Type    : MySQL
 Target Server Version : 50722
 File Encoding         : 65001

 Date: 12/07/2022 19:39:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
COMMIT;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
BEGIN;
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (4, 10);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (3, 11);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (5, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (3, 12);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (2, 12);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (4, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (6, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (7, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (8, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (9, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (10, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (11, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (8, 3);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (6, 5);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (7, 5);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (10, 5);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (11, 5);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (9, 4);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (4, 6);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (5, 6);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (7, 6);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (10, 6);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (4, 7);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (12, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (13, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (14, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (15, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (16, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (17, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (18, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (19, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (20, 1);
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (13, 5);
COMMIT;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of permissions
-- ----------------------------
BEGIN;
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (4, 'editar_usuarios', 'Editar Usuarios', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (5, 'editar_roles', 'Editar Roles', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (6, 'editar_acreditaciones', 'Editar Acreditaciones', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (7, 'ver_acreditaciones', 'Ver Acreditaciones', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (8, 'ver_inbox_abogados', 'Ver Inbox Abogados', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (9, 'ver_inbox_tecnicos', 'Ver Inbox Tecnicos', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (10, 'ver_programas', 'Ver Programas', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (11, 'editar_programas', 'Editar Programas', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (12, 'crear_acreditaciones', 'Crear Acreditaciones', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (13, 'editar_estado_acreditacion', 'Editar Estado de Acreditacion', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (14, 'ver_secretarias', 'Ver Secretarias', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (15, 'ver_subsecretarias', 'Ver Subsecretarias', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (16, 'ver_direcciones', 'Ver Direcciones', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (17, 'acred_files_subir', 'Subir Archivos Acreditaciones', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (18, 'acred_contactos_subir', 'Subir Contactos Acreditaciones', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (19, 'ver_reparticiones', 'Ver Reparticiones', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (20, 'acred_autoridades_up', 'Modificar Autoridades', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for role_user
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `role_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of role_user
-- ----------------------------
BEGIN;
INSERT INTO `role_user` (`role_id`, `user_id`) VALUES (1, 1);
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (1, 'admin', 'Adm. General', '2016-06-20 19:41:55', '2018-02-23 16:20:23');
INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (3, 'Abogados DRJ', 'Abogados DRJ', '2022-03-08 11:25:26', '2022-03-08 11:26:52');
INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (4, 'Tecnicos DRJ', 'Técnicos DRJ', '2022-03-08 11:25:28', '2022-03-08 11:28:32');
INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (5, 'Administrativos DRJ', 'Administrativos DRJ', '2022-03-08 11:26:01', '2022-03-08 11:28:43');
INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (6, 'Autoridades DRJ', 'Autoridades DRJ', '2022-03-08 11:26:16', '2022-03-08 11:28:59');
INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES (7, 'Admin Usuarios', 'Admin Usuarios', '2022-03-17 11:39:42', '2022-03-17 11:41:46');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'admin', 'admin@admin.com', NULL, '$2y$10$I8FJq/HodWR9acwY/mb0f.7B2S8pZkv5YAmbnfYSj0hw62sgroHM2', NULL, '2022-07-12 21:54:49', '2022-07-12 21:54:49');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;

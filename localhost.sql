-- Adminer 4.8.1 MySQL 8.0.32-0buntu0.22.10.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `lables`;
CREATE TABLE `lables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lables_user_id_foreign` (`user_id`),
  CONSTRAINT `lables_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `lables` (`id`, `title`, `color`, `user_id`, `created_at`, `updated_at`) VALUES
(1,	'laudantium',	'LightGoldenRodYellow',	2,	'2022-06-20 03:51:38',	'2022-06-20 03:51:38'),
(2,	'eveniet',	'Red',	4,	'2022-06-20 03:51:38',	'2022-06-20 03:51:38');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(5,	'2022_04_19_093003_create_todo_lists_table',	1),
(6,	'2022_05_02_042938_create_lables_table',	1),
(7,	'2022_05_03_061048_create_tasks_table',	1),
(8,	'2022_06_07_080050_create_services_table',	1);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1,	'App\\Models\\User',	5,	'api',	'a9c3342a28c3e31fc3fc3947687e7c1854e95a295d41f4af0536f20ee533f8bc',	'[\"*\"]',	'2022-06-26 22:59:06',	'2022-06-20 04:04:49',	'2022-06-26 22:59:06'),
(2,	'App\\Models\\User',	5,	'api',	'0cbcc90c12deda48d1d2d84b29def853ec1443e23b7995d3d1abbcfa08bfb2d2',	'[\"*\"]',	NULL,	'2022-06-22 23:25:52',	'2022-06-22 23:25:52');

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `token` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`id`, `name`, `user_id`, `token`, `created_at`, `updated_at`) VALUES
(4,	'google-drive',	5,	'{\"scope\": \"https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive\", \"created\": 1656304147, \"expires_in\": 3585, \"token_type\": \"Bearer\", \"access_token\": \"ya29.a0ARrdaM-SGVuh6gjYishl1evWz3d55XWW0BuqAwZOhWtnlKj0TgvLJmORQFIieUXDS0GrC2PcSrYQaWsz2wxVmHwwpYHmy7wF-8LV45uh4PGabawS650xHa_e24KMg8JY_PKfMX69CBFMbKyrXS5FERp--B_vNg\"}',	'2022-06-26 22:59:07',	'2022-06-26 22:59:07');

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `todo_list_id` bigint unsigned NOT NULL,
  `lable_id` bigint unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'task_not_started',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_todo_list_id_foreign` (`todo_list_id`),
  KEY `tasks_lable_id_foreign` (`lable_id`),
  CONSTRAINT `tasks_lable_id_foreign` FOREIGN KEY (`lable_id`) REFERENCES `lables` (`id`),
  CONSTRAINT `tasks_todo_list_id_foreign` FOREIGN KEY (`todo_list_id`) REFERENCES `todo_lists` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tasks` (`id`, `title`, `description`, `todo_list_id`, `lable_id`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Tenetur fugit in dolor voluptatem quasi fugit.',	'Ducimus quod provident alias magnam cum. Sit et omnis hic ipsa non ut. Asperiores unde veniam totam repellat ea hic omnis. Soluta nesciunt nulla voluptates tenetur corrupti deleniti.',	1,	1,	'task_not_started',	'2022-06-20 03:51:38',	'2022-06-20 03:51:38'),
(2,	'Illo soluta inventore consectetur quas aliquam odit.',	'Perspiciatis nulla ut vitae quisquam ut rem distinctio. At deleniti facilis eum sed placeat. Dolore veniam repellat molestiae aperiam sit.',	2,	2,	'task_not_started',	'2022-06-20 03:51:38',	'2022-06-20 03:51:38');

DROP TABLE IF EXISTS `todo_lists`;
CREATE TABLE `todo_lists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `todo_lists_user_id_foreign` (`user_id`),
  CONSTRAINT `todo_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `todo_lists` (`id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(1,	'Consequatur nihil fugiat numquam.',	5,	'2022-06-20 03:51:38',	'2022-06-20 03:51:38'),
(2,	'Rem soluta vero quis dolor iste.',	5,	'2022-06-20 03:51:38',	'2022-06-20 03:51:38');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'Dwight Batz',	'morris38@example.net',	'2022-06-20 03:51:38',	'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',	'60PoUybX3T',	'2022-06-20 03:51:38',	'2022-06-20 03:51:38'),
(2,	'Dixie Reichert',	'schmitt.khalid@example.net',	'2022-06-20 03:51:38',	'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',	'bb6TRXP3S0',	'2022-06-20 03:51:38',	'2022-06-20 03:51:38'),
(3,	'Leta Lynch',	'nkuvalis@example.org',	'2022-06-20 03:51:38',	'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',	'YuzCMKtRkn',	'2022-06-20 03:51:38',	'2022-06-20 03:51:38'),
(4,	'Bertha Blick',	'lynch.donato@example.org',	'2022-06-20 03:51:38',	'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',	'HF8y38wyjL',	'2022-06-20 03:51:38',	'2022-06-20 03:51:38'),
(5,	'Tushar Patil',	'tushar.patil@gmail.com',	NULL,	'$2y$10$7WMrSd4OkxYV.QhJMZpdAep7esOE9KGN4zUDV84wICZM/vlwvQIIS',	NULL,	'2022-06-20 04:04:05',	'2022-06-20 04:04:05');

-- 2023-01-27 08:51:06

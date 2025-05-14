-- Adminer 4.8.1 MySQL 10.6.21-MariaDB-0ubuntu0.22.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admin_logs`;
CREATE TABLE `admin_logs` (
                              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `admin_id` int(10) unsigned NOT NULL,
                              `entity` varchar(50) NOT NULL,
                              `entity_id` int(10) unsigned NOT NULL,
                              `action` varchar(50) NOT NULL,
                              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                              PRIMARY KEY (`id`),
                              KEY `admin_id` (`admin_id`),
                              CONSTRAINT `admin_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin_logs` (`id`, `admin_id`, `entity`, `entity_id`, `action`, `created_at`) VALUES
    (1,	1,	'user',	4,	'delete',	'2025-05-12 04:51:35');

DROP TABLE IF EXISTS `forum_posts`;
CREATE TABLE `forum_posts` (
                               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                               `topic_id` int(10) unsigned NOT NULL,
                               `user_id` int(10) unsigned NOT NULL,
                               `content` text NOT NULL,
                               `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                               PRIMARY KEY (`id`),
                               KEY `topic_id` (`topic_id`),
                               KEY `user_id` (`user_id`),
                               CONSTRAINT `forum_posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `forum_topics` (`id`) ON DELETE CASCADE,
                               CONSTRAINT `forum_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `forum_posts` (`id`, `topic_id`, `user_id`, `content`, `created_at`) VALUES
                                                                                     (3,	1,	2,	'test',	'2025-05-12 01:42:00'),
                                                                                     (4,	1,	2,	'test2',	'2025-05-12 01:45:27'),
                                                                                     (5,	1,	2,	'test3',	'2025-05-12 01:50:19'),
                                                                                     (6,	1,	2,	'nw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejf',	'2025-05-12 01:50:28'),
                                                                                     (7,	1,	2,	'nw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejfnw4gjwjejfjwejf',	'2025-05-12 01:50:32'),
                                                                                     (8,	2,	1,	'nah',	'2025-05-13 13:44:56'),
                                                                                     (9,	2,	1,	'sssssss',	'2025-05-13 18:14:39'),
                                                                                     (10,	2,	1,	'hodne skibidi ngl',	'2025-05-14 10:45:27');

DROP TABLE IF EXISTS `forum_topics`;
CREATE TABLE `forum_topics` (
                                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `user_id` int(10) unsigned NOT NULL,
                                `title` varchar(255) NOT NULL,
                                `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                PRIMARY KEY (`id`),
                                KEY `user_id` (`user_id`),
                                CONSTRAINT `forum_topics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `forum_topics` (`id`, `user_id`, `title`, `created_at`) VALUES
                                                                        (1,	2,	'test',	'2025-05-12 01:34:31'),
                                                                        (2,	1,	'idkbroijustgothere',	'2025-05-13 13:44:53');

DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
                         `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `name` varchar(100) NOT NULL,
                         `logo` varchar(255) NOT NULL,
                         `owner_id` int(10) unsigned NOT NULL,
                         `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                         PRIMARY KEY (`id`),
                         KEY `owner_id` (`owner_id`),
                         CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `teams` (`id`, `name`, `logo`, `owner_id`, `created_at`) VALUES
                                                                         (1,	'Marw22',	'/img/teams/team-1747005720.png',	1,	'2025-05-11 19:18:52'),
                                                                         (2,	'test',	'/img/teams/team-1747007787.png',	3,	'2025-05-12 01:56:27');

DROP TABLE IF EXISTS `team_invitations`;
CREATE TABLE `team_invitations` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `team_id` int(10) unsigned NOT NULL,
                                    `email` varchar(255) NOT NULL,
                                    `token` char(32) NOT NULL,
                                    `status` enum('pending','accepted','declined') NOT NULL DEFAULT 'pending',
                                    `invited_by` int(10) unsigned NOT NULL,
                                    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                    PRIMARY KEY (`id`),
                                    UNIQUE KEY `token` (`token`),
                                    KEY `team_id` (`team_id`),
                                    KEY `invited_by` (`invited_by`),
                                    CONSTRAINT `team_invitations_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
                                    CONSTRAINT `team_invitations_ibfk_2` FOREIGN KEY (`invited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `team_invitations` (`id`, `team_id`, `email`, `token`, `status`, `invited_by`, `created_at`) VALUES
                                                                                                             (2,	1,	'jan.mares@student.ossp.cz',	'Pq4kPYsucohuK7WMhbAOsYkpofv6uNd9',	'accepted',	1,	'2025-05-12 00:44:58'),
                                                                                                             (7,	1,	'jan.mares@student.ossp.cz',	'ZKD0KKL3OEdD29RTwpxvqTkiaJsbLzUH',	'accepted',	1,	'2025-05-12 01:00:26'),
                                                                                                             (8,	1,	'jan.mares@student.ossp.cz',	'0hWWlya3KryftF7Hsi5TY9TxW72BjxuZ',	'accepted',	1,	'2025-05-12 01:00:57'),
                                                                                                             (9,	1,	'jan.mares@student.ossp.cz',	'Vf7rIVlTOj5Vap1fcqjNDRns0HJV0yNy',	'accepted',	1,	'2025-05-12 01:08:07'),
                                                                                                             (10,	1,	'test@test.com',	'VWBXDpS1TrkkM1h5WjLwAJlQ2yn6TnHp',	'accepted',	1,	'2025-05-12 01:53:43'),
                                                                                                             (11,	1,	'idk@idk.c',	'zcbtv8bC7BvX0pIJT83LuqXTCIO5BhOO',	'pending',	1,	'2025-05-13 10:22:05'),
                                                                                                             (12,	1,	'test@test.com',	'1Il0JfubvV52E5v33blwf7LM7UFrzGm8',	'pending',	1,	'2025-05-13 10:22:12');

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE `team_members` (
                                `team_id` int(10) unsigned NOT NULL,
                                `user_id` int(10) unsigned NOT NULL,
                                `joined_at` datetime NOT NULL DEFAULT current_timestamp(),
                                PRIMARY KEY (`team_id`,`user_id`),
                                KEY `user_id` (`user_id`),
                                CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
                                CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `team_members` (`team_id`, `user_id`, `joined_at`) VALUES
                                                                   (1,	1,	'2025-05-11 19:18:53'),
                                                                   (1,	2,	'2025-05-12 01:08:18'),
                                                                   (2,	3,	'2025-05-12 01:56:27');

DROP TABLE IF EXISTS `tournaments`;
CREATE TABLE `tournaments` (
                               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                               `name` varchar(100) NOT NULL,
                               `logo` varchar(255) NOT NULL,
                               `starts_at` datetime NOT NULL,
                               `team1_id` int(10) unsigned NOT NULL,
                               `team2_id` int(10) unsigned NOT NULL,
                               PRIMARY KEY (`id`),
                               KEY `team1_id` (`team1_id`),
                               KEY `team2_id` (`team2_id`),
                               CONSTRAINT `tournaments_ibfk_1` FOREIGN KEY (`team1_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
                               CONSTRAINT `tournaments_ibfk_2` FOREIGN KEY (`team2_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tournaments` (`id`, `name`, `logo`, `starts_at`, `team1_id`, `team2_id`) VALUES
    (1,	'test2',	'/img/tournaments/tourn-1747016242.png',	'2025-05-22 12:53:00',	2,	1);

DROP TABLE IF EXISTS `tournament_matches`;
CREATE TABLE `tournament_matches` (
                                      `tournament_id` int(10) unsigned NOT NULL,
                                      `team1_id` int(10) unsigned NOT NULL,
                                      `team2_id` int(10) unsigned NOT NULL,
                                      KEY `tournament_id` (`tournament_id`),
                                      KEY `team1_id` (`team1_id`),
                                      KEY `team2_id` (`team2_id`),
                                      CONSTRAINT `tournament_matches_ibfk_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE,
                                      CONSTRAINT `tournament_matches_ibfk_2` FOREIGN KEY (`team1_id`) REFERENCES `teams` (`id`),
                                      CONSTRAINT `tournament_matches_ibfk_3` FOREIGN KEY (`team2_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `email` varchar(255) NOT NULL,
                         `username` varchar(50) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `role` enum('user','admin') NOT NULL DEFAULT 'user',
                         `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `email` (`email`),
                         UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`, `created_at`) VALUES
                                                                                      (1,	'marwintv44@gmail.com',	'Marw',	'$2y$12$m1TpvlyCIYzliGaz5OVmzOeU0ER7PhaL3gDFYbIftTXeZITNfEaHW',	'admin',	'2025-05-11 16:56:49'),
                                                                                      (2,	'jan.mares@student.ossp.cz',	'JanMares',	'$2y$12$Wk.EclG1Ap4TXwBpMEk36.PrjlMjpmAWwHc42Q1OKgow.utlJXXbG',	'user',	'2025-05-11 19:40:01'),
                                                                                      (3,	'test@test.com',	'test',	'$2y$12$N9SbhFdWiHjKmzUIObHMSe42INn8IMmZIPRyMWHRGBNRxC86.vc3C',	'user',	'2025-05-12 01:53:25'),
                                                                                      (5,	'a@a.com',	'admin',	'$2y$12$9f/ddu/wv04rB4mZxP1fSu.WleC96ic9M.HNfT08MuaRKuRgNWgCK',	'admin',	'2025-05-14 10:49:52');

-- 2025-05-14 08:51:15
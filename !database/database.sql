-- Adminer 4.8.1 MySQL 10.6.21-MariaDB-0ubuntu0.22.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `forum_posts`;
CREATE TABLE `forum_posts` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `thread_id` int(11) NOT NULL,
                               `author_id` int(11) NOT NULL,
                               `content` text NOT NULL,
                               `created_at` datetime DEFAULT current_timestamp(),
                               PRIMARY KEY (`id`),
                               KEY `thread_id` (`thread_id`),
                               KEY `author_id` (`author_id`),
                               CONSTRAINT `forum_posts_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `forum_threads` (`id`) ON DELETE CASCADE,
                               CONSTRAINT `forum_posts_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `forum_posts` (`id`, `thread_id`, `author_id`, `content`, `created_at`) VALUES
                                                                                        (1,	1,	5,	'test',	'2025-05-08 00:02:51'),
                                                                                        (2,	4,	5,	'ahoj',	'2025-05-10 02:13:59'),
                                                                                        (3,	4,	5,	'ss',	'2025-05-10 02:33:35');

DROP TABLE IF EXISTS `forum_threads`;
CREATE TABLE `forum_threads` (
                                 `id` int(11) NOT NULL AUTO_INCREMENT,
                                 `title` varchar(255) NOT NULL,
                                 `author_id` int(11) NOT NULL,
                                 `created_at` datetime DEFAULT current_timestamp(),
                                 PRIMARY KEY (`id`),
                                 KEY `author_id` (`author_id`),
                                 CONSTRAINT `forum_threads_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `forum_threads` (`id`, `title`, `author_id`, `created_at`) VALUES
                                                                           (1,	'test',	5,	'2025-05-07 23:54:58'),
                                                                           (2,	'wkfnnw',	5,	'2025-05-10 02:13:47'),
                                                                           (3,	'mkdwadwa',	5,	'2025-05-10 02:13:52'),
                                                                           (4,	'dwjajdwa',	5,	'2025-05-10 02:13:56');

DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `name` varchar(100) NOT NULL,
                         `logo` varchar(255) DEFAULT NULL,
                         `owner_id` int(11) NOT NULL,
                         `created_at` datetime DEFAULT current_timestamp(),
                         PRIMARY KEY (`id`),
                         KEY `owner_id` (`owner_id`),
                         CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `teams` (`id`, `name`, `logo`, `owner_id`, `created_at`) VALUES
                                                                         (1,	'Alpha Team',	'alpha.png',	2,	'2025-05-07 14:26:07'),
                                                                         (2,	'Bravo Squad',	'bravo.png',	3,	'2025-05-07 14:26:07'),
                                                                         (3,	'Crimson',	'crimson.png',	4,	'2025-05-07 14:26:07'),
                                                                         (4,	'Delta Unit',	'delta.png',	2,	'2025-05-07 14:26:07'),
                                                                         (5,	'test',	'test',	5,	'2025-05-07 23:51:51'),
                                                                         (6,	'marw',	'https://en.m.wikipedia.org/wiki/File:Valorant_logo_-_pink_color_version.svg',	5,	'2025-05-10 02:34:41');

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE `team_members` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `team_id` int(11) NOT NULL,
                                `user_id` int(11) NOT NULL,
                                `joined_at` datetime DEFAULT current_timestamp(),
                                PRIMARY KEY (`id`),
                                KEY `team_id` (`team_id`),
                                KEY `user_id` (`user_id`),
                                CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
                                CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `team_members` (`id`, `team_id`, `user_id`, `joined_at`) VALUES
                                                                         (1,	1,	2,	'2025-05-07 14:26:16'),
                                                                         (2,	2,	3,	'2025-05-07 14:26:16'),
                                                                         (3,	3,	4,	'2025-05-07 14:26:16'),
                                                                         (4,	4,	2,	'2025-05-07 14:26:16'),
                                                                         (5,	5,	5,	'2025-05-07 23:51:51'),
                                                                         (6,	6,	5,	'2025-05-10 02:34:41');

DROP TABLE IF EXISTS `tournaments`;
CREATE TABLE `tournaments` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `name` varchar(100) NOT NULL,
                               `image` varchar(255) DEFAULT NULL,
                               `region` varchar(50) DEFAULT NULL,
                               `start_time` datetime DEFAULT NULL,
                               `status` enum('upcoming','finished') NOT NULL DEFAULT 'upcoming',
                               `created_at` datetime DEFAULT current_timestamp(),
                               PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tournaments` (`id`, `name`, `image`, `region`, `start_time`, `status`, `created_at`) VALUES
                                                                                                      (1,	'Valorant Masters Prague',	'masters.png',	'EU',	'2025-06-01 18:00:00',	'upcoming',	'2025-05-07 14:12:05'),
                                                                                                      (2,	'Valorant Clash NA',	'clash.png',	'NA',	'2025-05-01 19:00:00',	'finished',	'2025-05-07 14:12:05');

DROP TABLE IF EXISTS `tournament_matches`;
CREATE TABLE `tournament_matches` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `tournament_id` int(11) NOT NULL,
                                      `team1_id` int(11) NOT NULL,
                                      `team2_id` int(11) NOT NULL,
                                      `match_time` datetime DEFAULT NULL,
                                      PRIMARY KEY (`id`),
                                      KEY `tournament_id` (`tournament_id`),
                                      KEY `team1_id` (`team1_id`),
                                      KEY `team2_id` (`team2_id`),
                                      CONSTRAINT `tournament_matches_ibfk_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE,
                                      CONSTRAINT `tournament_matches_ibfk_2` FOREIGN KEY (`team1_id`) REFERENCES `teams` (`id`),
                                      CONSTRAINT `tournament_matches_ibfk_3` FOREIGN KEY (`team2_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tournament_matches` (`id`, `tournament_id`, `team1_id`, `team2_id`, `match_time`) VALUES
                                                                                                   (5,	1,	1,	2,	'2025-06-01 19:00:00'),
                                                                                                   (6,	1,	3,	4,	'2025-06-01 21:00:00');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `username` varchar(50) NOT NULL,
                         `email` varchar(100) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `role` enum('user','admin') NOT NULL DEFAULT 'user',
                         `created_at` datetime DEFAULT current_timestamp(),
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `username` (`username`),
                         UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
                                                                                      (1,	'admin',	'admin@example.com',	'$2y$10$RkqD6BtvI1JmAb1K5WS1a.kRqxX0Px0FSlYbBu0qfqWk14MPLjxE6',	'admin',	'2025-05-07 14:25:58'),
                                                                                      (2,	'player1',	'p1@example.com',	'$2y$10$KT/obdS5J9uKJJXrcSOMzO6ZgoACfaJMCpda0V6Ch3/C9u1A1VAY6',	'user',	'2025-05-07 14:25:58'),
                                                                                      (3,	'player2',	'p2@example.com',	'$2y$10$KT/obdS5J9uKJJXrcSOMzO6ZgoACfaJMCpda0V6Ch3/C9u1A1VAY6',	'user',	'2025-05-07 14:25:58'),
                                                                                      (4,	'player3',	'p3@example.com',	'$2y$10$KT/obdS5J9uKJJXrcSOMzO6ZgoACfaJMCpda0V6Ch3/C9u1A1VAY6',	'user',	'2025-05-07 14:25:58'),
                                                                                      (5,	'Marw',	'marwintv44@gmail.com',	'$2y$12$O8ozQ0PCYMKyhFYTL6JFd.s.RZqF7IuyXyIsl4xKjZ4pK3dq1U7P2',	'admin',	'2025-05-07 23:48:48');

-- 2025-05-10 01:29:29
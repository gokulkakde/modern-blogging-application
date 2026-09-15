-- Database Schema for College Blog App

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `categories`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `posts`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `author_id` int(11) UNSIGNED NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_posts_category` (`category_id`),
  KEY `fk_posts_author` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping seed data
-- --------------------------------------------------------

-- Default Admin User (Username: admin, Password: password123)
-- Password hash generated using password_hash('password123', PASSWORD_DEFAULT)
INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `is_admin`) 
VALUES (1, 'Admin', 'User', 'admin', 'admin@collegeblog.com', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGPEWiSDe.P2r6reC', '1731062212avatar01.jpg', 1)
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Default Categories
INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(1, 'Technology', 'All about gadgets, coding, AI, and campus tech innovations.'),
(2, 'College Life', 'Campus culture, student life, events, and dorm tips.'),
(3, 'Sports', 'Inter-college sports, athletics, games, and fitness.'),
(4, 'General', 'General announcements, discussions, and updates.'),
(5, 'Uncategorized', 'Default fallback category for general posts.')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Initial Featured & Sample Posts
INSERT INTO `posts` (`id`, `title`, `body`, `thumbnail`, `date_time`, `category_id`, `author_id`, `is_featured`) VALUES
(1, 'Welcome to College Blog Portal', 'Welcome to our official College Blog! This platform is dedicated to sharing student stories, tech breakthroughs, academic insights, and vibrant campus life. Feel free to explore categories, read recent articles, and share your own perspectives.', '1731300919blog11.jpg', NOW(), 1, 1, 1),
(2, 'Top 5 Productivity Tips for College Students', 'Balancing coursework, projects, extracurriculars, and personal life can be challenging. Here are five practical strategies: 1. Use time-blocking; 2. Keep organized notes; 3. Form peer study groups; 4. Take regular breaks; 5. Stay healthy and hydrated.', '1731314203blog1.jpg', NOW(), 2, 1, 0)
ON DUPLICATE KEY UPDATE `id`=`id`;

COMMIT;

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- database name `sblog`
--

-- --------------------------------------------------------

--
-- `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `author` tinytext NOT NULL,
  `author_email` varchar(100) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` text NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` longtext NOT NULL,
  `title` text NOT NULL,
  `category_id` int(4) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_date`, `content`, `title`, `category_id`, `status`, `comment_status`, `modified`) VALUES
(1, 1, '2013-08-26 16:20:12', 'My First blog!!  blog blog blog', 'My First Blog Post', 1, 'publish', 'open', '2013-08-26 16:20:12'),
(2, 1, '2013-08-26 16:21:13', '22222aaa', '2. Second TEST', 1, 'publish', 'open', '2013-08-26 16:21:13'),
(3, 1, '2013-08-26 16:21:47', '333', 'Third TEST', 1, 'publish', 'open', '2013-08-26 16:21:47');

-- --------------------------------------------------------

--
-- `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(60) NOT NULL DEFAULT '',
  `pass` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation_key` varchar(60) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `login_key` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `email`, `url`, `registered`, `activation_key`, `status`, `display_name`) VALUES
(1, 'admin', '$2y$10$u60h.hWjpkTBSlMfiEnRq.6vXpiterYd7kqUlIyNygtfrqeJXFFrW', 'root@localhost', '', '2013-08-01 00:00:00', '', 1, 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

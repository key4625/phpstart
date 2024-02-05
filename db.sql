CREATE TABLE IF NOT EXISTS `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`username` varchar(50) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`email` varchar(100) NOT NULL,
    `isAdmin` boolean DEFAULT 0,
	`activation_code` varchar(50) DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `articles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`slug` varchar(255) NOT NULL,
  	`title` varchar(255) NOT NULL,
  	`category_id` int DEFAULT 0,
  	`description` text,
    `link_image` varchar(255) DEFAULT '',
	`date_created` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `categories` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`slug` varchar(255) NOT NULL,
  	`title` varchar(255) NOT NULL,
	`parent_id` int DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `username`, `password`, `email`,`isAdmin`) VALUES  (1, 'test', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'test@test.com',1);

INSERT INTO `categories` (`id`, `title`, `slug`, `parent_id`) VALUES (1, 'Generale', 'generale',0), (2, 'Sport', 'sport',0), (3, 'Moda', 'moda',0);

INSERT INTO `articles` (`id`, `slug`, `title`, `category_id`, `description`, `link_image`, `date_created`) VALUES (1, 'prova123', 'Prova123', 1, '<p><br></p>', '/images/mappa.png', '2023-04-04 14:47:52');

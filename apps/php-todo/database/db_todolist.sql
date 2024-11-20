CREATE TABLE IF NOT EXISTS `todos` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `done_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


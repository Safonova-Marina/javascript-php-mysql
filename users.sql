SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

create database test_users;
use test_users;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `text_com` varchar(100),
  `ip` varchar(20) NOT NULL,
  `date_create` datetime NOT NULL,
  `path_file` varchar(40) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `t_user`
--

INSERT INTO `users` (`user_id`, `user_name`, `name`, `email`, `text_com`, `ip`, `date_create`) VALUES
(1, 'mari', 'marina', 'mari@ut.net', '',  '', NOW()),
(2, 'kate', 'katerina', 'kate@ut.net', '',  '', NOW()),
(3, 'ira', 'irina', 'ira@ut.net', '',  '', NOW());

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

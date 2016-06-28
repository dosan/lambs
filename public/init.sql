
CREATE TABLE IF NOT EXISTS `lambs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `birth_day` int(11) NOT NULL DEFAULT '0',
  `death_day` int(11) NOT NULL DEFAULT '0',
  `corral_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=977 DEFAULT CHARSET=utf8;

INSERT INTO `lambs` (`id`, `birth_day`, `death_day`, `corral_id`) VALUES
	(1, 1, 0, 0),
	(2, 1, 0, 2),
	(3, 1, 0, 1),
	(4, 1, 0, 3),
	(5, 1, 0, 0),
	(6, 1, 0, 0),
	(7, 1, 0, 2),
	(8, 1, 0, 1),
	(9, 1, 0, 2),
	(10, 1, 0, 0);
  
CREATE TABLE IF NOT EXISTS `time` (
  `id` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `time` (`id`, `day`) VALUES
	(0, 0);
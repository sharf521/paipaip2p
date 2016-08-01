CREATE TABLE IF NOT EXISTS  {recharge_award_rule}  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(1) NOT NULL,
  `min_account` decimal(11,2) NOT NULL,
  `max_account` decimal(11,2) NOT NULL,
  `award_rate` decimal(5,2) NOT NULL,
  `begin_time` varchar(50) NOT NULL,
  `end_time` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
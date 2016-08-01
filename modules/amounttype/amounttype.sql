CREATE TABLE IF NOT EXISTS  {user_amount_type}  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount_type_name` varchar(32) NOT NULL,
  `fee_rate` decimal(5,4) NOT NULL,
  `frost_rate` decimal(5,4) NOT NULL,
  `show_name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk;
CREATE TABLE IF NOT EXISTS  {blacklist}  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform` varchar(32) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `realname` varchar(32) DEFAULT NULL,
  `sex` int(1) DEFAULT NULL,
  `card_id` varchar(32) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `huhou_addr` varchar(64) DEFAULT NULL,
  `live_addr` varchar(64) DEFAULT NULL,
  `late_amount` decimal(11,2) DEFAULT NULL,
  `late_num` int(11) DEFAULT NULL,
  `advance_amount` decimal(11,2) DEFAULT NULL,
  `advance_num` int(11) DEFAULT NULL,
  `late_day_num` int(11) DEFAULT NULL,
  `count_date` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
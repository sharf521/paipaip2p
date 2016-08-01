CREATE TABLE IF NOT EXISTS  {dynacontent}  (
 `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
 `site_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `status` smallint(2) unsigned NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL DEFAULT '0',
 `flag` smallint(6) NULL ,
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `url` char(60) NOT NULL DEFAULT '',
  `webname` char(30) NOT NULL DEFAULT '',
  `summary` char(200) NOT NULL DEFAULT '',
`linkman` char(50) NOT NULL DEFAULT '',
  `email` char(50) NOT NULL DEFAULT '',
  `logo` char(100) NOT NULL DEFAULT '',
`logoimg` char(100) NOT NULL DEFAULT '',
`province` char(10) NOT NULL DEFAULT '',
  `city` char(10) NOT NULL DEFAULT '',
`area` char(10) NOT NULL DEFAULT '',
`hits` int(10)  NOT NULL DEFAULT '0',
  `addtime` int(10)  NOT NULL DEFAULT '0',
`addip` char(20)  NOT NULL DEFAULT '',
  `areaid` int(11) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE IF NOT EXISTS  {dynacontent_type}  (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;



DROP TABLE IF EXISTS  {company} ;
CREATE TABLE IF NOT EXISTS  {company}  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '��˾����',
  `user_id` int(11) NOT NULL COMMENT '��ĿID',
  `flag` varchar(30) NOT NULL COMMENT '��������',
  `status` int(2) DEFAULT NULL COMMENT '״̬',
  `order` varchar(10) NOT NULL COMMENT '����',
  `litpic` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(50) DEFAULT NULL COMMENT '��������',
  `percentage` varchar(50) NOT NULL COMMENT '���ڰٷֱ�',
  `capital` varchar(50) NOT NULL COMMENT '�ʱ�',
  `ascendent` varchar(50) NOT NULL COMMENT '��Ҫ��������',
  `quality` varchar(50) DEFAULT NULL COMMENT '��������',
  `sales` varchar(50) NOT NULL COMMENT 'ȫ������',
  `staff` varchar(50) NOT NULL COMMENT 'Ա��',
  `foundyear` varchar(50) NOT NULL COMMENT '�������',
  `payment` varchar(50) DEFAULT NULL COMMENT '���ʽ',
  `markets_main` varchar(50) DEFAULT NULL COMMENT '��Ҫ�����г�',
  `markets_other` varchar(50) DEFAULT NULL COMMENT '���������г�',
  `replace_work` varchar(50) DEFAULT NULL COMMENT '�����г�',
  `weburl` varchar(200) NOT NULL COMMENT '��ַ',
  `rdman` varchar(50) NOT NULL COMMENT '�з���Ա����',
  `engineer` varchar(50) NOT NULL COMMENT '����ʦ����',
  `summary` varchar(255) DEFAULT NULL COMMENT '���',
  `content` text COMMENT '����',
  `province` varchar(20) DEFAULT NULL COMMENT 'ʡ��',
  `city` varchar(20) DEFAULT NULL COMMENT '����',
  `area` varchar(20) DEFAULT NULL COMMENT '��',
  `address` varchar(200) DEFAULT NULL COMMENT '��ַ',
  `postcode` varchar(100) DEFAULT NULL COMMENT '�ʱ�',
  `linkman` varchar(20) DEFAULT NULL COMMENT '��ϵ��',
  `email` varchar(100) DEFAULT NULL COMMENT 'email',
  `tel` varchar(200) DEFAULT NULL COMMENT '�绰',
  `fax` varchar(100) DEFAULT NULL COMMENT '����',
  `msn` varchar(100) DEFAULT NULL COMMENT 'msn',
  `qq` varchar(100) DEFAULT NULL COMMENT 'QQ',
  `hits` int(11) DEFAULT '0' COMMENT '�������',
  `addtime` varchar(30) DEFAULT NULL COMMENT '���ʱ��',
  `addip` varchar(30) DEFAULT NULL COMMENT '���ip',
  `updatetime` varchar(30) DEFAULT NULL COMMENT '�޸�ʱ��',
  `updateip` varchar(30) DEFAULT NULL COMMENT '�޸�ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM ;


DROP TABLE IF EXISTS  {company_goods} ;
CREATE TABLE IF NOT EXISTS  {company_goods}  (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` smallint(2) unsigned DEFAULT '0',
  `order` smallint(6) DEFAULT '0',
  `flag` char(30) DEFAULT '0',
  `name` char(250) DEFAULT NULL,
  `province` char(10) DEFAULT NULL,
  `city` char(10) DEFAULT NULL,
  `area` char(10) DEFAULT NULL,
  `num` char(50) DEFAULT NULL,
  `content` text,
  `hits` int(10) DEFAULT '0',
  `addtime` int(10) DEFAULT '0',
  `addip` char(20) DEFAULT NULL,
  `uptime` int(10) DEFAULT '0',
  `upip` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM   ;


DROP TABLE IF EXISTS  {company_job} ;
CREATE TABLE IF NOT EXISTS  {company_job}  (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` smallint(2) unsigned DEFAULT '0',
  `order` smallint(6) DEFAULT '0',
  `flag` char(30) DEFAULT '0',
  `name` char(250) DEFAULT NULL,
  `province` char(10) DEFAULT NULL,
  `city` char(10) DEFAULT NULL,
  `area` char(10) DEFAULT NULL,
  `num` char(50) DEFAULT NULL,
  `description` char(250) DEFAULT NULL,
  `demand` char(250) DEFAULT NULL,
  `hits` int(10) DEFAULT '0',
  `addtime` int(10) DEFAULT '0',
  `addip` char(20) DEFAULT NULL,
  `uptime` int(10) DEFAULT '0',
  `upip` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  ;


DROP TABLE IF EXISTS  {company_news} ;
CREATE TABLE IF NOT EXISTS  {dcompany_news}  (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` smallint(2) unsigned DEFAULT '0',
  `order` smallint(6) DEFAULT '0',
  `flag` char(30) DEFAULT '0',
  `name` char(250) DEFAULT NULL,
  `province` char(10) DEFAULT NULL,
  `city` char(10) DEFAULT NULL,
  `area` char(10) DEFAULT NULL,
  `num` char(50) DEFAULT NULL,
  `content` text,
  `hits` int(10) DEFAULT '0',
  `addtime` int(10) DEFAULT '0',
  `addip` char(20) DEFAULT NULL,
  `uptime` int(10) DEFAULT '0',
  `upip` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  ;
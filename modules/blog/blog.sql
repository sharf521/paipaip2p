DROP TABLE IF EXISTS  {blog} ;
CREATE TABLE IF NOT EXISTS  {blog}  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '����',
  `user_id` int(11) NOT NULL COMMENT '�û�ID',
  `flag` varchar(30) NOT NULL COMMENT '��������',
  `status` int(2) DEFAULT NULL COMMENT '״̬',
  `is_comment` int(2) DEFAULT NULL COMMENT '�Ƿ���������',
  `is_self` int(2) DEFAULT NULL COMMENT '�Ƿ��Լ��ɼ�',
  `order` int(10) DEFAULT 0 COMMENT '����',
  `litpic` varchar(255) NOT NULL DEFAULT '',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT '��ǩ',
  `type_id` varchar(50) DEFAULT NULL COMMENT '����',
  `content` text COMMENT '����',
 
  `hits` int(11) DEFAULT '0' COMMENT '�������',
  `addtime` varchar(30) DEFAULT NULL COMMENT '���ʱ��',
  `addip` varchar(30) DEFAULT NULL COMMENT '���ip',
  `updatetime` varchar(30) DEFAULT NULL COMMENT '�޸�ʱ��',
  `updateip` varchar(30) DEFAULT NULL COMMENT '�޸�ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM ;

DROP TABLE IF EXISTS  {blog_type} ;
CREATE TABLE IF NOT EXISTS  {blog_type}  (
	`id` INT NOT NULL auto_increment,
        `name` varchar(30) NOT NULL COMMENT '����',
        `order` int(10) DEFAULT 0 COMMENT '����',
        `user_id` int(11) NOT NULL COMMENT '�û�ID',
	`addtime` INT DEFAULT NULL COMMENT '���ʱ��',
	`addip` VARCHAR(30) DEFAULT NULL COMMENT '���IP',
	PRIMARY KEY  (`id`)
) ENGINE = MyISAM COMMENT = '��������';
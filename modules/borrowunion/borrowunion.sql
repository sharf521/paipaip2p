CREATE TABLE IF NOT EXISTS  {borrow_union}  (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '����վ��',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '�û�����',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '����',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '״̬',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '����',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '�������',
  `litpic` varchar(255) NOT NULL DEFAULT '' COMMENT '��ҵͼƬ',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '��ҵ����',
  `range` varchar(255) NOT NULL DEFAULT '' COMMENT '��Ӫ��Χ',
 `province` int(10) NOT NULL DEFAULT '0' COMMENT 'ʡ��',
  `city` int(10) NOT NULL DEFAULT '0' COMMENT '����',
  `area` int(10) NOT NULL DEFAULT '0' COMMENT '����',
  `content` text COMMENT '��˾���',

  `linkman` varchar(50) NOT NULL DEFAULT ' COMMENT '��ϵ��',
  `tel` varchar(50) NOT NULL DEFAULT '' COMMENT '��ϵ�绰',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '��ϵ�绰',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '����',
  
  `addtime` varchar(50) NOT NULL DEFAULT '',
  `addip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS  {borrow_line}  (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '����վ��',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '�û�����',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '����',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '״̬',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '����',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '�������',
  `litpic` varchar(255) NOT NULL DEFAULT '' COMMENT '����ͼ',
  `flag` varchar(50) NOT NULL DEFAULT '' COMMENT '����',
  
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '�������',
  `borrow_use` int(10) NOT NULL DEFAULT '0' COMMENT '������;',
  `borrow_qixian` int(10) NOT NULL DEFAULT '0' COMMENT '��������',
  `province` int(10) NOT NULL DEFAULT '0' COMMENT 'ʡ��',
  `city` int(10) NOT NULL DEFAULT '0' COMMENT '����',
  `area` int(10) NOT NULL DEFAULT '0' COMMENT '����',
  `account` varchar(11) DEFAULT NULL COMMENT '������',
  `content` text COMMENT '��ϸ˵��',

  `pawn` varchar(2) DEFAULT NULL COMMENT '���޵�Ѻ',
  `tel` varchar(15) DEFAULT NULL COMMENT '�绰',
  `sex` varchar(2) DEFAULT NULL COMMENT '�Ա�',
  `xing` varchar(11) DEFAULT NULL COMMENT '��',
  
  `verify_user` int(11) DEFAULT NULL COMMENT '�����',
  `verify_time` varchar(50) NOT NULL DEFAULT '' COMMENT '���ʱ��',
  `verify_remark` varchar(255) NOT NULL,
  
  `addtime` varchar(50) NOT NULL DEFAULT '',
  `addip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS  {attestation}  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '�û�����',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '�ϴ�������',
  `name` varchar(255) NOT NULL DEFAULT '',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '��֤��״̬',
  `litpic` varchar(255) NOT NULL DEFAULT '' COMMENT '��֤��ͼƬ',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '��֤�ļ��',
  `jifen` int(20) NOT NULL DEFAULT '0' COMMENT '��֤�Ļ���',
  `verify_time` varchar(32) NULL DEFAULT '' COMMENT '���ʱ��',
  `verify_user` int(11)  NULL DEFAULT '0' COMMENT '�����',
  `verify_remark` varchar(250)  NULL DEFAULT '' COMMENT '��˱�ע',
  `addtime` varchar(50) NOT NULL DEFAULT '',
  `addip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  {attestation_type}  (
  `type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '��������',
  `order` varchar(10) NOT NULL,
  `status` int(2) NOT NULL,
  `jifen` int(20) NOT NULL DEFAULT '0' COMMENT '����',
  `summary` varchar(200) NOT NULL COMMENT '���',
  `remark` varchar(200) NOT NULL  COMMENT '��ע',
  `addtime` varchar(50) NOT NULL,
  `addip` varchar(50) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM ;
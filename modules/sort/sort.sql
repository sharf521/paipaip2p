CREATE TABLE IF NOT EXISTS  {sort}  (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL COMMENT '��˾����',
  `site_id` int(11) NOT NULL COMMENT '��ĿID',
  `flag` varchar(30) NOT NULL COMMENT '��������',
  `status` int(2)  NULL COMMENT '״̬',
  `order` varchar(10) NOT NULL COMMENT '����', 
  `litpic` varchar(255) NOT NULL DEFAULT '',

  `rank` int(11) default '0' COMMENT '�ȼ�',
  `pid` int(11) default '0' COMMENT '��ĿID',
  `summary` varchar(255) default NULL COMMENT '���',
  `content` text  default NULL COMMENT '����',

  `hits` int(11)   default '0' COMMENT '�������',
  `addtime` varchar(30) default NULL COMMENT '���ʱ��',
  `addip` varchar(30) default NULL COMMENT '���ip',
  `updatetime` varchar(30) default NULL COMMENT '�޸�ʱ��',
  `updateip` varchar(30) default NULL COMMENT '�޸�ip',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM ;

 

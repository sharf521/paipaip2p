  DROP TABLE IF EXISTS  {discount} ;
  CREATE TABLE IF NOT EXISTS  {discount}  (
  `id` int(11) NOT NULL auto_increment,
`site_id` int(11) NULL COMMENT '�̼�',
  `litpic` varchar(255) default NULL  COMMENT '�ϴ�ͼƬ',
  `type` VARCHAR(50) NOT NULL COMMENT '����:�磬���У���ʳ������...',
  `business_district` VARCHAR(30) NULL COMMENT '��Ȧ',
  `company_id` int(11) NULL COMMENT '�̼�',
  `name` VARCHAR(100) NULL COMMENT '����',
  `province` INT NULL COMMENT 'ʡ��',
  `city` INT NULL COMMENT '����',
  `area` INT NULL COMMENT '��',
  `address` VARCHAR(50) NULL COMMENT '��ַ',
  `tag` VARCHAR(100) NULL COMMENT '��ǩ',
  `start_date` VARCHAR(30) NULL COMMENT '��ʼʱ��',
  `end_date` VARCHAR(30) NULL COMMENT '����ʱ��',
  `comment` TEXT NULL COMMENT '����',
  `hit` INT NULL DEFAULT 0 COMMENT '�������',
  `top` INT NULL DEFAULT 0 COMMENT '������',
  `remark` TEXT NULL COMMENT '��ע',
  `post_user` VARCHAR(50) NULL COMMENT '������',
  `flag` varchar(30) NULL COMMENT '��������',
  `order` varchar(10) NULL COMMENT '����',
  `status` int(2)  NULL COMMENT '״̬',
  `addtime` varchar(30) default NULL COMMENT '���ʱ��',
  `addip` varchar(30) default NULL COMMENT '���ip',
  `updatetime` varchar(30) default NULL COMMENT '����ʱ��',
  `updateip` varchar(30) default NULL COMMENT '����ip',
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

DROP TABLE IF EXISTS  {discount_company} ;
CREATE TABLE IF NOT EXISTS  {discount_company}  (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL COMMENT '�̼�����',
  `flag` varchar(30) default NULL  COMMENT '��������',
  `status` int(2)  default NULL  COMMENT '״̬',
  `order` varchar(10) default NULL  COMMENT '����', 
  `litpic` varchar(255) default NULL  COMMENT '�ϴ�ͼƬ',
  `goods` varchar(255) default NULL  COMMENT '���Ʒ',
  `type` varchar(50) default NULL COMMENT '�Ż�����',
 `linkman` varchar(20) default NULL COMMENT '��ϵ��',
  `tel` varchar(20) default NULL COMMENT '��ϵ�绰',
  `content` text NOT NULL COMMENT '��˾���',
  `hits` int(11)   default '0' COMMENT '�������',
  `addtime` varchar(30) default NULL COMMENT '���ʱ��',
  `addip` varchar(30) default NULL COMMENT '���ip',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM ;

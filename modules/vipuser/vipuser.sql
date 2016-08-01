DROP TABLE IF EXISTS  {vip_card_type} ;
CREATE  TABLE IF NOT EXISTS  {vip_card_type}  (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '����ID' ,
  `name` VARCHAR(40) NULL COMMENT '��������' ,
  `month_num` TINYINT NULL COMMENT '����' ,
  `addtime` varchar(30) default NULL COMMENT '���ʱ��',
  `addip` varchar(30) default NULL COMMENT '���ip',
  `updatetime` varchar(30) default NULL COMMENT '�޸�ʱ��',
  `updateip` varchar(30) default NULL COMMENT '�޸�ip',
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) ,
  UNIQUE INDEX `month_num_UNIQUE` (`month_num` ASC) )
ENGINE = MyISAM;

DROP TABLE IF EXISTS  {vip_card} ;
CREATE  TABLE IF NOT EXISTS  {vip_card}  (
  `id` int(11) NOT NULL auto_increment,
  `flag` varchar(30) NOT NULL COMMENT '��������',
  `order` varchar(10) NULL COMMENT '����',
  `city` varchar(50) NULL COMMENT '����',
  `serial_number` VARCHAR(15) NOT NULL COMMENT 'VIP����' ,
  `batch` INT NOT NULL COMMENT '��������' ,
  `password` VARCHAR(50) NOT NULL COMMENT '����' ,
  `create_time` INT NULL COMMENT '����ʱ��' ,
  `start_date` INT NULL COMMENT '��Ч�ڿ�ʼ����' ,
  `end_date` INT NULL COMMENT '��Ч�ڽ�������' ,
  `is_up_end_date` TINYINT(1) default 0 COMMENT '�Ƿ�����' ,
  `vct_name` VARCHAR(40) NULL COMMENT '��ֵ������' ,
  `month_num` TINYINT NULL COMMENT '��Ч����' ,
  `open_time` INT NULL COMMENT '����ʱ��' ,
  `status` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '״̬:0:δ���1������2���ᣬ3ͣ��, 4���' ,
  `freeze_time` INT NULL COMMENT '����ʱ��' ,
  `freeze_day` INT NULL COMMENT '��������' ,
  `freeze_times` TINYINT NULL default 0 COMMENT '�������' ,
  `stop_time` INT NULL COMMENT 'ͣ��ʱ��' ,
  `stop_day` INT NULL COMMENT 'ͣ������' ,
  `stop_times` TINYINT NULL default 0 COMMENT 'ͣ������' ,
  `create_user` VARCHAR(20) NOT NULL COMMENT '������' ,
  `remark` text NULL COMMENT '��ע' ,
  `hits` int(11) NULL COMMENT '�������',
  `addtime` varchar(30) NULL COMMENT '���ʱ��',
  `addip` varchar(30) NULL COMMENT '���ip',
  `updatetime` varchar(30) NULL COMMENT '�޸�ʱ��',
  `updateip` varchar(30) NULL COMMENT '�޸�ip',
   PRIMARY KEY  (`id`),
   UNIQUE KEY `idx_vip_sn` (`serial_number`))
COMMENT = 'VIP��' ENGINE=MyISAM ;

DROP TABLE IF EXISTS  {vip_user} ;
CREATE  TABLE IF NOT EXISTS  {vip_user}  (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `card_number` VARCHAR(15) NOT NULL COMMENT 'VIP����' ,
  `flag` varchar(30) NULL COMMENT '��������',
  `order` varchar(10) NULL COMMENT '����',
  `hits` int(11) NULL COMMENT '�������',
  `addtime` varchar(30) NULL COMMENT '���ʱ��',
  `addip` varchar(30) NULL COMMENT '���ip',
  `updatetime` varchar(30) NULL COMMENT '�޸�ʱ��',
  `updateip` varchar(30) NULL COMMENT '�޸�ip',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_vipu_u` (`user_id`))
COMMENT = 'VIP���û�' ENGINE=MyISAM ;
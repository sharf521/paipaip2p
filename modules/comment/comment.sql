CREATE  TABLE IF NOT EXISTS  {comment}  (
  `id` int(11) NOT NULL auto_increment,
  `pid` INT NOT NULL DEFAULT 0,
  `user_id` INT NOT NULL,
  `module_code` VARCHAR(50) NOT NULL,
  `article_id` INT NOT NULL,
  `comment` TEXT NOT NULL,
  `flag` varchar(30) NOT NULL COMMENT '��������',
  `order` varchar(10) NULL COMMENT '����',
  `status` int(2)  NULL COMMENT '״̬',
  `addtime` varchar(30) default NULL COMMENT '���ʱ��',
  `addip` varchar(30) default NULL COMMENT '���ip',
  `updatetime` varchar(30) default NULL COMMENT '����ʱ��',
  `updateip` varchar(30) default NULL COMMENT '����ip',
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;
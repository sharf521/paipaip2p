CREATE TABLE IF NOT EXISTS  {borrow}  (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '����վ��',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '�û�����',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '����',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '״̬',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '����',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '�������',
  `litpic` varchar(255) NOT NULL DEFAULT '' COMMENT '����ͼ',
  `flag` varchar(50) NOT NULL DEFAULT '' COMMENT '����',
  `source` varchar(50) NOT NULL DEFAULT '' COMMENT '��Դ',
  `publish` varchar(50) NOT NULL DEFAULT '' COMMENT '����ʱ��',
  `customer` int(11) DEFAULT NULL COMMENT '�ͷ�',
  `verify_user` int(11) DEFAULT NULL COMMENT '�����',
  `verify_time` varchar(50) NOT NULL DEFAULT '' COMMENT '�ͷ�',
  `verify_remark` varchar(255) NOT NULL,
  `repayment_user` int(11) NOT NULL DEFAULT '0',
  `repayment_account` varchar(50) NOT NULL,
  `repayment_time` varchar(50) NOT NULL,
  `repayment_remark` varchar(250) NOT NULL,
  `use` varchar(50) NOT NULL DEFAULT '' COMMENT '��;',
  `time_limit` varchar(50) NOT NULL DEFAULT '' COMMENT '�������',
  `style` varchar(50) NOT NULL DEFAULT '' COMMENT '���ʽ',
  `account` varchar(50) NOT NULL DEFAULT '' COMMENT '����ܽ��',
  `account_yes` varchar(10) NOT NULL DEFAULT '0',
  `tender_times` varchar(11) NOT NULL DEFAULT '0',
  `apr` varchar(50) NOT NULL DEFAULT '' COMMENT '������',
  `lowest_account` varchar(50) NOT NULL DEFAULT '' COMMENT '���Ͷ����',
  `most_account` varchar(50) NOT NULL DEFAULT '' COMMENT '���Ͷ���ܶ�',
  `valid_time` varchar(50) NOT NULL DEFAULT '' COMMENT '��Чʱ��',
  `award` varchar(50) NOT NULL DEFAULT '' COMMENT 'Ͷ�꽱��',
  `part_account` varchar(50) NOT NULL DEFAULT '' COMMENT '��̯�������',
  `funds` varchar(50) NOT NULL DEFAULT '' COMMENT '���������ı���',
  `is_false` varchar(50) NOT NULL DEFAULT '' COMMENT '���ʧ��ʱҲͬ������ ',
  `open_account` varchar(50) NOT NULL DEFAULT '' COMMENT '�����ҵ��˻��ʽ����',
  `open_borrow` varchar(50) NOT NULL DEFAULT '' COMMENT '�����ҵĽ���ʽ����',
  `open_tender` varchar(50) NOT NULL DEFAULT '' COMMENT '�����ҵ�Ͷ���ʽ����',
  `open_credit` varchar(50) NOT NULL DEFAULT '' COMMENT '�����ҵ����ö�����',
  `content` text COMMENT '��ϸ˵��',
  `addtime` varchar(50) NOT NULL DEFAULT '',
  `addip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  {borrow_tender}  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '����վ��',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '�û�����',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '����',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '״̬',
   `borrow_id` int(11) NOT NULL DEFAULT '0',
   `money` varchar(50) NOT NULL DEFAULT '',	
 `addtime` varchar(50) NOT NULL DEFAULT '',
  `addip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  {borrow_repayment}  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '����վ��',
   `status` int(2) NOT NULL DEFAULT '0',
   `order` int(2) NOT NULL DEFAULT '0',
  `borrow_id` int(11) NOT NULL DEFAULT '0' COMMENT '���id',
 `repayment_time` varchar(50) NOT NULL DEFAULT '' COMMENT '���ƻ���ʱ��',
 `repayment_yestime` varchar(50) NOT NULL DEFAULT '' COMMENT '�Ѿ�����ʱ��',
  `repayment_account` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Ԥ�����',
  `repayment_yesaccount` varchar(50) NOT NULL DEFAULT '0' COMMENT 'ʵ�����',
  `forfeit` varchar(50) NOT NULL DEFAULT '0' COMMENT '���ɽ�',
  `reminder_fee` varchar(50) NOT NULL DEFAULT '0' COMMENT '���շ�',	
  `interest` varchar(50) NOT NULL DEFAULT '0' COMMENT '��Ϣ',
  `forfeit` varchar(50) NOT NULL DEFAULT '0' COMMENT '����',	
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


ALTER TABLE {borrow ADD INDEX user_id (user_id);
ALTER TABLE dw_borrow ADD INDEX user_ids (user_id,status);
ALTER TABLE dw_borrow ADD INDEX user_idst(status);
ALTER TABLE dw_borrow_tender ADD INDEX user_id (user_id);
ALTER TABLE dw_borrow_tender ADD INDEX user_idb (borrow_id);
ALTER TABLE dw_borrow_tender ADD INDEX user_idub (user_id,borrow_id);
ALTER TABLE dw_borrow_tender ADD INDEX user_idubs (user_id,borrow_id,status);

ALTER TABLE dw_borrow_repayment ADD INDEX user_idb (borrow_id);
ALTER TABLE dw_borrow_repayment ADD INDEX user_idubs (borrow_id,status);
ALTER TABLE dw_borrow_collection ADD INDEX user_idus (user_id,status);
ALTER TABLE dw_borrow_collection ADD INDEX user_id (user_id);
ALTER TABLE dw_borrow_amount ADD INDEX user_id (user_id);
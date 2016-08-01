CREATE TABLE IF NOT EXISTS  {message}  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sent_user` int(11) NOT NULL DEFAULT '0' COMMENT '�����û�',
  `receive_user` int(11) NOT NULL DEFAULT '0' COMMENT '�����û�',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '����',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '״̬',
  `type` varchar(50) NOT NULL DEFAULT '0' COMMENT '����',
  `reply` varchar(250) NOT NULL DEFAULT '0' COMMENT '�ظ�',
  `replytime` varchar(50) NOT NULL DEFAULT '0' COMMENT '�ظ�ʱ��',
  `sented` int(2) NOT NULL DEFAULT '0' COMMENT '�Ƿ񱣴��ڷ���',
  `deltype` int(2) NOT NULL DEFAULT '0' COMMENT '�Ƿ�ɾ��',
  `content` text NOT NULL DEFAULT '' COMMENT '����',
  `addtime` varchar(50) NOT NULL DEFAULT '',
  `addip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) COMMENT '����Ϣ';


CREATE TABLE IF NOT EXISTS  {friends}  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '�û�',
  `friends_userid` int(11) NOT NULL DEFAULT '0' COMMENT '����',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '����',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '״̬',
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '����',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '����',
  `addtime` varchar(50) NOT NULL DEFAULT '',
  `addip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) COMMENT '����';


CREATE TABLE IF NOT EXISTS  {friends_request}  (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '�û�',
  `friends_userid` int(11) NOT NULL DEFAULT '0' COMMENT '����',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '״̬',
  `addtime` varchar(50) NOT NULL DEFAULT '',
  `addip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) COMMENT '���Ѽ�¼';


insert into {linkage_type} set `name` = '����Ϣ����',`nid`="message_type",`order`='10';



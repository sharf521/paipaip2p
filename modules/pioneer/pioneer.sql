CREATE TABLE IF NOT EXISTS  {pioneer}  (
   id INT AUTO_INCREMENT NOT NULL,
   title VARCHAR(128) NOT NULL,
   applicant_phone VARCHAR(32) NOT NULL,
   applicant_name VARCHAR(32) NOT NULL,
   doc_path VARCHAR(128),
   `addip` varchar(50) DEFAULT NULL,
  `addtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE = MyISAM ROW_FORMAT = DEFAULT;
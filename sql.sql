ALTER TABLE phpbb_users ADD COLUMN credits varchar(255) DEFAULT '0';
ALTER TABLE amx_amxadmins ADD COLUMN user_id int(255) DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) CHARACTER SET utf8 NOT NULL,
  `credits` bigint(9) NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `paymentsout` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) CHARACTER SET utf8 NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 NOT NULL,
  `credits` bigint(9) NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


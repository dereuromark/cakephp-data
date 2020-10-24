-- states
CREATE TABLE IF NOT EXISTS `{prefix}states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(10) unsigned NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `lat` float(10,6) DEFAULT NULL COMMENT 'latitude',
  `lng` float(10,6) DEFAULT NULL COMMENT 'longitude',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

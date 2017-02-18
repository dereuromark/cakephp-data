-- addresses
CREATE TABLE IF NOT EXISTS `{prefix}addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foreign_id` int(10) unsigned NOT NULL,
  `model` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) unsigned NOT NULL COMMENT '',
  `state_id` int(10) unsigned NOT NULL COMMENT 'redundance on purpose',
  `first_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'street address and number',
  `postal_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lat` float(10,6) DEFAULT NULL COMMENT 'maps.google.de latitude',
  `lng` float(10,6) DEFAULT NULL COMMENT 'maps.google.de longitude',
  `last_used` datetime DEFAULT NULL,
  `formatted_address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

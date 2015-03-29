-- addresses
CREATE TABLE IF NOT EXISTS `{prefix}addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foreign_id` int(10) unsigned NOT NULL DEFAULT '0',
  `model` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `country_province_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'redundance purposely',
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'street address and number',
  `postal_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lat` float(10,6) NOT NULL DEFAULT '0.000000' COMMENT 'maps.google.de latitude',
  `lng` float(10,6) NOT NULL DEFAULT '0.000000' COMMENT 'maps.google.de longitude',
  `last_used` datetime NOT NULL,
  `formatted_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
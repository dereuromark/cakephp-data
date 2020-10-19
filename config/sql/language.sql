-- languages
CREATE TABLE IF NOT EXISTS `{prefix}languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ori_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `iso3` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `iso2` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `locale_fallback` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

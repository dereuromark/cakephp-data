# Upgrading

Use the [version map](https://github.com/dereuromark/cakephp-data/wiki#cakephp-version-map) when moving between CakePHP major versions. Composer is the source of the supported PHP, CakePHP, Tools, and Shim version constraints.

Back up reference tables before changing plugin versions or applying migrations. Keep application-owned imports and schema changes separate from vendor files.

## Current development changes

The country active finder supports the ORM's `find('active')` dispatch as well as the existing direct `findActive()` helper. Language helpers pass finder options using CakePHP's current calling convention, and `getPrimaryLanguages()` applies its custom options.

Country sync now writes timezone changes to the stored `timezone_offset` field. Missing upstream timezone data is treated as an empty list. Review a sync proposal before applying it; these fixes do not make remote data authoritative.

Empty remote country and timezone catalogs no longer propose deleting existing records. The timezone seed uses PHP's bundled timezone database when its remote source is unavailable or cannot be parsed.

The legacy Locations helper uses the current query expression API. Locations remains deprecated in favor of Geo. Counties and Districts also remain deprecated; this audit does not reintroduce them as recommended models.

## Prepare an application upgrade

Check your application's custom subclasses against the plugin method signatures. Update your own ORM finders, query expressions, PHPUnit metadata, and optional Search or Geo integration when updating their packages.

Some plugin classes retain compatibility helpers and legacy application assumptions. Test the tables and controllers your application uses with its actual database driver, routes, middleware, and optional dependencies before upgrading to a future CakePHP major version.

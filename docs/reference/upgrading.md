# Upgrading

## CakePHP 6 development branch

The `cake6` branch runs against CakePHP 6 and the matching Shim, Tools and Geo branches. Entity overrides use `$patchable` for mass assignment and `$virtual` for computed properties. Controller callbacks follow the framework's `void` lifecycle contracts. HTML helper links use the `escape` option.

Application validators that use table rules must register their provider before adding those rules with `$validator->setProvider('table', $this)`. This is required because CakePHP 6 resolves rule callbacks when they are registered.

Use the [version map](https://github.com/dereuromark/cakephp-data/wiki#cakephp-version-map) when moving between CakePHP major versions. Composer is the source of the supported PHP, CakePHP, Tools, and Shim version constraints.

Back up reference tables before changing plugin versions or applying migrations. Keep application-owned imports and schema changes separate from vendor files.

## Current development changes

The country active finder supports the ORM's `find('active')` dispatch as well as the existing direct `findActive()` helper. Language helpers pass finder options using CakePHP's current calling convention, and `getPrimaryLanguages()` applies its custom options.

Country sync now writes timezone changes to the stored `timezone_offset` field. Existing timezone offsets are preserved when upstream timezone data is missing or unusable. Review a sync proposal before applying it; these fixes do not make remote data authoritative.

Empty remote country and timezone catalogs no longer propose deleting existing records. The timezone seed uses PHP's bundled timezone database when its remote source is unavailable or cannot be parsed.

The legacy Locations helper uses the current query expression API. Locations remains deprecated in favor of Geo. Counties and Districts also remain deprecated.

## Prepare an application upgrade

Check your application's custom subclasses against the plugin method signatures. Update your own ORM finders, query expressions, PHPUnit metadata, and optional Search or Geo integration when updating their packages.

Some plugin classes retain compatibility helpers and legacy application assumptions. Test the tables and controllers your application uses with its actual database driver, routes, middleware, and optional dependencies before upgrading to a future CakePHP major version.

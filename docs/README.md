# CakePHP Data Plugin

As per [ISO_3166](https://en.wikipedia.org/wiki/ISO_3166-2) there are many different subdivisions of all countries.
Hierarchical order of the data itself is:

> Continents => Countries => States => Counties => Districts => Cities

The plugin contains the following ISO geo data models:

- Continents
- Countries
- States
- Counties (deprecated, unused)
- Districts (deprecated, unused)
- Cities
- Postal Codes
- Addresses / Locations

It also contains:

- Languages
- Currencies
- MimeTypes and MimeTypeImages

## Addresses

`Address` records attach to any host record via the polymorphic `foreign_id`
(the host record's primary key) together with `model` (the host model name).

`foreign_id` defaults to `integer` and its type is controlled by the global
`Polymorphic.type` config key. Accepted values are `integer`, `biginteger`,
`uuid`, and `binaryuuid`. For the integer variants the column signedness follows
`Migrations.unsigned_primary_keys`. For UUID variants no signedness option is
applied.

To use a different type, set the config before running migrations — for example
in `config/app.php` or `config/app_local.php`:

```php
// config/app.php (merged into Configure at bootstrap, including the migrations CLI)
'Polymorphic' => [
    'type' => 'uuid', // integer (default) | biginteger | uuid | binaryuuid
],
```

This setting only affects *fresh installs* (i.e. when the migration runs for the
first time). Existing installs keep their current column type; to change the type
on an existing install, write an app-level migration that alters the column.

## Country Icons
The plugin ships with default icons in `webroot/img/country_flags/`.
It is recommended to copy them to APP level, though, for performance reasons.

If you want to further increase performance, it is recommended to use font icons.
You can use [lipis/flag-icon-css](https://github.com/lipis/flag-icon-css), for example.

For this, include the CSS and enable the config with the class to be used:
```php
'Country' => [
    'iconFontClass' => 'flag-icon',
],
```

## Language Icons
Same as with country icons. Here, we sometimes also need to map certain
language codes to country codes. You can use the `map` config here:
```php
'Language' => [
    'iconFontClass' => 'flag-icon',
    'map' => [
        'en' => 'gb',
        ...
    ],
],
```
This only applies to font icons, as with normal ones you can just rename the files in your
image folder.

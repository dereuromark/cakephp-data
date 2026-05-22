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
`foreign_id` is a `biginteger` and follows the application's primary-key
signedness via the `Migrations.unsigned_primary_keys` flag, so it lines up with
the integer ids it references.

### Using UUIDs

If your host records use UUID primary keys, add a migration in your application
that changes the column type after the plugin's tables exist:

```php
$this->table('addresses')
    ->changeColumn('foreign_id', 'uuid', [
        'null' => true,
        'default' => null,
    ])
    ->update();
```

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

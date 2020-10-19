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

# Icons

## Bundled country flags

Load `Data.Data` in your application's view, then render an ISO2 code:

```php
<?= $this->Data->countryIcon('DE') ?>
```

The helper lowercases the code and looks for its GIF in the plugin's `webroot/img/country_flags/`. An unknown code falls back to the unknown image and emits a notice when a requested flag is missing. These assets include historical country codes and are not a guarantee of political or geographic currency.

To serve your own images, copy the required flags into your application's `webroot/img/country_flags/`, then configure:

```php
use Cake\Core\Configure;

Configure::write('Country.imagePath', '/img/country_flags/');
```

## CSS flags

Install and load a flag stylesheet yourself. For the current [flag-icons](https://github.com/lipis/flag-icons) classes:

```php
use Cake\Core\Configure;

Configure::write('Country.iconFontClass', 'fi');
```

`countryIcon('DE')` then produces `fi fi-de` classes. Choose the prefix that matches your stylesheet. The plugin does not download CSS or SVG assets for this mode.

## Language flags

A language does not always correspond to one country. Set explicit mappings when using CSS flags:

```php
use Cake\Core\Configure;

Configure::write('Language.iconFontClass', 'fi');
Configure::write('Language.map', ['en' => 'gb', 'de' => 'de']);
```

```php
<?= $this->Data->languageFlag('en') ?>
```

For image flags, `languageFlag()` looks for a lowercase language-code GIF and renders a `language_flags/` image URL. Place matching files in your application's `webroot/img/language_flags/` and configure `Language.imagePath` to that directory. Image mode does not use the language-to-country mapping. Clear the `language_flags` cache after changing the available files.

Keep a visible language or country label alongside the flag; a flag alone can be ambiguous.

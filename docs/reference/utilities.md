# Currencies and MIME types

## Currency records

The currency table starts empty. Populate the records your application accepts before using its lists or conversion utilities:

```php
$currencies = $this->fetchTable('Data.Currencies');
$base = $currencies->baseCurrency();
$foreign = $currencies->foreignCurrencies()->all();
```

A base currency record is application data, separate from the exchange-rate library's default EUR base. The table's validation checks available codes through the exchange-rate library and can therefore involve external services and cache configuration.

## Exchange rates

```php
use Data\Currency\CurrencyLib;

$converter = new CurrencyLib();
$converter->includeBitcoin = false;
$converted = $converter->convert(10.0, 'EUR', 'USD');
```

The library retrieves European Central Bank reference rates and caches them. `convert()` returns a formatted string, or `null` when a currency is unavailable. It is not an exact decimal arithmetic library or a guarantee of a current executable market price. Network requests can fail; handle unavailable results in your application.

Bitcoin lookup uses a separate external provider when enabled. Disable it if your application only needs the ECB currencies, and review provider availability before relying on it.

## MIME types

```php
$mimeTypes = $this->fetchTable('Data.MimeTypes');
$pdf = $mimeTypes->findMimeType('pdf');
$active = $mimeTypes->mimeTypes()->all();
```

`findMimeType()` searches the extension as supplied and returns the first matching entity or `null`. `mimeTypes()` filters active records unless you pass `true` to include inactive ones. The migrations create the schema; they do not supply a complete MIME database.

A filename extension is not proof of file content. Use your application's upload validation and content-type detection before accepting a file.

MIME image utilities use configured filesystem paths and application assets. Check those paths and write permissions before running Admin import or image actions.

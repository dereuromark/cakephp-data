# Choosing and maintaining data

The plugin supplies table classes and migrations, not a live reference-data service. Its hierarchy is Continents, Countries, States, then Cities. The old Counties and Districts models are deprecated and have no supplied migrations. Locations moved to the Geo plugin.

## What is populated

| Data | Supplied population method |
| --- | --- |
| Continents | Initial records inserted by the continent migration |
| Countries | Manual records or a reviewed Admin country sync |
| Timezones | `TimezonesSeed` or a reviewed Admin timezone sync |
| Languages, currencies, states, cities, postal codes, MIME types | Application imports, manual records, or the relevant Admin tools |

Initial continent records are historical data. Their presence does not establish that your reference dataset is current or complete.

## Timezone seed

The timezone seed first retrieves a remote timezone list. If that source is unavailable or cannot be parsed, it falls back to PHP's bundled IANA timezone database:

```sh
bin/cake seeds run TimezonesSeed -p Data
```

The PHP fallback has timezone names, countries, and offset fields; it omits the remote source's descriptive notes and coverage text. The data follows the timezone database installed with PHP. The fallback samples January and July and uses IANA DST flags to detect seasonal changes, storing the lower seasonal offset as standard and the higher as daylight time; it is a convenience dataset, not a replacement for PHP's timezone transition rules. For storage, a timezone without a separate DST offset uses its regular offset in the non-null `offset_dst` column.

To use the offline source explicitly, configure this before running the seed:

```php
use Cake\Core\Configure;

Configure::write('Data.Timezone.source', 'php');
```

This setting applies to seeding. The Admin sync still uses the remote source so you can review its descriptive metadata. Remote timezone responses are cached for one hour; invalid responses are not cached.

Run it against an empty timezone table. The seed inserts rows; it does not merge existing rows or link canonical timezone aliases for you. Migrations 5 records completed seeds and skips them on later runs. Do not force a repeated seed into an existing dataset: it appends duplicate rows, and the supplied migration does not define a unique timezone-name index. The [Admin timezone sync](./admin) offers a review step for an existing dataset.

## Country sync

The country sync reads the XML dataset from [countries-states-cities-database](https://github.com/dr5hn/countries-states-cities-database). It compares ISO3 codes and offers additions and changes. Missing upstream records are not proposed for deletion; a partial remote catalog cannot prove that a stored record should be removed. Review changes before applying them. Deleting a country can affect associated records.

The comparison covers names, ISO2 codes, phone codes, and timezone offsets. Missing, empty, or malformed optional source fields leave stored values unchanged; they do not request deletion of a stored native name, phone code, or timezone offset. It does not automatically import states, cities, or every upstream field. The sync depends on an external network request and can fail if the source changes or is unavailable.

## Application imports

Import only data whose license permits your intended use. Map source fields to the plugin schema explicitly, validate records, and decide how to handle inactive entries and duplicate names or codes. Keep imports repeatable with stable identifiers; do not depend on a provider's row order matching plugin primary keys.

The legacy country helpers `getIdByIso()`, `getIsoById()`, and `getDefaultCountry()` use a fixed DE/AT/CH mapping. They do not query arbitrary country records. For your own dataset, query `iso2` or `iso3` directly.

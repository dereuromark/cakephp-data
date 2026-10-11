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

The timezone seed retrieves a remote timezone list. It needs network access and the upstream document to remain compatible with the parser:

```sh
bin/cake migrations seed -p Data --seed TimezonesSeed
```

Run it against an empty timezone table. The seed inserts rows; it does not merge existing rows or link canonical timezone aliases for you. Repeating it can violate the unique timezone-name index. The [Admin timezone sync](./admin) offers a review step for an existing dataset.

## Country sync

The country sync reads the XML dataset from [countries-states-cities-database](https://github.com/dr5hn/countries-states-cities-database). It compares ISO3 codes and offers additions, changes, and deletions. Review changes before applying them. Deleting a country can affect associated records.

The comparison covers names, ISO2 codes, phone codes, and timezone offsets. It does not automatically import states, cities, or every upstream field. The sync depends on an external network request and can fail if the source changes or is unavailable.

## Application imports

Import only data whose license permits your intended use. Map source fields to the plugin schema explicitly, validate records, and decide how to handle inactive entries and duplicate names or codes. Keep imports repeatable with stable identifiers; do not depend on a provider's row order matching plugin primary keys.

The legacy country helpers `getIdByIso()`, `getIsoById()`, and `getDefaultCountry()` use a fixed DE/AT/CH mapping. They do not query arbitrary country records. For your own dataset, query `iso2` or `iso3` directly.

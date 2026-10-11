# Tables and configuration

Fetch plugin tables using their plugin alias, such as `$this->fetchTable('Data.Countries')` in a controller. The supplied classes use Tools' table base class and retain some compatibility helpers from earlier plugin versions.

| Table alias | Main purpose |
| --- | --- |
| `Data.Continents` | Continent tree and country association |
| `Data.Countries` | Country names, ISO codes, phone codes, status, and timezone offsets |
| `Data.States` | Country subdivisions |
| `Data.Cities` | City records and postal-code searches |
| `Data.PostalCodes` | Postal codes and location searches |
| `Data.Languages` | Language codes, locales, fallback locales, and status |
| `Data.Timezones` | Timezone names, offsets, canonical entries, and aliases |
| `Data.Currencies` | Currency records and exchange-rate integration |
| `Data.Addresses` | Addresses attached to host records |
| `Data.MimeTypes` | MIME type and extension records |
| `Data.MimeTypeImages` | Images associated with MIME types |

Counties, Districts, and Locations are legacy models. Do not start a new application with them; their tables are not created by the supplied migrations.

## Country associations

When using only the country table, disable associations whose tables you have omitted. Configure this during application bootstrap, before a country table instance is created:

```php
use Cake\Core\Configure;

Configure::write('Data.Country.Continent', false);
Configure::write('Data.Country.State', false);
Configure::write('Data.Country.Timezone', false);
```

The values must be the boolean `false`; an unset key leaves the association enabled. Disable the reverse timezone-to-country association with `Data.Timezone.Country` if your installation omits countries.

## Language helpers

```php
$languages = $this->fetchTable('Data.Languages');
$active = $languages->getActive()->all();
$primary = $languages->getPrimaryLanguages()->all();
$namesById = $languages->getList();
$namesByCode = $languages->codeList();
```

`getActive()` filters active rows. `getPrimaryLanguages()` selects rows whose locale equals their fallback locale. The list helpers additionally filter active rows; they do not mean that every locale variant is included.

## Named connections

Plugin aliases do not select a database connection automatically. Configure the table locator before creating plugin table instances if you migrated to a named connection:

```php
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

$locator = TableRegistry::getTableLocator();
$locator->setConfig('Data.Countries', [
    'connection' => ConnectionManager::get('reference'),
]);
```

Set the connection for associated plugin tables too. All associations involved in a query or save must use compatible database connections.

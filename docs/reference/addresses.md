# Addresses

Addresses are an optional, application-dependent part of the plugin. The table loads the Geo plugin's Geocoder behavior and expects the `CLASS_USERS` constant to identify your Users table. Install and load Geo, configure its geocoder as required, and define that constant in application bootstrap before creating an address table instance:

```php
if (!defined('CLASS_USERS')) {
    define('CLASS_USERS', 'Users');
}
```

Use your application's actual Users alias if it differs. The plugin's base dependency installation alone does not provide Geo.

## Host keys

Address records attach to a host record through `foreign_id` and `model`. Store both values consistently; the foreign key alone does not identify the host model.

`Polymorphic.type` controls the `foreign_id` column type on a fresh migration. The accepted values are `integer`, `biginteger`, `uuid`, and `binaryuuid`:

```php
use Cake\Core\Configure;

Configure::write('Polymorphic.type', 'uuid');
```

Set this before running migrations, including in the CLI process that runs them. The integer variants follow `Migrations.unsigned_primary_keys` for column signedness. UUID variants do not apply that option.

Changing this configuration does not alter an existing column. Write an application migration to convert an existing installation, and account for the stored values before changing types.

## Querying addresses

```php
$addresses = $this->fetchTable('Data.Addresses');
$userAddresses = $addresses->find()
    ->where(['Addresses.model' => 'User', 'Addresses.foreign_id' => $userId])
    ->all();
```

Apply your application's ownership checks before returning address data. The legacy `getByType()` helper filters an address type and `foreign_id`, but does not also filter `model`; add that condition when different host models can share the same primary key.

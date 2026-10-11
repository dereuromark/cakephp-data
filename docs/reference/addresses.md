# Addresses

Addresses are an optional, application-dependent part of the plugin. The table loads the Geo plugin's Geocoder behavior and uses `Users` as its Users table by default. Install and load Geo and configure its geocoder as required. To select another Users table, define `CLASS_USERS` in application bootstrap before creating an address table instance:

```php
if (!defined('CLASS_USERS')) {
    define('CLASS_USERS', 'Users');
}
```

Use your application's actual Users alias if it differs. The plugin's base dependency installation alone does not provide Geo.

## Host keys

Address records attach to a host record through `foreign_id` and `model_key`. Store both values consistently; the foreign key alone does not identify the host model. Legacy application schemas can use `model` instead of `model_key`; when that column exists, the table uses it for owner-scoped validation and the Users association. The Users association selects the stored value `User` without rewriting it. Use the corresponding column in your own queries.

`Polymorphic.type` controls the `foreign_id` column type on a fresh migration. Without that setting, the column remains a nullable string with a length of 10. Explicit `string` uses the migration adapter's default string length (255 for MySQL), rather than the released unset default of 10. Other explicit values include `integer`, `biginteger`, `uuid` and `binaryuuid`:

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
    ->where(['Addresses.model_key' => 'User', 'Addresses.foreign_id' => $userId])
    ->all();
```

Apply your application's ownership checks before returning address data. The legacy `getByType()` helper filters an address type and `foreign_id`, but does not also filter `model_key`; add that condition when different host models can share the same primary key.

The base migration does not include address-type columns. Applications using `getByType()` or main-residence validation must add `address_type_id` themselves. Main-residence validation scopes an owner by both its model value and `foreign_id` when the model value is supplied. The legacy `type_id` sort applies only to schemas that contain that column.

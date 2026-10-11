# Installation

Install the plugin in your application's root directory:

```sh
composer require dereuromark/cakephp-data
bin/cake plugin load Data
```

Composer installs the required Tools and Shim packages. Load Tools if you use the supplied controllers, templates, or helpers:

```sh
bin/cake plugin load Tools
```

Loading Data enables its public and Admin routes. To use models and helpers without exposing these routes, load it in `Application::bootstrap()` instead of the generated plugin entry:

```php
$this->addPlugin('Data', ['routes' => false]);
```

## Create the tables

The models use your application's default database connection. Back up an existing database and check for table names that already exist before migrating.

If your application does not already have Migrations installed and loaded:

```sh
composer require cakephp/migrations
bin/cake plugin load Migrations
```

Create the complete plugin schema:

```sh
bin/cake migrations migrate -p Data
```

This creates tables for currencies, languages, continents, countries, states, cities, addresses, postal codes, MIME types, and timezones. It inserts continent records; most other tables start empty. It does not download a complete countries or cities dataset.

For a named database connection, add `-c reference` to the migration command and configure the same connection on the application's table classes or table locator. Running migrations on a second connection does not automatically move the models there.

## Use selected tables

You can copy the migration files you need from `vendor/dereuromark/cakephp-data/config/Migrations/` into your application's migrations directory. Review their dependencies and names first. Application migrations then become your responsibility; do not run the original plugin migrations against the same tables afterward.

A country model enables Continent, State, and Timezone associations by default. Disable unused associations before creating its table instance, as described in [Tables and configuration](../reference/tables).

Continue with [Getting started](./getting-started).

# Getting started

Complete [Installation](./installation) first. This example uses the country table created by the plugin migrations and does not need an external data service.

## Add a country

In an application controller action, fetch the plugin table and save a record:

```php
use Cake\I18n\DateTime;

$countries = $this->fetchTable('Data.Countries');
$country = $countries->newEntity([
    'name' => 'Germany',
    'ori_name' => 'Deutschland',
    'iso2' => 'DE',
    'iso3' => 'DEU',
    'status' => 1,
    'modified' => new DateTime(),
]);
$countries->saveOrFail($country);
```

Run this once, with your application's usual access control and CSRF protection. A second insert of the same country fails validation because its name and ISO codes must be unique. `ori_name` is the native name. Setting `status` to `1` makes the country active; its database default is inactive.

## Read active countries

In the controller action that displays the list:

```php
$countries = $this->fetchTable('Data.Countries');
$activeCountries = $countries->find('active')
    ->orderByAsc('Countries.name')
    ->all();
$this->set(compact('activeCountries'));
```

## Display a flag

Load the helper in your `AppView::initialize()` after the parent call:

```php
$this->loadHelper('Data.Data');
```

In the action's template:

```php
<ul>
<?php foreach ($activeCountries as $country): ?>
    <li>
        <?= $this->Data->countryIcon($country->iso2) ?>
        <?= h($country->name) ?>
    </li>
<?php endforeach; ?>
</ul>
```

The helper uses the bundled GIF flags by default. The icon is supplementary; the country name remains visible as text.

Next, choose how to [populate and maintain your data](./data), or configure [different icon assets](./icons).

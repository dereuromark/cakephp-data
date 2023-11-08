# CakePHP Data Plugin
[![CI](https://github.com/dereuromark/cakephp-data/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/dereuromark/cakephp-data/actions?query=workflow%3ACI+branch%3Amaster)
[![Coverage Status](https://codecov.io/gh/dereuromark/cakephp-data/branch/master/graph/badge.svg)](https://codecov.io/gh/dereuromark/cakephp-data)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![License](https://poser.pugx.org/dereuromark/cakephp-data/license.svg)](https://packagist.org/packages/dereuromark/cakephp-data)
[![Total Downloads](https://poser.pugx.org/dereuromark/cakephp-data/d/total.svg)](https://packagist.org/packages/dereuromark/cakephp-data)
[![Coding Standards](https://img.shields.io/badge/cs-PSR--2--R-yellow.svg)](https://github.com/php-fig-rectified/fig-rectified-standards)

A CakePHP plugin containing several useful data models that can be used in many projects.

Note: This branch requires **CakePHP 4.2+**. See [version map](https://github.com/dereuromark/cakephp-data/wiki#cakephp-version-map) for details.

## Features
- Continents => Countries => States => Counties => Districts => Cities
- Postal Codes
- Addresses
- MimeTypes and MimeTypeImages
- Languages (optionally with language flags)
- Currencies (with converter)

Both schema and data.

Countries also can have country flags (images).

## Demo
See https://sandbox.dereuromark.de/export

## How to include
Installing the plugin is pretty much as with every other CakePHP Plugin.
```
composer require dereuromark/cakephp-data
```

And then load your plugin.

Decide on what part of the plugin you need and make sure you executed the migrations for the database tables.
It is recommended to just copy the migration files over to project level.

That's it. It should be up and running.

### Possible Dependencies

- Tools plugin
- FOC Search plugin (optional, if you want basic filtering)

## Disclaimer
Use at your own risk. Please provide any fixes or enhancements via issue or better pull request.
Some classes are still from 1.2 (and are merely upgraded to 2.x/3.x) and might still need some serious refactoring.
If you are able to help on that one, that would be awesome.

### TODOs

* Better test coverage

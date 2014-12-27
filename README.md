# CakePHP Data Plugin
[![Build Status](https://api.travis-ci.org/dereuromark/cakephp-data.png?branch=cake3)](https://travis-ci.org/dereuromark/cakephp-data)
[![License](https://poser.pugx.org/dereuromark/cakephp-data/license.png)](https://packagist.org/packages/dereuromark/cakephp-data)

A Cake3.x Plugin containing several useful data models that can be used in many projects.

Please note: New functionality has been tested against 3.x (current master and dev) only. Please upgrade if possible.

## How to include
Installing the Plugin is pretty much as with every other CakePHP Plugin.
```
"require": {
    "dereuromark/cakephp-data": "dev-cake3"
}
```

Make sure you have `Plugin::load('Data')` or `Plugin::loadAll()` in your bootstrap.

That's it. It should be up and running.

### Possible Dependencies

- Tools plugin
- CakeDC search plugin (optional, if you want basic filtering)

## Disclaimer
Use at your own risk. Please provide any fixes or enhancements via issue or better pull request.
Some classes are still from 1.2 (and are merely upgraded to 2.x/3.x) and might still need some serious refactoring.
If you are able to help on that one, that would be awesome.

### TODOs

* Better test coverage

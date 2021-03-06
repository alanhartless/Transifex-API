CHANGELOG for the Transifex API Package
===============

* 2.0.0

 * Dropped support for PHP 5.x, PHP 7.0 is the minimum requirement
 * Replace `joomla/http` package with `guzzlehttp/guzzle` for HTTP adapter 
 * Add support for custom namespaces to `Transifex::get()`
 * Refactor API connector methods to return a full `Joomla\Http\Response` object
 * Removed magic getter in `Transifex` and associated class member vars
 * Support a default option in `Transifex::getOption()`
 * `Translationstrings::getStrings()` now typehints the `$options` parameter
 * Rename `api.url` option to `base_uri`
 * Remove support for `ArrayAccess` objects as an options param, must pass an array
 * Removed `TransifexObject::fetchUrl()`, use the Guzzle API instead
 * Removed `TransifexObject::processResponse()`, use the Guzzle API instead

* 1.3.0 (2016-06-09)

 * Deprecated `Http` class and `joomla/http` package integration
 * Deprecated `TransifexObject::fetchUrl()`, 2.0 will use the Guzzle API to replace this functionality

* 1.2.0 (2015-07-13)

 * Add `Transifex::get()` to fetch API objects
 * Deprecated magic getter in `Transifex` and associated class member vars for storing objects

* 1.1.0 (2015-07-12)

 * Deprecated `TransifexObject::processResponse()`, 2.0 will return the full `Joomla\Http\Response` object instead of processing the response internally

* 1.0.0 (2014-10-20)

 * Initial stable release

Geotools for Silex
==================

This package allows you to use [**Geotools**](http://geotools-php.org) in [**Silex**](http://silex.sensiolabs.org/).

[![Latest Stable Version](https://poser.pugx.org/toin0u/Geotools-silex/v/stable.png)](https://packagist.org/packages/toin0u/Geotools-silex)
[![Total Downloads](https://poser.pugx.org/toin0u/Geotools-silex/downloads.png)](https://packagist.org/packages/toin0u/Geotools-silex)
[![Build Status](https://secure.travis-ci.org/toin0u/Geotools-silex.png)](http://travis-ci.org/toin0u/Geotools-silex)
[![Coverage Status](https://coveralls.io/repos/toin0u/Geotools-silex/badge.png)](https://coveralls.io/r/toin0u/Geotools-silex)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/200a0ac5-37fd-410c-afca-7dc3a2b03c2c/mini.png)](https://insight.sensiolabs.com/projects/200a0ac5-37fd-410c-afca-7dc3a2b03c2c)

Installation
------------

It can be found on [Packagist](https://packagist.org/packages/toin0u/geotools-silex).
The recommended way is through [composer](http://getcomposer.org).

Edit `compose.json` and add:

```json
{
    "require": {
        "toin0u/geotools-laravel": "~0.2"
    }
}
```

And install dependecies:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```


Usage
-----

Registering `GeotoolsServiceProvider` is required.

```php
<?php

use Geotools\Silex\GeotoolsServiceProvider;

// .. create $app
$app->register(new GeotoolsServiceProvider());
```


Examples
--------

## Coordinate & Ellipsoid ##

```php
use League\Geotools\Coordinate\Ellipsoid;

$geotools = $app['geotools'];

// from an \Geocoder\Result\ResultInterface instance within Airy ellipsoid
$coordinate = $geotools->coordinate($geocoderResult, League\Geotools\Coordinate\Ellipsoid::createFromName(Ellipsoid::AIRY));
// or in an array of latitude/longitude coordinate within GRS 1980 ellipsoid
$coordinate = $geotools->coordinate(array(48.8234055, 2.3072664), League\Geotools\Coordinate\Ellipsoid::createFromName(Ellipsoid::GRS_1980));
// or in latitude/longitude coordinate within WGS84 ellipsoid
$coordinate = $geotools->coordinate('48.8234055, 2.3072664');
// or in degrees minutes seconds coordinate within WGS84 ellipsoid
$coordinate = $geotools->coordinate('48°49′24″N, 2°18′26″E');
// or in decimal minutes coordinate within WGS84 ellipsoid
$coordinate = $geotools->coordinate('48 49.4N, 2 18.43333E');
// the result will be:
printf("Latitude: %F\n", $coordinate->getLatitude()); // 48.8234055
printf("Longitude: %F\n", $coordinate->getLongitude()); // 2.3072664
printf("Ellipsoid name: %s\n", $coordinate->getEllipsoid()->getName()); // WGS 84
printf("Equatorial radius: %F\n", $coordinate->getEllipsoid()->getA()); // 6378136.0
printf("Polar distance: %F\n", $coordinate->getEllipsoid()->getB()); // 6356751.317598
printf("Inverse flattening: %F\n", $coordinate->getEllipsoid()->getInvF()); // 298.257224
printf("Mean radius: %F\n", $coordinate->getEllipsoid()->getArithmeticMeanRadius()); // 6371007.772533
```

[Read more...](http://geotools-php.org/#coordinate--ellipsoid)

## Convert ##

```php
$geotools = $app['geotools'];

$coordinate = $geotools->coordinate('40.446195, -79.948862');
$converted  = $geotools->convert($coordinate);
// convert to decimal degrees without and with format string
printf("%s\n", $converted->toDecimalMinutes()); // 40 26.7717N, -79 56.93172W
printf("%s\n", $converted->toDM('%P%D°%N %p%d°%n')); // 40°26.7717 -79°56.93172
// convert to degrees minutes seconds without and with format string
printf("%s\n", $converted->toDegreesMinutesSeconds('<p>%P%D:%M:%S, %p%d:%m:%s</p>')); // <p>40:26:46, -79:56:56</p>
printf("%s\n", $converted->toDMS()); // 40°26′46″N, 79°56′56″W
// convert in the UTM projection (standard format)
printf("%s\n", $converted->toUniversalTransverseMercator()); // 17T 589138 4477813
printf("%s\n", $converted->toUTM()); // 17T 589138 4477813 (alias)
```

[Read more...](http://geotools-php.org/#convert)

## Distance ##

```php
$geotools = $app['geotools'];

$coordA   = $geotools->coordinate(array(48.8234055, 2.3072664));
$coordB   = $geotools->coordinate(array(43.296482, 5.36978));
$distance = $geotools->distance()->setFrom($coordA)->setTo($coordB);

printf("%s\n",$distance->flat()); // 659166.50038742 (meters)
printf("%s\n",$distance->in('km')->haversine()); // 659.02190812846
printf("%s\n",$distance->in('mi')->vincenty()); // 409.05330679648
printf("%s\n",$distance->in('ft')->flat()); // 2162619.7519272
```

[Read more...](http://geotools-php.org/#distance)

## Point ##

```php
$geotools = $app['geotools'];

$coordA   = $geotools->coordinate(array(48.8234055, 2.3072664));
$coordB   = $geotools->coordinate(array(43.296482, 5.36978));
$point    = $geotools->point()->setFrom($coordA)->setTo($coordB);

printf("%d\n", $point->initialBearing()); // 157 (degrees)
printf("%s\n", $point->initialCardinal()); // SSE (SouthSouthEast)
printf("%d\n", $point->finalBearing()); // 160 (degrees)
printf("%s\n", $point->finalCardinal()); // SSE (SouthSouthEast)

$middlePoint = $point->middle(); // \League\Geotools\Coordinate\Coordinate
printf("%s\n", $middlePoint->getLatitude()); // 46.070143125815
printf("%s\n", $middlePoint->getLongitude()); // 3.9152401085931

$destinationPoint = $geotools->point()->setFrom($coordA)->destination(180, 200000); // \League\Geotools\Coordinate\Coordinate
printf("%s\n", $destinationPoint->getLatitude()); // 47.026774650075
printf("%s\n", $destinationPoint->getLongitude()); // 2.3072664
```

[Read more...](http://geotools-php.org/#point)

## Geohash ##

```php
$geotools = $app['geotools'];

$coordToGeohash = $geotools->coordinate('43.296482, 5.36978');

// encoding
$encoded = $geotools->geohash()->encode($coordToGeohash, 4); // 12 is the default length / precision
// encoded
printf("%s\n", $encoded->getGeohash()); // spey
// encoded bounding box
$boundingBox = $encoded->getBoundingBox(); // array of \League\Geotools\Coordinate\CoordinateInterface
$southWest   = $boundingBox[0];
$northEast   = $boundingBox[1];
printf("http://www.openstreetmap.org/?minlon=%s&minlat=%s&maxlon=%s&maxlat=%s&box=yes\n",
    $southWest->getLongitude(), $southWest->getLatitude(),
    $northEast->getLongitude(), $northEast->getLatitude()
); // http://www.openstreetmap.org/?minlon=5.2734375&minlat=43.2421875&maxlon=5.625&maxlat=43.41796875&box=yes

// decoding
$decoded = $geotools->geohash()->decode('spey61y');
// decoded coordinate
printf("%s\n", $decoded->getCoordinate()->getLatitude()); // 43.296432495117
printf("%s\n", $decoded->getCoordinate()->getLongitude()); // 5.3702545166016
// decoded bounding box
$boundingBox = $decoded->getBoundingBox(); //array of \League\Geotools\Coordinate\CoordinateInterface
$southWest   = $boundingBox[0];
$northEast   = $boundingBox[1];
printf("http://www.openstreetmap.org/?minlon=%s&minlat=%s&maxlon=%s&maxlat=%s&box=yes\n",
    $southWest->getLongitude(), $southWest->getLatitude(),
    $northEast->getLongitude(), $northEast->getLatitude()
); // http://www.openstreetmap.org/?minlon=5.3695678710938&minlat=43.295745849609&maxlon=5.3709411621094&maxlat=43.297119140625&box=yes
```

[Read more...](http://geotools-php.org/#geohash)


CLI
---

If you have a console provider registred in your application then all the
[Geotools' commands](http://geotools-php.org/#cli) will be available in your console.


Changelog
---------

[See the changelog file](https://github.com/toin0u/Geotools-silex/blob/master/CHANGELOG.md)


Support
-------

[Please open an issues in github](https://github.com/toin0u/Geotools-silex/issues)


Contributor Code of Conduct
---------------------------

As contributors and maintainers of this project, we pledge to respect all people
who contribute through reporting issues, posting feature requests, updating
documentation, submitting pull requests or patches, and other activities.

We are committed to making participation in this project a harassment-free
experience for everyone, regardless of level of experience, gender, gender
identity and expression, sexual orientation, disability, personal appearance,
body size, race, age, or religion.

Examples of unacceptable behavior by participants include the use of sexual
language or imagery, derogatory comments or personal attacks, trolling, public
or private harassment, insults, or other unprofessional conduct.

Project maintainers have the right and responsibility to remove, edit, or reject
comments, commits, code, wiki edits, issues, and other contributions that are
not aligned to this Code of Conduct. Project maintainers who do not follow the
Code of Conduct may be removed from the project team.

Instances of abusive, harassing, or otherwise unacceptable behavior may be
reported by opening an issue or contacting one or more of the project
maintainers.

This Code of Conduct is adapted from the [Contributor
Covenant](http:contributor-covenant.org), version 1.0.0, available at
[http://contributor-covenant.org/version/1/0/0/](http://contributor-covenant.org/version/1/0/0/)


License
-------

Geotools-silex is released under the MIT License. See the bundled
[LICENSE](https://github.com/toin0u/Geotools-silex/blob/master/LICENSE) file for details.

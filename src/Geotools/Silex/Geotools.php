<?php

/**
 * This file is part of the Geotools-silex library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geotools\Silex;

use League\Geotools\Geotools as BaseGeotools;
use League\Geotools\Coordinate\Coordinate;
use League\Geotools\Coordinate\Ellipsoid;

/**
 * Geotools service provider
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Geotools extends BaseGeotools
{
    /**
     * Version.
     * @see http://semver.org/
     */
    const VERSION = '0.2.1-dev';


    /**
     * Set the latitude and the longitude of the coordinates into an selected ellipsoid.
     *
     * @param ResultInterface|array|string $coordinates The coordinates.
     * @param Ellipsoid                    $ellipsoid   The selected ellipsoid (WGS84 by default).
     *
     * @return Coordinate
     */
    public function coordinate($coordinates, Ellipsoid $ellipsoid = null)
    {
        return new Coordinate($coordinates, $ellipsoid);
    }
}

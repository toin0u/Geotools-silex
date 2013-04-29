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

use Geotools\Geotools as BaseGeotools;
use Geotools\Coordinate\Coordinate;
use Geotools\Coordinate\Ellipsoid;

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
    const VERSION = '0.1.0-dev';


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

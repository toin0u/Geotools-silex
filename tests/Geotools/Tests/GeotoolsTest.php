<?php

/**
 * This file is part of the Geotools-silex library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geotools\Tests;

use Geotools\Silex\Geotools;
use League\Geotools\Coordinate\Ellipsoid;
use Geocoder\Result\Geocoded;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class GeotoolsTest extends \PHPUnit_Framework_TestCase
{
    protected $geotools;

    protected function setUp()
    {
        $this->geotools = new Geotools;
    }

    public function testStringCoordinate()
    {
        $coordinate = $this->geotools->coordinate('1, 2');

        $this->assertInstanceOf('League\Geotools\Coordinate\Coordinate', $coordinate);
        $this->assertSame(1.0, $coordinate->getLatitude());
        $this->assertSame(2.0, $coordinate->getLongitude());
        $this->assertSame('WGS 84', $coordinate->getEllipsoid()->getName());
    }

    public function testArrayCoordinate()
    {
        $coordinate = $this->geotools->coordinate(array('1', '2'));

        $this->assertInstanceOf('League\Geotools\Coordinate\Coordinate', $coordinate);
        $this->assertSame(1.0, $coordinate->getLatitude());
        $this->assertSame(2.0, $coordinate->getLongitude());
        $this->assertSame('WGS 84', $coordinate->getEllipsoid()->getName());
    }

    public function testResultInterfaceCoordinate()
    {
        $geocoded = new Geocoded;
        $geocoded->fromArray(array(
            'latitude'  => 1,
            'longitude' => 2,
        ));

        $coordinate = $this->geotools->coordinate($geocoded);

        $this->assertInstanceOf('League\Geotools\Coordinate\Coordinate', $coordinate);
        $this->assertSame(1.0, $coordinate->getLatitude());
        $this->assertSame(2.0, $coordinate->getLongitude());
        $this->assertSame('WGS 84', $coordinate->getEllipsoid()->getName());
    }

    public function testCoordinateWithoutEllipsoid()
    {
        $coordinate = $this->geotools->coordinate('1, 2');

        $this->assertInstanceOf('League\Geotools\Coordinate\Coordinate', $coordinate);
        $this->assertSame(1.0, $coordinate->getLatitude());
        $this->assertSame(2.0, $coordinate->getLongitude());
        $this->assertSame('WGS 84', $coordinate->getEllipsoid()->getName());
    }

    public function testCoordinateWithEllipsoid()
    {
        $coordinate = $this->geotools->coordinate('1, 2', Ellipsoid::createFromName(Ellipsoid::AIRY));

        $this->assertInstanceOf('League\Geotools\Coordinate\Coordinate', $coordinate);
        $this->assertSame(1.0, $coordinate->getLatitude());
        $this->assertSame(2.0, $coordinate->getLongitude());
        $this->assertSame('Airy', $coordinate->getEllipsoid()->getName());
    }
}

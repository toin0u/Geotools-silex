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

use Silex\Application;
use Geotools\Silex\GeotoolsServiceProvider;
use Symfony\Component\Console\Application as ConsoleServiceProvider;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class GeotoolsServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->app = new Application();

        $this->app->register(new GeotoolsServiceProvider);
    }

    public function testRegister()
    {
        $this->assertInstanceOf('Geotools\\Silex\\Geotools', $this->app['geotools']);
        $this->assertInstanceOf('League\\Geotools\\Geotools', $this->app['geotools']);
    }

    public function testBoot()
    {
        $this->assertNull($this->app->boot());
    }

    public function testNoConsoleProvider()
    {
        $this->assertFalse(isset($this->app['console']));
    }

    public function testConsoleProvider()
    {
        $this->app['console'] = $this->app->share(function ($app) {
            return new ConsoleServiceProvider;
        });

        $this->app->register(new GeotoolsServiceProvider);

        $this->assertTrue($this->app['console']->has('convert:dm'));
        $this->assertTrue($this->app['console']->has('convert:dms'));
        $this->assertTrue($this->app['console']->has('convert:utm'));
        $this->assertTrue($this->app['console']->has('distance:all'));
        $this->assertTrue($this->app['console']->has('distance:flat'));
        $this->assertTrue($this->app['console']->has('distance:haversine'));
        $this->assertTrue($this->app['console']->has('distance:vincenty'));
        $this->assertTrue($this->app['console']->has('geocoder:geocode'));
        $this->assertTrue($this->app['console']->has('geocoder:reverse'));
        $this->assertTrue($this->app['console']->has('geohash:decode'));
        $this->assertTrue($this->app['console']->has('geohash:encode'));
        $this->assertTrue($this->app['console']->has('point:destination'));
        $this->assertTrue($this->app['console']->has('point:final-bearing'));
        $this->assertTrue($this->app['console']->has('point:final-cardinal'));
        $this->assertTrue($this->app['console']->has('point:initial-bearing'));
        $this->assertTrue($this->app['console']->has('point:initial-cardinal'));
        $this->assertTrue($this->app['console']->has('point:middle'));
    }
}

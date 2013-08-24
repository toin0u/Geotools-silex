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
}

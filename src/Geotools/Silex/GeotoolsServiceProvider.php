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

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Geotools service provider
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class GeotoolsServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        $app['geotools'] = $app->share(function() {
            return new Geotools;
        });

        $this->registerConsole($app);
    }

    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
    }

    /**
     * @param Application $app
     */
    protected function registerConsole(Application $app)
    {
        if (!isset($app['console'])) {
            return;
        }

        $app['console'] = $app->share($app->extend('console', function ($console) {
            $console->add(new \League\Geotools\CLI\Distance\All);
            $console->add(new \League\Geotools\CLI\Distance\Flat);
            $console->add(new \League\Geotools\CLI\Distance\Haversine);
            $console->add(new \League\Geotools\CLI\Distance\Vincenty);
            $console->add(new \League\Geotools\CLI\Point\InitialBearing);
            $console->add(new \League\Geotools\CLI\Point\FinalBearing);
            $console->add(new \League\Geotools\CLI\Point\InitialCardinal);
            $console->add(new \League\Geotools\CLI\Point\FinalCardinal);
            $console->add(new \League\Geotools\CLI\Point\Middle);
            $console->add(new \League\Geotools\CLI\Point\Destination);
            $console->add(new \League\Geotools\CLI\Geohash\Encode);
            $console->add(new \League\Geotools\CLI\Geohash\Decode);
            $console->add(new \League\Geotools\CLI\Convert\DM);
            $console->add(new \League\Geotools\CLI\Convert\DMS);
            $console->add(new \League\Geotools\CLI\Convert\UTM);
            $console->add(new \League\Geotools\CLI\Geocoder\Geocode);
            $console->add(new \League\Geotools\CLI\Geocoder\Reverse);

            return $console;
        }));
    }
}

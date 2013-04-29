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
    }

    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
    }
}

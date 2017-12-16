<?php

namespace pxgamer\U232ToUnit3d\Functionality;

use Orchestra\Testbench\TestCase;
use pxgamer\U232ToUnit3d\ServiceProvider;

/**
 * Class ServiceProviderTest.
 */
class ServiceProviderTest extends TestCase
{
    /**
     * Test able to load aggregate service providers.
     */
    public function testServiceIsAvailable()
    {
        $loaded = $this->app->getLoadedProviders();

        $this->assertArrayHasKey(ServiceProvider::class, $loaded);
        $this->assertTrue($loaded[ServiceProvider::class]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}

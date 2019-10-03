<?php

namespace pxgamer\U232ToUnit3d\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Application;
use pxgamer\U232ToUnit3d\ServiceProvider;

class ServiceProviderTest extends TestCase
{
    /** @test Test able to load aggregate service providers. */
    public function testServiceIsAvailable(): void
    {
        $loaded = $this->app->getLoadedProviders();

        $this->assertArrayHasKey(ServiceProvider::class, $loaded);
        $this->assertTrue($loaded[ServiceProvider::class]);
    }

    /**
     * @param  Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }
}

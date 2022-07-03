<?php

namespace Benjaminhu\LaravelAppDebugDynamic\Tests;

use Benjaminhu\LaravelAppDebugDynamic\AppDebugDynamicServiceProvider;
use Orchestra\Testbench\TestCase;

class AppDebugDynamicServiceProviderTest extends TestCase
{
    /**
     * @var AppDebugDynamicServiceProvider|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private mixed $serviceMock;

    public function setUp():void
    {
//        parent::setUp();
//        $this->serviceMock = $this->createMock(AppDebugDynamicServiceProvider::class);
        $this->serviceMock = $this->getMockBuilder(AppDebugDynamicServiceProvider::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['publishes', 'mergeConfigFrom'])
            ->getMock();
    }

    public function testBoot(): void
    {
        $configFrom = realpath(__DIR__ . '/../src/') . '/../config/app-debug-dynamic.php';
        $configTo = config_path('app-debug-dynamic.php');
        $this->serviceMock->expects($this->once())
            ->method('publishes')
            ->with(
                [$configFrom => $configTo],
                'config'
            );
        $this->serviceMock->boot();
    }

    public function testRegister(): void
    {
        $configFrom = realpath(__DIR__ . '/../src/') . '/../config/app-debug-dynamic.php';
        $this->serviceMock->expects($this->once())
            ->method('mergeConfigFrom')
            ->with(
                $configFrom,
                'laravel-app-debug-dynamic'
        );
        $this->serviceMock->register();
    }
}

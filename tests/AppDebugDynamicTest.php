<?php

namespace Benjaminhu\LaravelAppDebugDynamic\Tests;

use Benjaminhu\LaravelAppDebugDynamic\Facades\AppDebugDynamic;
use Orchestra\Testbench\TestCase;

class AppDebugDynamicTest extends TestCase
{
    public function testGetFacacdeAccessor(): void
    {
        $expected = 'laravel-app-debug-dynamic';
        $this->assertEquals($expected, AppDebugDynamic::getFacacdeAccessor());
    }
}

<?php

namespace Benjaminhu\LaravelAppDebugDynamic\Tests;

use Benjaminhu\LaravelAppDebugDynamic\AppDebugDynamicMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;

class AppDebugDynamicMiddlewareTest extends TestCase
{
    private string $defaultCookieName = 'defaultCookie';
    private string $defaultSecret = 'ZPtOnGuqy53q';
    private array $defaultAllowedIps = ['1.2.3.99', '1.2.3.4'];

    private string $cookieName;
    private string $cookieSecret;

    private Request $request;

    public function setUp():void
    {
        parent::setUp();

        Config::set('app.debug', false);

        $this->cookieName = $this->defaultCookieName;
        Config::set('app-debug-dynamic.cookie_name', $this->cookieName);

        $this->cookieSecret = $this->defaultSecret;
        Config::set('app-debug-dynamic.cookie_secret', $this->cookieSecret);
    }

    private function createRequest($cookies = [], $server = [])
    {
        $this->request = new Request([], [], [], $cookies, [], $server);
    }

    private function getCookies(): array
    {
        return [
            $this->cookieName => $this->cookieSecret
        ];
    }

    /**
     * Test 'app.debug' switch to 'true'
     *
     * @return void
     */
    public function testAppDebugDynamicOn(): void
    {
        $this->createRequest($this->getCookies());
        $this->assertAppDebug(true);
    }

    /**
     * Test cookie not set
     *
     * @return void
     */
    public function testAppDebugDynamicCookieNotSet(): void
    {
        $this->createRequest();
        $this->assertAppDebug(false);
    }

    /**
     * Test cookie value wrong
     *
     * @return void
     */
    public function testAppDebugDynamicCookieValueWrong(): void
    {
        $cookies = $this->getCookies();
        $cookies[$this->defaultCookieName] .= 'a';
        $this->createRequest($cookies);
        $this->assertAppDebug(false);
    }

    /**
     * Test cookie value empty
     *
     * @return void
     */
    public function testAppDebugDynamicCookieEmpty(): void
    {
        $cookies = $this->getCookies();
        $cookies[$this->defaultCookieName] = '';
        $this->createRequest($cookies);
        $this->assertAppDebug(false);
    }

    /**
     * Test 'app.debug' switch to 'true'
     *
     * @return void
     */
    public function testAppDebugDynamicOnWithIp(): void
    {
        Config::set('app-debug-dynamic.allowed_ips', $this->defaultAllowedIps);
        $server = [
            'REMOTE_ADDR' => '1.2.3.4',
        ];
        $this->createRequest($this->getCookies(), $server);
        $this->assertAppDebug(true);
    }

    private function assertAppDebug(bool $expected)
    {
        $middleware = new AppDebugDynamicMiddleware();
        $middleware->handle($this->request, static function() {});
        $this->assertEquals($expected, Config::get('app.debug'));
    }
}

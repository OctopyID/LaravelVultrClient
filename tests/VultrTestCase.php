<?php

namespace Octopy\Vultr\Tests;

use Exception;
use Throwable;
use Octopy\Vultr\Client;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;
use Octopy\Vultr\ServiceProvider;
use Octopy\Vultr\Api\AbstractApi;
use Illuminate\Foundation\Application;
use Octopy\Vultr\Adapter\AdapterInterface;

/**
 * @method fakeResponse()
 */
class VultrTestCase extends TestCase
{
	/**
	 * @var Client
	 */
	protected Client $vultr;

	/**
	 * @return void
	 */
	public function setUp() : void
	{
		parent::setUp();
		$this->vultr = new Client('', $this->mock(AdapterInterface::class));
	}

	/**
	 * @param  Application $app
	 * @return string[]
	 * @noinspection PhpMissingParamTypeInspection
	 */
	protected function getPackageProviders($app) : array
	{
		return [ServiceProvider::class];
	}

	/**
	 * @return AdapterInterface|MockInterface
	 * @throws Throwable
	 */
	protected function fakeRequest() : AdapterInterface|MockInterface
	{
		throw_unless($this instanceof HasFakeResponse, new Exception(
			__CLASS__ . ' should implement with HasFakeResponse interface.'
		));

		return $this->mock(AdapterInterface::class, function (MockInterface $mock) {
			$mock->shouldReceive('get')->andReturn($this->fakeResponse());
		});
	}

	/**
	 * @param  AbstractApi|string $api
	 * @return mixed
	 * @throws Throwable
	 */
	protected function api(AbstractApi|string $api) : mixed
	{
		if (is_string($api)) {
			return new $api($this->fakeRequest());
		}

		return $api;
	}
}

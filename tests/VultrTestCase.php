<?php

namespace Octopy\Vultr\Tests;

use Octopy\Vultr\Client;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;
use Octopy\Vultr\ServiceProvider;
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
	 * @param  array $data
	 * @return AdapterInterface|MockInterface
	 */
	protected function adapter(array $data = []) : AdapterInterface|MockInterface
	{
		return $this->mock(AdapterInterface::class, function (MockInterface $mock) use ($data) {
			$mock->shouldReceive([
				'query' => $mock,
				'get'   => $data,
			]);
		});
	}

	/**
	 * @param  string|array $data
	 * @return array
	 */
	protected function decodeJSON(string|array $data) : array
	{
		if (is_string($data)) {
			return json_decode(file_get_contents(
				__DIR__ . '/Unit/data/' . $data
			), true);
		}

		return $data;
	}
}

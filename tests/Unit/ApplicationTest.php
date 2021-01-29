<?php

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\Application;
use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Tests\HasFakeResponse;
use Octopy\Vultr\Handler\ApplicationHandler;

class ApplicationTest extends VultrTestCase implements HasFakeResponse
{
	/**
	 * @return void
	 */
	public function testAccount()
	{
		$this->assertInstanceOf(Application::class, $this->vultr->application);
	}

	/**
	 * @return void
	 * @throws Throwable
	 */
	public function testGetAccountInfo()
	{
		$fake = $this->fakeResponse('applications');
		$apps = $this->api(Application::class)->getLists();

		$this->assertInstanceOf(ApplicationHandler::class, $apps);

		$this->assertEquals($apps->toArray(), $fake);

		$this->assertInstanceOf(ApplicationHandler::class, $apps->first());

		$this->assertEquals($fake[2], $apps->last()->toArray());
		$this->assertEquals($fake[0], $apps->first()->toArray());

		$this->assertSame($fake[0]['short_name'], $apps->first()->shortName);
		$this->assertSame($fake[0]['short_name'], $apps->first()->short_name);
	}

	/**
	 * @param  string|null $name
	 * @return array[]
	 */
	public function fakeResponse(string|null $name = null) : array
	{
		$array = [
			'applications' => [
				[
					'id'          => 2,
					'name'        => 'WordPress',
					'short_name'  => 'wordpress',
					'deploy_name' => 'WordPress on Ubuntu 18.04 x64',
				],
				[
					'id'          => 6,
					'name'        => 'OpenVPN',
					'short_name'  => 'openvpn',
					'deploy_name' => 'OpenVPN on Ubuntu 18.04 x64',
				],
				[
					'id'          => 17,
					'name'        => 'Docker',
					'short_name'  => 'docker',
					'deploy_name' => 'Docker on CentOS 7 x64',
				],
			],
		];

		return $array[$name] ?? $array;
	}
}

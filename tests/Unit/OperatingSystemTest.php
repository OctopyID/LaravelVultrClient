<?php

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Api\OperatingSystemApi;
use Octopy\Vultr\Entity\OperatingSystem;

class OperatingSystemTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testOperatingSystem()
	{
		$this->assertInstanceOf(OperatingSystemApi::class, $this->vultr->operatingSystem);
	}

	/**
	 * @return void
	 * @throws Throwable
	 */
	public function testGetApplications()
	{
		$mock = new OperatingSystemApi($this->adapter(
			$data = $this->decodeJSON('operating-system.json')
		));

		$fake = $mock->listImages();

		$this->assertInstanceOf(OperatingSystem::class, $fake);

		$this->assertEquals($fake->toArray(), $data['os']);

		$this->assertInstanceOf(OperatingSystem::class, $fake->first());

		$this->assertEquals($data['os'][2], $fake->last()->toArray());
		$this->assertEquals($data['os'][0], $fake->first()->toArray());

		$this->assertSame($data['os'][0]['name'], $fake->first()->name);
	}
}

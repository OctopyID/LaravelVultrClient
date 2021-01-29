<?php

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Api\OperatingSystem;
use Octopy\Vultr\Handler\OperatingSystemHandler;

class OperatingSystemTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testApplication()
	{
		$this->assertInstanceOf(OperatingSystem::class, $this->vultr->operatingSystem);
	}

	/**
	 * @return void
	 * @throws Throwable
	 */
	public function testGetApplications()
	{
		$mock = new OperatingSystem($this->adapter(
			$data = $this->decodeJSON('operating-system.json')
		));

		$fake = $mock->listImages();

		$this->assertInstanceOf(OperatingSystemHandler::class, $fake);

		$this->assertEquals($fake->toArray(), $data['os']);

		$this->assertInstanceOf(OperatingSystemHandler::class, $fake->first());

		$this->assertEquals($data['os'][2], $fake->last()->toArray());
		$this->assertEquals($data['os'][0], $fake->first()->toArray());

		$this->assertSame($data['os'][0]['name'], $fake->first()->name);
	}
}

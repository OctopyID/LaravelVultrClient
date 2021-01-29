<?php

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\Application;
use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Handler\ApplicationHandler;

class ApplicationTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testApplication()
	{
		$this->assertInstanceOf(Application::class, $this->vultr->application);
	}

	/**
	 * @return void
	 * @throws Throwable
	 */
	public function testGetApplications()
	{
		$mock = new Application($this->adapter(
			$data = $this->decodeJSON('applications.json')
		));

		$fake = $mock->listApplications();

		$this->assertInstanceOf(ApplicationHandler::class, $fake);

		$this->assertEquals($fake->toArray(), $data['applications']);

		$this->assertInstanceOf(ApplicationHandler::class, $fake->first());

		$this->assertEquals($data['applications'][2], $fake->last()->toArray());
		$this->assertEquals($data['applications'][0], $fake->first()->toArray());

		$this->assertSame($data['applications'][0]['short_name'], $fake->first()->shortName);
		$this->assertSame($data['applications'][0]['short_name'], $fake->first()->short_name);
	}
}

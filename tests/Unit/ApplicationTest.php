<?php

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\ApplicationApi;
use Octopy\Vultr\Entity\Application;
use Octopy\Vultr\Tests\VultrTestCase;

class ApplicationTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testApplication()
	{
		$this->assertInstanceOf(ApplicationApi::class, $this->vultr->application);
	}

	/**
	 * @return void
	 * @throws Throwable
	 */
	public function testListApplications()
	{
		$mock = new ApplicationApi($this->adapter(
			$data = $this->decodeJSON('application.json')
		));

		$fake = $mock->listApplications();

		$this->assertInstanceOf(Application::class, $fake);

		$this->assertEquals($fake->toArray(), $data['applications']);

		$this->assertInstanceOf(Application::class, $fake->first());

		$this->assertEquals($data['applications'][2], $fake->last()->toArray());
		$this->assertEquals($data['applications'][0], $fake->first()->toArray());

		$this->assertSame($data['applications'][0]['short_name'], $fake->first()->shortName);
		$this->assertSame($data['applications'][0]['short_name'], $fake->first()->short_name);
	}
}

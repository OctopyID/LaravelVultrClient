<?php

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\Region;
use Illuminate\Support\Collection;
use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Handler\RegionHandler;

class RegionTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testRegion()
	{
		$this->assertInstanceOf(Region::class, $this->vultr->region);
	}

	/**
	 * @throws Throwable
	 */
	public function testListRegions()
	{
		$mock = new Region($this->adapter(
			$data = $this->decodeJSON('regions/region.json')
		));

		$fake = $mock->listRegions();

		$this->assertInstanceOf(RegionHandler::class, $fake);

		$this->assertEquals($data['regions'][0], $fake->first()->toArray());

		$this->assertSame($data['regions'][0]['continent'], $fake->first()->continent);
	}

	/**
	 * @throws Throwable
	 */
	public function testListAvailableComputeInRegion()
	{
		$mock = new Region($this->adapter(
			$data = [
				'available_plans' => [
					"vc2-1c-1gb",
					"vc2-1c-2gb",
					"vc2-2c-4gb",
				],
			]
		));

		$this->assertInstanceOf(Collection::class, $mock->listAvailableComputeInRegion('ams'));
	}
}

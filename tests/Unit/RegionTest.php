<?php

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\RegionApi;
use Octopy\Vultr\Entity\Region;
use Illuminate\Support\Collection;
use Octopy\Vultr\Tests\VultrTestCase;

class RegionTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testRegion()
	{
		$this->assertInstanceOf(RegionApi::class, $this->vultr->region);
	}

	/**
	 * @throws Throwable
	 */
	public function testListRegions()
	{
		$mock = new RegionApi($this->adapter(
			$data = $this->decodeJSON('regions/region.json')
		));

		$fake = $mock->listRegions();

		$this->assertInstanceOf(Region::class, $fake);

		$this->assertEquals($data['regions'][0], $fake->first()->toArray());

		$this->assertSame($data['regions'][0]['continent'], $fake->first()->continent);
	}

	/**
	 * @throws Throwable
	 */
	public function testListAvailableComputeInRegion()
	{
		$mock = new RegionApi($this->adapter(
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

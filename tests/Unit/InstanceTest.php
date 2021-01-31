<?php

namespace Octopy\Vultr\Tests\Unit;

use Octopy\Vultr\Api\InstanceApi;
use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Entity\Instance\Instance;

class InstanceTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testInstance()
	{
		$this->assertInstanceOf(InstanceApi::class, $this->vultr->instance);
	}

	/**
	 * @return void
	 */
	public function testListInstances()
	{
		$mock = new InstanceApi($this->adapter(
			$data = $this->decodeJSON('instances/list.json')
		));

		$fake = $mock->listInstances();

		$this->assertInstanceOf(Instance::class, $fake);

		$this->assertEquals($fake->toArray(), $data['instances']);

		$this->assertInstanceOf(Instance::class, $fake->first());

		$this->assertSame($data['instances'][0]['ram'], $fake->first()->ram);
	}
}

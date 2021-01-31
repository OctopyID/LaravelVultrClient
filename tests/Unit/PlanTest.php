<?php

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\PlanApi;
use Octopy\Vultr\Entity\Plan;
use Octopy\Vultr\Entity\BareMetal;
use Octopy\Vultr\Tests\VultrTestCase;

class PlanTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testPlan()
	{
		$this->assertInstanceOf(PlanApi::class, $this->vultr->plan);
	}

	/**
	 * @throws Throwable
	 */
	public function testPlans()
	{
		$mock = new PlanApi($this->adapter(
			$data = $this->decodeJSON('plans/plan.json')
		));

		$fake = $mock->listPlans();

		$this->assertInstanceOf(Plan::class, $mock->listHighFrequencyPlans());
		$this->assertInstanceOf(Plan::class, $mock->listCloudComputePlans());
		$this->assertInstanceOf(Plan::class, $mock->listDedicatedCloudPlans());

		$this->assertEquals($data['plans'][0], $fake->first()->toArray());

		$this->assertSame($data['plans'][0]['monthly_cost'], $fake->first()->monthlyCost);
		$this->assertSame($data['plans'][0]['monthly_cost'], $fake->first()->monthly_cost);
	}

	/**
	 * @return  void
	 */
	public function testBareMetals()
	{
		$mock = new PlanApi($this->adapter(
			$data = $this->decodeJSON('plans/bare-metal.json')
		));

		$this->assertInstanceOf(BareMetal::class, $fake = $mock->listBareMetalPlans());

		$this->assertEquals($data['plans_metal'][0], $fake->first()->toArray());

		$this->assertSame($data['plans_metal'][0]['cpu_model'], $fake->first()->cpuModel);
		$this->assertSame($data['plans_metal'][0]['cpu_model'], $fake->first()->cpu_model);
	}
}

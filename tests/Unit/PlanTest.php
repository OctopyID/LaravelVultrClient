<?php

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\Plan;
use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Handler\PlanHandler;
use Octopy\Vultr\Handler\BareMetalPlanHandler;

class PlanTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testPlan()
	{
		$this->assertInstanceOf(Plan::class, $this->vultr->plan);
	}

	/**
	 * @throws Throwable
	 */
	public function testPlans()
	{
		$mock = new Plan($this->adapter(
			$data = $this->decodeJSON('plans/plan.json')
		));

		$fake = $mock->listPlans();

		$this->assertInstanceOf(PlanHandler::class, $mock->listHighComputePlans());
		$this->assertInstanceOf(PlanHandler::class, $mock->listCloudComputePlans());
		$this->assertInstanceOf(PlanHandler::class, $mock->listDedicatedCloudPlans());

		$this->assertEquals($data['plans'][0], $fake->first()->toArray());

		$this->assertSame($data['plans'][0]['monthly_cost'], $fake->first()->monthlyCost);
		$this->assertSame($data['plans'][0]['monthly_cost'], $fake->first()->monthly_cost);
	}

	/**
	 * @return  void
	 */
	public function testBareMetals()
	{
		$mock = new Plan($this->adapter(
			$data = $this->decodeJSON('plans/bare-metal.json')
		));

		$this->assertInstanceOf(BareMetalPlanHandler::class, $fake = $mock->listBareMetalPlans());

		$this->assertEquals($data['plans_metal'][0], $fake->first()->toArray());

		$this->assertSame($data['plans_metal'][0]['cpu_model'], $fake->first()->cpuModel);
		$this->assertSame($data['plans_metal'][0]['cpu_model'], $fake->first()->cpu_model);
	}
}

<?php
/** @noinspection PhpUnused */

namespace Octopy\Vultr\Api;

use Exception;
use Throwable;
use Octopy\Vultr\Handler\PlanHandler;
use Octopy\Vultr\Handler\BareMetalPlanHandler;

class Plan extends AbstractApi
{
	/**
	 * @return PlanHandler
	 * @throws Throwable
	 */
	public function getCloudComputes() : PlanHandler
	{
		return $this->listPlans('vc2');
	}

	/**
	 * @return PlanHandler
	 * @throws Throwable
	 */
	public function getHighComputes() : PlanHandler
	{
		return $this->listPlans('vhf');
	}

	/**
	 * @return PlanHandler
	 * @throws Throwable
	 */
	public function getDedicatedClouds() : PlanHandler
	{
		return $this->listPlans('vdc');
	}

	/**
	 * @param  string $type
	 * @return PlanHandler|BareMetalPlanHandler
	 * @throws Throwable
	 */
	public function listPlans(string $type = 'all') : PlanHandler|BareMetalPlanHandler
	{
		if ($type === 'metal') {
			return $this->listBareMetalPlans();
		}

		$types = [
			'all', 'vc2', 'vhf', 'vdc',
		];

		throw_unless(in_array($type, $types, true), new Exception(
			'Unknown type, the allowed type is ' . implode(', ', $types)
		));

		return new PlanHandler(
			$this->adapter->get('plans', compact('type'))
		);
	}

	/**
	 * @return BareMetalPlanHandler
	 */
	public function listBareMetalPlans() : BareMetalPlanHandler
	{
		return new BareMetalPlanHandler(
			$this->adapter->get('plans-metal')
		);
	}
}

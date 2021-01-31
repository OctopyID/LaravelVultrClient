<?php
/** @noinspection PhpUnused */

namespace Octopy\Vultr\Api;

use Exception;
use Throwable;
use Octopy\Vultr\Entity\Plan;
use Octopy\Vultr\Entity\BareMetal;
use Octopy\Vultr\Api\Contracts\Plan as PlanContract;

class PlanApi extends AbstractApi implements PlanContract
{
	/**
	 * @return Plan
	 * @throws Throwable
	 */
	public function listCloudComputePlans() : Plan
	{
		return $this->listPlans(PlanContract::CLOUD_COMPUTE);
	}

	/**
	 * @return Plan
	 * @throws Throwable
	 */
	public function listHighFrequencyPlans() : Plan
	{
		return $this->listPlans(PlanContract::HIGH_FREQUENCY);
	}

	/**
	 * @return Plan
	 * @throws Throwable
	 */
	public function listDedicatedCloudPlans() : Plan
	{
		return $this->listPlans(PlanContract::CLOUD_COMPUTE);
	}

	/**
	 * @param  string $type
	 * @return Plan|BareMetal
	 * @throws Throwable
	 */
	public function listPlans(string $type = 'all') : Plan|BareMetal
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

		return new Plan(
			$this->adapter->get('plans', compact('type'))
		);
	}

	/**
	 * @return BareMetal
	 */
	public function listBareMetalPlans() : BareMetal
	{
		return new BareMetal(
			$this->adapter->get('plans-metal')
		);
	}
}

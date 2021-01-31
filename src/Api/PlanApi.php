<?php
/** @noinspection PhpUnused */

namespace Octopy\Vultr\Api;

use Throwable;
use Octopy\Vultr\Entity\Plan;
use Octopy\Vultr\Entity\BareMetal;
use Octopy\Vultr\Api\Support\Plan as Support;

class PlanApi extends AbstractApi
{
	/**
	 * @return Plan
	 * @throws Throwable
	 */
	public function listCloudComputePlans() : Plan
	{
		return $this->listPlans(Support::CLOUD_COMPUTE);
	}

	/**
	 * @return Plan
	 * @throws Throwable
	 */
	public function listHighFrequencyPlans() : Plan
	{
		return $this->listPlans(Support::HIGH_FREQUENCY);
	}

	/**
	 * @return Plan
	 * @throws Throwable
	 */
	public function listDedicatedCloudPlans() : Plan
	{
		return $this->listPlans(Support::CLOUD_COMPUTE);
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

		Support::except(Support::BARE_METAL)->validate($type);

		return new Plan(
			$this->adapter()->get('plans', compact('type'))
		);
	}

	/**
	 * @return BareMetal
	 */
	public function listBareMetalPlans() : BareMetal
	{
		return new BareMetal(
			$this->adapter()->get('plans-metal')
		);
	}
}

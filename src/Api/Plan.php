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
	 * @param  string $type
	 * @return PlanHandler|BareMetalPlanHandler
	 * @throws Throwable
	 */
	public function get(string $type) : PlanHandler|BareMetalPlanHandler
	{
		if ($type === 'metal') {
			return $this->getBareMetals();
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
	 * @return PlanHandler
	 * @throws Throwable
	 */
	public function all() : PlanHandler
	{
		return $this->get('all');
	}

	/**
	 * @return PlanHandler
	 * @throws Throwable
	 */
	public function getCloudComputes() : PlanHandler
	{
		return $this->get('vc2');
	}

	/**
	 * @return PlanHandler
	 * @throws Throwable
	 */
	public function getHighComputes() : PlanHandler
	{
		return $this->get('vhf');
	}

	/**
	 * @return PlanHandler
	 * @throws Throwable
	 */
	public function getDedicatedClouds() : PlanHandler
	{
		return $this->get('vdc');
	}

	/**
	 * @return BareMetalPlanHandler
	 */
	public function getBareMetals() : BareMetalPlanHandler
	{
		return new BareMetalPlanHandler(
			$this->adapter->get('plans-metal')
		);
	}
}

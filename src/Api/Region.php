<?php

namespace Octopy\Vultr\Api;

use Exception;
use Throwable;
use Illuminate\Support\Collection;
use Octopy\Vultr\Handler\RegionHandler;

class Region extends AbstractApi
{
	/**
	 * @return RegionHandler
	 */
	public function listRegions() : RegionHandler
	{
		return new RegionHandler(
			$this->adapter->get('regions')
		);
	}

	/**
	 * @param  string $region
	 * @param  string $type
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableComputeInRegion(string $region, string $type = 'all') : Collection
	{
		$types = [
			'all', 'vc2', 'vhf', 'vdc', 'vbm',
		];

		throw_unless(in_array($type, $types, true), new Exception(
			'Unknown type, the allowed type is ' . implode(', ', $types)
		));

		$result = $this->adapter->get('/regions/' . $region . '/availability', compact('type'));

		return collect(
			$result['available_plans']
		);
	}

	/**
	 * @param  string $region
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableCloudCompute(string $region) : Collection
	{
		return $this->listAvailableComputeInRegion($region, 'vc2');
	}

	/**
	 * @param  string $region
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableHighCompute(string $region) : Collection
	{
		return $this->listAvailableComputeInRegion($region, 'vhf');
	}

	/**
	 * @param  string $region
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableDedicatedCloud(string $region) : Collection
	{
		return $this->listAvailableComputeInRegion($region, 'vdc');
	}

	/**
	 * @param  string $region
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableBareMetal(string $region) : Collection
	{
		return $this->listAvailableComputeInRegion($region, 'vbm');
	}
}

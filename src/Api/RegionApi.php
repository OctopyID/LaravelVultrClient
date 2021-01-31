<?php

/** @noinspection PhpUnused */

namespace Octopy\Vultr\Api;

use Closure;
use Throwable;
use Exception;
use Octopy\Vultr\Relation;
use Octopy\Vultr\Entity\Region;
use Illuminate\Support\Collection;
use Octopy\Vultr\Api\Contracts\Plan;
use Octopy\Vultr\Entity\AbstractEntity;

class RegionApi extends AbstractApi implements Plan
{
	/**
	 * @return Region|AbstractEntity
	 */
	public function listRegions() : Region|AbstractEntity
	{
		return $this->handle(new Region(
			$this->adapter->get('regions')
		));
	}

	/**
	 * @param  string $id
	 * @param  string $type
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableComputeInRegion(string $id, string $type = 'all') : Collection
	{
		$types = [
			'all', 'vc2', 'vhf', 'vdc', 'vbm',
		];

		throw_unless(in_array($type, $types, true), new Exception(
			'Unknown type, the allowed type is ' . implode(', ', $types)
		));

		$result = $this->adapter->get('/regions/' . $id . '/availability', compact('type'));

		return collect($result['available_plans']);
	}

	/**
	 * @param  string $id
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableCloudCompute(string $id) : Collection
	{
		return $this->listAvailableComputeInRegion($id, Plan::CLOUD_COMPUTE);
	}

	/**
	 * @param  string $id
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableHighFrequency(string $id) : Collection
	{
		return $this->listAvailableComputeInRegion($id, Plan::HIGH_FREQUENCY);
	}

	/**
	 * @param  string $id
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableDedicatedCloud(string $id) : Collection
	{
		return $this->listAvailableComputeInRegion($id, Plan::DEDICATED_CLOUD);
	}

	/**
	 * @param  string $id
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableBareMetal(string $id) : Collection
	{
		return $this->listAvailableComputeInRegion($id, Plan::BARE_METAL);
	}

	/**
	 * @param  string       $type
	 * @param  Closure|null $callback
	 * @param  string       $alias
	 * @return RegionApi
	 */
	public function withAvailableComputeInRegion(string $type = 'all', Closure|null $callback = null, string $alias = 'plans') : RegionApi
	{
		return $this->with([
			'listAvailableComputeInRegion' => function (Relation $relation) use ($type, $alias, $callback) {
				$relation->alias($alias);

				$relation->where([
					'type' => $type,
				]);

				if (! is_null($callback)) {
					$relation->result($callback);
				}
			},
		]);
	}

	/**
	 * @param  Closure|null $callback
	 * @param  string       $alias
	 * @return RegionApi
	 */
	public function withAvailableCloudCompute(Closure|null $callback = null, string $alias = 'plans') : RegionApi
	{
		return $this->withAvailableComputeInRegion(Plan::CLOUD_COMPUTE, $callback, $alias);
	}

	/**
	 * @param  Closure|null $callback
	 * @param  string       $alias
	 * @return RegionApi
	 */
	public function withAvailableHighFrequency(Closure|null $callback = null, string $alias = 'plans') : RegionApi
	{
		return $this->withAvailableComputeInRegion(Plan::HIGH_FREQUENCY, $callback, $alias);
	}

	/**
	 * @param  Closure|null $callback
	 * @param  string       $alias
	 * @return RegionApi
	 */
	public function withAvailableDedicatedCloud(Closure|null $callback = null, string $alias = 'plans') : RegionApi
	{
		return $this->withAvailableComputeInRegion(Plan::DEDICATED_CLOUD, $callback, $alias);
	}

	/**
	 * @param  Closure|null $callback
	 * @param  string       $alias
	 * @return RegionApi
	 */
	public function withAvailableBareMetal(Closure|null $callback = null, string $alias = 'plans') : RegionApi
	{
		return $this->withAvailableComputeInRegion(Plan::BARE_METAL, $callback, $alias);
	}
}

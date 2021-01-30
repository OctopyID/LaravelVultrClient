<?php

namespace Octopy\Vultr\Api;

use Closure;
use Throwable;
use Exception;
use Octopy\Vultr\Relation;
use Illuminate\Support\Collection;
use Octopy\Vultr\Handler\RegionHandler;
use Octopy\Vultr\Handler\AbstractHandler;

class Region extends AbstractApi
{
	/**
	 * @const string
	 */
	public const ALL = 'all';

	/**
	 * @const string
	 */
	public const BARE_METAL = 'vbm';

	/**
	 * @const string
	 */
	public const CLOUD_COMPUTE = 'vc2';

	/**
	 * @const string
	 */
	public const HIGH_FREQUENCY = 'vhf';

	/**
	 * @const string
	 */
	public const DEDICATED_CLOUD = 'vdc';

	/**
	 * @return RegionHandler|AbstractHandler
	 */
	public function listRegions() : RegionHandler|AbstractHandler
	{
		return $this->handle(new RegionHandler(
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

		return collect(
			$result['available_plans']
		);
	}

	/**
	 * @param  string $id
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableCloudCompute(string $id) : Collection
	{
		return $this->listAvailableComputeInRegion($id, 'vc2');
	}

	/**
	 * @param  string $id
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableHighCompute(string $id) : Collection
	{
		return $this->listAvailableComputeInRegion($id, 'vhf');
	}

	/**
	 * @param  string $id
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableDedicatedCloud(string $id) : Collection
	{
		return $this->listAvailableComputeInRegion($id, 'vdc');
	}

	/**
	 * @param  string $id
	 * @return Collection
	 * @throws Throwable
	 */
	public function listAvailableBareMetal(string $id) : Collection
	{
		return $this->listAvailableComputeInRegion($id, 'vbm');
	}

	/**
	 * @param  string       $type
	 * @param  Closure|null $callback
	 * @param  string       $alias
	 * @return Region
	 */
	public function withAvailableComputeInRegion(string $type = 'all', Closure|null $callback = null, string $alias = 'plans') : Region
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
	 * @return Region
	 */
	public function withAvailableCloudCompute(Closure|null $callback = null, string $alias = 'plans') : Region
	{
		return $this->withAvailableComputeInRegion(Region::CLOUD_COMPUTE, $callback, $alias);
	}

	/**
	 * @param  Closure|null $callback
	 * @param  string       $alias
	 * @return Region
	 */
	public function withAvailableHighCompute(Closure|null $callback = null, string $alias = 'plans') : Region
	{
		return $this->withAvailableComputeInRegion(Region::HIGH_FREQUENCY, $callback, $alias);
	}

	/**
	 * @param  Closure|null $callback
	 * @param  string       $alias
	 * @return Region
	 */
	public function withAvailableDedicatedCloud(Closure|null $callback = null, string $alias = 'plans') : Region
	{
		return $this->withAvailableComputeInRegion(Region::DEDICATED_CLOUD, $callback, $alias);
	}

	/**
	 * @param  Closure|null $callback
	 * @param  string       $alias
	 * @return Region
	 */
	public function withAvailableBareMetal(Closure|null $callback = null, string $alias = 'plans') : Region
	{
		return $this->withAvailableComputeInRegion(Region::BARE_METAL, $callback, $alias);
	}
}

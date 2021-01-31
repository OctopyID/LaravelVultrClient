<?php

namespace Octopy\Vultr;

use Octopy\Vultr\Api\PlanApi;
use Octopy\Vultr\Api\RegionApi;
use Octopy\Vultr\Api\AccountApi;
use Octopy\Vultr\Api\InstanceApi;
use Octopy\Vultr\Api\ApplicationApi;
use Illuminate\Support\Facades\Facade;
use Octopy\Vultr\Api\OperatingSystemApi;

/**
 * @method static noCache()
 * @method static cache(int $minutes)
 * @method static token(string $token)
 * @method static |AccountApi account()
 * @method static |ApplicationApi application()
 * @method static |PlanApi plan()
 * @method static |OperatingSystemApi operatingSystem()
 * @method static |RegionApi region()
 * @method static |InstanceApi instance()
 */
class Vultr extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor() : string
	{
		return Client::class;
	}
}

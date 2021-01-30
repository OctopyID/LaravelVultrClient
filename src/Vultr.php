<?php

namespace Octopy\Vultr;

use Octopy\Vultr\Api\Plan;
use Octopy\Vultr\Api\Region;
use Octopy\Vultr\Api\Account;
use Octopy\Vultr\Api\Application;
use Octopy\Vultr\Api\OperatingSystem;
use Illuminate\Support\Facades\Facade;

/**
 * @method static noCache()
 * @method static cache(int $minutes)
 * @method static token(string $token)
 * @method static |Account account()
 * @method static |Application application()
 * @method static |Plan plan()
 * @method static |OperatingSystem operatingSystem()
 * @method static |Region region()
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

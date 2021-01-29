<?php

namespace Octopy\Vultr;

use Octopy\Vultr\Api\Account;
use Octopy\Vultr\Api\Application;
use Illuminate\Support\Facades\Facade;

/**
 * @method static noCache()
 * @method static cache(int $minutes)
 * @method static token(string $token)
 * @method Account account()
 * @method Application application()
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

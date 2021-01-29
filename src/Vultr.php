<?php

namespace Octopy\Vultr;

use Illuminate\Support\Facades\Facade;

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

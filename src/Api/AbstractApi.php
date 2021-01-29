<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Adapter\AdapterInterface;

abstract class AbstractApi
{
	/**
	 * AbstractApi constructor.
	 * @param  AdapterInterface $adapter
	 */
	public function __construct(protected AdapterInterface $adapter)
	{
	}
}

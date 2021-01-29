<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Handler\OperatingSystemHandler;

class OperatingSystem extends AbstractApi
{
	/**
	 * @return OperatingSystemHandler
	 */
	public function listImages() : OperatingSystemHandler
	{
		return new OperatingSystemHandler(
			$this->adapter->get('os')
		);
	}
}

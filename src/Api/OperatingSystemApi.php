<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Entity\OperatingSystem;

class OperatingSystemApi extends AbstractApi
{
	/**
	 * @return OperatingSystem
	 */
	public function listImages() : OperatingSystem
	{
		return new OperatingSystem(
			$this->adapter()->get('os')
		);
	}
}

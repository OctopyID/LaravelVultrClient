<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Entity\AbstractEntity;
use Octopy\Vultr\Entity\OperatingSystem;

class OperatingSystemApi extends AbstractApi
{
	/**
	 * @return OperatingSystem|AbstractEntity
	 */
	public function listImages() : OperatingSystem|AbstractEntity
	{
		return $this->handle(new OperatingSystem(
			$this->adapter()->get('os')
		));
	}
}

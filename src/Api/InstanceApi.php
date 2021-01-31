<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Entity\AbstractEntity;
use Octopy\Vultr\Entity\Instance\Instance;

/**
 * @method whereTag(string $tag)
 * @method whereMainIp(string $ip)
 * @method whereLabel(string $label)
 */
class InstanceApi extends AbstractApi
{
	/**
	 * @return Instance|AbstractEntity
	 */
	public function listInstances() : Instance|AbstractEntity
	{
		return $this->handle(new Instance(
			$this->adapter()->get('instances')
		));
	}
}

<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Entity\Application;
use Octopy\Vultr\Entity\AbstractEntity;

class ApplicationApi extends AbstractApi
{
	/**
	 * @return Application
	 */
	public function get() : Application
	{
		return $this->listApplications();
	}

	/**
	 * @return Application|AbstractEntity
	 */
	public function listApplications() : Application|AbstractEntity
	{
		return $this->handle(new Application(
			$this->adapter()->get('applications')
		));
	}
}

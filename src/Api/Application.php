<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Handler\ApplicationHandler;

class Application extends AbstractApi
{
	/**
	 * @return ApplicationHandler
	 */
	public function get() : ApplicationHandler
	{
		return $this->listApplications();
	}

	/**
	 * @return ApplicationHandler
	 */
	public function listApplications() : ApplicationHandler
	{
		return new ApplicationHandler(
			$this->adapter->get('applications')
		);
	}
}

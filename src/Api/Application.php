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
		return $this->getLists();
	}

	/**
	 * @return ApplicationHandler
	 */
	public function getLists() : ApplicationHandler
	{
		return new ApplicationHandler(
			$this->adapter->get('applications')
		);
	}
}

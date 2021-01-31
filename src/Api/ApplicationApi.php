<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Entity\Application;

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
	 * @return Application
	 */
	public function listApplications() : Application
	{
		return new Application(
			$this->adapter()->get('applications')
		);
	}
}

<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Handler\AccountHandler;

class Account extends AbstractApi
{
	/**
	 * @return AccountHandler
	 */
	public function getAccountInfo() : AccountHandler
	{
		return new AccountHandler(
			$this->adapter->get('account')
		);
	}
}

<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Entity\Account;

class AccountApi extends AbstractApi
{
	/**
	 * @return Account
	 */
	public function getAccountInfo() : Account
	{
		return new Account(
			$this->adapter()->get('account')
		);
	}
}

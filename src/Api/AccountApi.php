<?php

namespace Octopy\Vultr\Api;

use Octopy\Vultr\Entity\Account;
use Octopy\Vultr\Entity\AbstractEntity;

class AccountApi extends AbstractApi
{
	/**
	 * @return Account|AbstractEntity
	 */
	public function getAccountInfo() : Account|AbstractEntity
	{
		return $this->handle(new Account(
			$this->adapter()->get('account')
		));
	}
}

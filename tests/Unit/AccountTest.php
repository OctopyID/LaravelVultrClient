<?php

/** @noinspection PhpUndefinedFieldInspection */

/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\AccountApi;
use Octopy\Vultr\Entity\Account;
use Octopy\Vultr\Tests\VultrTestCase;

class AccountTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testAccount()
	{
		$this->assertInstanceOf(AccountApi::class, $this->vultr->account);
	}

	/**
	 * @return void
	 * @throws Throwable
	 */
	public function testGetAccountInfo()
	{
		$mock = new AccountApi($this->adapter(
			$data = $this->decodeJSON('account.json')
		));

		$fake = $mock->getAccountInfo();

		$this->assertInstanceOf(Account::class, $fake);

		$this->assertEquals($fake->toArray(), $data['account']);

		$this->assertEquals($data['account']['last_payment_amount'], $fake->lastPaymentAmount);
		$this->assertEquals($data['account']['last_payment_amount'], $fake->last_payment_amount);
	}
}

<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\Account;
use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Handler\AccountHandler;

class AccountTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testAccount()
	{
		$this->assertInstanceOf(Account::class, $this->vultr->account);
	}

	/**
	 * @return void
	 * @throws Throwable
	 */
	public function testGetAccountInfo()
	{
		$mock = new Account($this->adapter(
			$data = $this->decodeJSON('account.json')
		));

		$fake = $mock->getAccountInfo();

		$this->assertInstanceOf(AccountHandler::class, $fake);

		$this->assertEquals($fake->toArray(), $data['account']);

		$this->assertEquals($data['account']['last_payment_amount'], $fake->lastPaymentAmount);
		$this->assertEquals($data['account']['last_payment_amount'], $fake->last_payment_amount);
	}
}

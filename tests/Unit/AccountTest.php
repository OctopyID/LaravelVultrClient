<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace Octopy\Vultr\Tests\Unit;

use Throwable;
use Octopy\Vultr\Api\Account;
use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Tests\HasFakeResponse;
use Octopy\Vultr\Handler\AccountHandler;

class AccountTest extends VultrTestCase implements HasFakeResponse
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
		$account = $this->api(Account::class)->getAccountInfo();

		$this->assertInstanceOf(AccountHandler::class, $account);

		$this->assertEquals($account->toArray(), $this->fakeResponse());

		$this->assertEquals(-1, $account->last_payment_amount); // Access the property with the snake_case
		$this->assertEquals(-1, $account->lastPaymentAmount); // Access the property with the camelCase
	}

	/**
	 * @return array
	 */
	public function fakeResponse() : array
	{
		return [
			'name'                => 'vultr-api',
			'email'               => 'api@vultr.com',
			'acls'                => [],
			'balance'             => -100,
			'pending_charges'     => 60,
			'last_payment_date'   => '2020-10-10T01=>56=>20+00=>00',
			'last_payment_amount' => -1,
		];
	}
}

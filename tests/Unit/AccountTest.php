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
		$fake = $this->fakeResponse('account');

		$account = $this->api(Account::class)->getAccountInfo();

		$this->assertInstanceOf(AccountHandler::class, $account);

		$this->assertEquals($account->toArray(), $fake);

		$this->assertEquals($fake['last_payment_amount'], $account->lastPaymentAmount); // Access the property with the camelCase
		$this->assertEquals($fake['last_payment_amount'], $account->last_payment_amount); // Access the property with the snake_case
	}

	/**
	 * @param  string|null $name
	 * @return array
	 */
	public function fakeResponse(string|null $name = null) : array
	{
		$array = [
			'account' => [
				'name'                => 'vultr-api',
				'email'               => 'api@vultr.com',
				'acls'                => [],
				'balance'             => -100,
				'pending_charges'     => 60,
				'last_payment_date'   => '2020-06-26T07:39:26+00:00',
				'last_payment_amount' => -1,
			],
		];

		return $array[$name] ?? $array;
	}
}

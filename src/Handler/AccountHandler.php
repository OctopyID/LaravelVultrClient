<?php

namespace Octopy\Vultr\Handler;

/**
 * @property string name
 * @property string email
 * @property array  acls
 * @property int    balance
 * @property int    pendingCharges
 * @property string lastPaymentDate
 * @property int    lastPaymentAmount
 */
final class AccountHandler extends AbstractHandler
{
	/**
	 * @var string
	 */
	protected string $name = 'account';
}

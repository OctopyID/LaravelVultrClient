<?php

namespace Octopy\Vultr\Entity;

/**
 * @property string name
 * @property string email
 * @property array  acls
 * @property int    balance
 * @property int    pendingCharges
 * @property string lastPaymentDate
 * @property int    lastPaymentAmount
 */
final class Account extends AbstractEntity
{
	/**
	 * @var string
	 */
	protected string $name = 'account';
}

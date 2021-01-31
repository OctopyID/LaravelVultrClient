<?php

namespace Octopy\Vultr\Entity;

/**
 * @property string id
 * @property int    vCpuCount
 * @property int    ram
 * @property int    disk
 * @property int    bandwidth
 * @property int    monthlyCost
 * @property string type
 * @property array  locations
 */
class Plan extends AbstractEntity
{
	/**
	 * @var string
	 */
	protected string $name = 'plans';
}

<?php

namespace Octopy\Vultr\Entity;

/**
 * @property string id
 * @property int    cpuCount
 * @property int    cpuThreads
 * @property string cpuModel
 * @property int    ram
 * @property int    disk
 * @property int    bandwidth
 * @property int    monthlyCost
 * @property string type
 * @property array  locations
 */
class BareMetal extends AbstractEntity
{
	/**
	 * @var string
	 */
	protected string $name = 'plans_metal';
}

<?php

namespace Octopy\Vultr\Handler;

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
class PlanHandler extends AbstractHandler
{
	/**
	 * @var string
	 */
	protected string $name = 'plans';
}

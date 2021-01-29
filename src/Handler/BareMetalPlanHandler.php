<?php

namespace Octopy\Vultr\Handler;

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
class BareMetalPlanHandler extends AbstractHandler
{
	/**
	 * @var string
	 */
	protected string $name = 'plans_metal';
}

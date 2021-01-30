<?php

namespace Octopy\Vultr\Handler;

/**
 * @property string id
 * @property string city
 * @property string country
 * @property string continent
 * @property array  options
 */
class RegionHandler extends AbstractHandler
{
	/**
	 * @var string
	 */
	protected string $name = 'regions';
}

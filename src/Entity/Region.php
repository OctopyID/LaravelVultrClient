<?php

namespace Octopy\Vultr\Entity;

/**
 * @property string id
 * @property string city
 * @property string country
 * @property string continent
 * @property array  options
 */
class Region extends AbstractEntity
{
	/**
	 * @var string
	 */
	protected string $name = 'regions';
}

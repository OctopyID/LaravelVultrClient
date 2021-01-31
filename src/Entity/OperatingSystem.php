<?php

namespace Octopy\Vultr\Entity;

/**
 * @property int    id
 * @property string name
 * @property string arch
 * @property string family
 */
class OperatingSystem extends AbstractEntity
{
	/**
	 * @var string
	 */
	protected string $name = 'os';
}

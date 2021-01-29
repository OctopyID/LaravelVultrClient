<?php

namespace Octopy\Vultr\Handler;

/**
 * @property int    id
 * @property string name
 * @property string arch
 * @property string family
 */
class OperatingSystemHandler extends AbstractHandler
{
	/**
	 * @var string
	 */
	protected string $name = 'os';
}

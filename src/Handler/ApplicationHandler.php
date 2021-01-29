<?php

namespace Octopy\Vultr\Handler;

/**
 * @property int    id
 * @property string name
 * @property string shortName
 * @property string deployName
 */
final class ApplicationHandler extends AbstractHandler
{
	/**
	 * @var string
	 */
	protected string $name = 'applications';
}

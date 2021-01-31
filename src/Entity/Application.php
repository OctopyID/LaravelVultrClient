<?php

namespace Octopy\Vultr\Entity;

/**
 * @property int    id
 * @property string name
 * @property string shortName
 * @property string deployName
 */
final class Application extends AbstractEntity
{
	/**
	 * @var string
	 */
	protected string $name = 'applications';
}

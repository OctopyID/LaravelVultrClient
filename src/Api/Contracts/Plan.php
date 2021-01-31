<?php

namespace Octopy\Vultr\Api\Contracts;

interface Plan
{
	/**
	 * @const string
	 */
	public const ALL = 'all';

	/**
	 * @const string
	 */
	public const BARE_METAL = 'vbm';

	/**
	 * @const string
	 */
	public const CLOUD_COMPUTE = 'vc2';

	/**
	 * @const string
	 */
	public const HIGH_FREQUENCY = 'vhf';

	/**
	 * @const string
	 */
	public const DEDICATED_CLOUD = 'vdc';
}

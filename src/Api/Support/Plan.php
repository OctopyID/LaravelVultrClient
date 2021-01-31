<?php

namespace Octopy\Vultr\Api\Support;

use Exception;
use Throwable;
use JetBrains\PhpStorm\Pure;

class Plan
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

	/**
	 * Plan constructor.
	 * @param  array $excepted
	 */
	public function __construct(private array $excepted = [])
	{
	}

	/**
	 * @param  string|array ...$excepted
	 * @return static
	 */
	#[Pure]
	public static function except(string|array $excepted) : Plan
	{
		return new static(is_string($excepted) ? func_get_args() : $excepted);
	}

	/**
	 * @param  string $type
	 * @param  bool   $throw
	 * @return bool
	 * @throws Throwable
	 */
	public function validate(string $type, bool $throw = true) : bool
	{
		$types = array_diff([
			'all', 'vc2', 'vhf', 'vdc', 'vbm',
		], $this->excepted);

		$validated = in_array($type, $types, true);

		if ($throw) {
			throw_unless($validated, new Exception(
				'Unknown type, the allowed type is ' . implode(', ', $types)
			));
		}

		return $validated;
	}
}

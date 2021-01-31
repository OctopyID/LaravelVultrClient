<?php

namespace Octopy\Vultr\Entity;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

abstract class AbstractEntity extends Collection
{
	/**
	 * @var string
	 */
	protected string $name;

	/**
	 * AbstractEntity constructor.
	 * @param  array $response
	 */
	public function __construct(array $response)
	{
		if (isset($response[$this->name])) {
			if (isset($response[$this->name][0]) && is_array($response[$this->name][0])) {
				foreach ($response[$this->name] as $index => $value) {
					$response[$this->name][$index] = new static($value);

					unset(
						$response[$this->name][$index]->name
					);
				}
			}
		}

		parent::__construct($response[$this->name] ?? $response);
	}

	/**
	 * @param  string $key
	 * @return mixed
	 * @noinspection PhpMissingParamTypeInspection
	 */
	public function __get($key) : mixed
	{
		return $this->get(Str::snake($key));
	}
}

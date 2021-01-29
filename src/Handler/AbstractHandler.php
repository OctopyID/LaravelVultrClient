<?php

namespace Octopy\Vultr\Handler;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

abstract class AbstractHandler extends Collection
{
	/**
	 * @var string
	 */
	protected string $name;

	/**
	 * AbstractHandler constructor.
	 * @param  array $response
	 */
	public function __construct(array $response)
	{
		if (isset($response[$this->name]) && is_array($response[$this->name])) {
			$response[$this->name] = collect($response[$this->name]);
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

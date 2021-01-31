<?php

namespace Octopy\Vultr;

use Closure;
use TypeError;
use ReflectionMethod;
use ReflectionException;
use ReflectionParameter;
use Octopy\Vultr\Api\AbstractApi;
use Octopy\Vultr\Entity\AbstractEntity;

final class Relation
{
	/**
	 * @var Closure
	 */
	private Closure $result;

	/**
	 * @var array
	 */
	private array $params = [];

	/**
	 * Builder constructor.
	 * @param  string      $method
	 * @param  string|null $alias
	 * @param  string      $primary
	 * @param  Closure     $callback
	 */
	public function __construct(protected string $method, protected string|null $alias, protected string $primary, Closure $callback)
	{
		$this->result = function ($result) {
			return $result;
		};

		$callback($this);
	}

	/**
	 * @param  string $alias
	 */
	public function alias(string $alias)
	{
		$this->alias = $alias;
	}

	/**
	 * @param  array $where
	 */
	public function where(array $where)
	{
		$this->params = array_merge($this->params, $where);
	}

	/**
	 * @param  Closure $handler
	 */
	public function result(Closure $handler)
	{
		$this->result = $handler;
	}

	/**
	 * @param  AbstractEntity $handler
	 * @param  AbstractApi    $api
	 * @return AbstractEntity
	 * @throws ReflectionException
	 */
	public function handle(AbstractEntity $handler, AbstractApi $api) : AbstractEntity
	{
		$this->where([
			$this->primary => $handler->{$this->primary},
		]);

		$property = $this->alias ?? $this->method;

		$result = call_user_func($this->result, $api->{$this->method}(
			...$this->getParameters($api)
		));

		if ($handler->has($property)) {
			$result = $handler->get($property)->merge($result);
		}

		return $handler->put($property, $result);
	}

	/**
	 * @param  AbstractApi $api
	 * @return array
	 * @throws TypeError
	 * @throws ReflectionException
	 */
	private function getParameters(AbstractApi $api) : array
	{
		$reflection = new ReflectionMethod($api, $this->method);

		return collect($reflection->getParameters())->map(function (ReflectionParameter $dependency) {
			$name = $dependency->getName();

			if (isset($this->params[$name])) {
				return $this->params[$name];
			}

			if ($dependency->isDefaultValueAvailable()) {
				return $dependency->getDefaultValue();
			}

			$this->throwMissingRequiredArgs($dependency);
		})->toArray();
	}

	/**
	 * @param  ReflectionParameter $reflection
	 * @throws TypeError
	 */
	private function throwMissingRequiredArgs(ReflectionParameter $reflection,)
	{
		throw new TypeError(
			sprintf("%s() : Argument #%s (%s $%s) is missing", $this->method, $reflection->getPosition(), $reflection->getType(), $reflection->getName())
		);
	}
}

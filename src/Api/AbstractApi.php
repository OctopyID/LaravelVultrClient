<?php

namespace Octopy\Vultr\Api;

use Closure;
use Octopy\Vultr\Relation;
use Illuminate\Support\Str;
use Octopy\Vultr\Entity\AbstractEntity;
use Octopy\Vultr\Adapter\AdapterInterface;

abstract class AbstractApi
{
	/**
	 * @var array
	 */
	protected array $queries = [];

	/**
	 * @var array
	 */
	protected array $relations = [];

	/**
	 * AbstractApi constructor.
	 * @param  AdapterInterface $adapter
	 */
	public function __construct(protected AdapterInterface $adapter)
	{
	}

	/**
	 * @param  string $method
	 * @param  array  $args
	 * @return mixed
	 */
	public function __call(string $method, $args = []) : mixed
	{
		if (preg_match('/^where/', $method)) {
			return $this->where([
				Str::snake(substr($method, 5)) => $args[0] ?? null,
			]);
		}

		return $this->$method(...$args);
	}

	/**
	 * @param  string|array $relations
	 * @return AbstractApi
	 */
	public function with(string|array $relations) : AbstractApi
	{
		$relations = is_string($relations) ? func_get_args() : $relations;

		foreach ($relations as $relation => $callback) {
			$this->parseRelation($relation, $callback);
		}

		return $this;
	}

	/**
	 * @param  string|array         $name
	 * @param  string|int|bool|null $value
	 * @return AbstractApi
	 */
	public function where(string|array $name, string|int|bool|null $value = null) : AbstractApi
	{
		if (is_array($name)) {
			$this->queries = array_merge($this->queries, $name);
		} else {
			$this->queries[$name] = $value;
		}

		return $this;
	}

	/**
	 * @return array
	 */
	protected function getQueries() : array
	{
		return $this->queries;
	}

	/**
	 * @return AdapterInterface
	 */
	protected function adapter() : AdapterInterface
	{
		return $this->adapter->query($this->getQueries());
	}

	/**
	 * @param  AbstractEntity $handler
	 * @return AbstractEntity
	 */
	protected function handle(AbstractEntity $handler) : AbstractEntity
	{
		foreach ($this->relations as $builder) {
			$handler = $handler->map(function (AbstractEntity $handler) use ($builder) {
				return $builder->handle($handler, $this);
			});
		}

		return $handler;
	}

	/**
	 * @param  string              $relation
	 * @param  Closure|string|null $callback
	 * @return Relation
	 */
	private function parseRelation(string $relation, Closure|string|null $callback) : Relation
	{
		if (is_numeric($relation)) {
			$relation = $callback;
		}

		// TODO : Simplifying this Code

		if (preg_match('/:/', $relation)) {
			[$method, $primary] = array_map('trim', explode(':', $relation, 2));
		} else {
			return $this->parseRelation($relation . ':' . 'id', $callback);
		}

		if (preg_match('/ AS /', $method ?? '')) {
			[$method, $alias] = array_map('trim', explode(' AS ', $method));
		} else if (preg_match('/ AS /', $primary ?? '')) {
			[$primary, $alias] = array_map('trim', explode(' AS ', $primary));
		}

		return $this->relations[] = new Relation($method, $alias ?? null, $primary, $callback instanceof Closure ? $callback : function ($data) {
			return $data;
		});
	}
}

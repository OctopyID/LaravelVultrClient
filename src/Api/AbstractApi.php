<?php

namespace Octopy\Vultr\Api;

use Closure;
use Octopy\Vultr\Relation;
use Octopy\Vultr\Handler\AbstractHandler;
use Octopy\Vultr\Adapter\AdapterInterface;

abstract class AbstractApi
{
	protected array $relations = [];

	/**
	 * AbstractApi constructor.
	 * @param  AdapterInterface $adapter
	 */
	public function __construct(protected AdapterInterface $adapter)
	{
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
	 * @param  AbstractHandler $handler
	 * @return AbstractHandler
	 */
	protected function handle(AbstractHandler $handler) : AbstractHandler
	{
		foreach ($this->relations as $builder) {
			$handler = $handler->map(function (AbstractHandler $handler) use ($builder) {
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

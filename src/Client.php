<?php

namespace Octopy\Vultr;

use Throwable;
use Mockery\MockInterface;
use Octopy\Vultr\Api\Plan;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Octopy\Vultr\Api\Account;
use Octopy\Vultr\Api\AbstractApi;
use Octopy\Vultr\Api\Application;
use Illuminate\Support\Facades\App;
use Octopy\Vultr\Api\OperatingSystem;
use Octopy\Vultr\Adapter\DefaultAdapter;
use Octopy\Vultr\Adapter\AdapterInterface;

/**
 * @property Account         account
 * @property Application     application
 * @property Plan            plan
 * @property OperatingSystem operatingSystem
 */
class Client
{
	/**
	 * @var AdapterInterface
	 */
	protected AdapterInterface $adapter;

	/**
	 * Client constructor.
	 * @param  string                              $token
	 * @param  AdapterInterface|MockInterface|null $adapter
	 */
	public function __construct(protected string $token, AdapterInterface|MockInterface|null $adapter = null)
	{
		$this->createAdapter($adapter, $token);
	}

	/**
	 * @param  string $resource
	 * @return AbstractApi
	 * @throws Throwable
	 */
	public function __get(string $resource) : AbstractApi
	{
		return $this->getClass($resource);
	}

	/**
	 * @param  string $resource
	 * @param  array  $args
	 * @return AbstractApi
	 * @throws Throwable
	 */
	public function __call(string $resource, array $args = []) : AbstractApi
	{
		return $this->getClass($resource);
	}

	/**
	 * @param  string $token
	 * @return Client
	 */
	public function token(string $token) : Client
	{
		$this->adapter->token($token);

		return $this;
	}

	/**
	 * @param  int $minutes
	 * @return $this
	 */
	public function cache(int $minutes) : Client
	{
		$this->adapter->cache($minutes * 60);

		return $this;
	}

	/**
	 * @return $this
	 */
	public function noCache() : Client
	{
		return $this->cache(0);
	}

	/**
	 * @return AdapterInterface
	 */
	public function getAdapter() : AdapterInterface
	{
		return $this->adapter;
	}

	/**
	 * @param  AdapterInterface $adapter
	 */
	public function setAdapter(AdapterInterface $adapter)
	{
		$this->adapter = $adapter;
	}

	/**
	 * @param  AdapterInterface|null $adapter
	 * @param  string                $token
	 * @return void
	 */
	private function createAdapter(?AdapterInterface $adapter, string $token) : void
	{
		if ($adapter instanceof AdapterInterface) {
			$this->setAdapter($adapter);
		} else {
			$this->setAdapter(new DefaultAdapter($token));
		}
	}

	/**
	 * @param  string $class
	 * @return AbstractApi
	 * @throws Throwable
	 * @noinspection PhpUndefinedMethodInspection
	 */
	private function getClass(string $class) : AbstractApi
	{
		$class = (string) Str::of($class)->studly()->prepend('Octopy\\Vultr\\Api\\');

		throw_unless(class_exists($class), new InvalidArgumentException(
			'The class ' . $class . ' does not exists.'
		));

		return App::makeWith($class, [
			'adapter' => $this->adapter,
		]);
	}
}

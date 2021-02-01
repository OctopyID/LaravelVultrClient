<?php

namespace Octopy\Vultr\Adapter;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\PendingRequest;

class DefaultAdapter implements AdapterInterface
{
	/**
	 * @var int
	 */
	protected int $cache = 0;

	/**
	 * @var array
	 */
	protected array $headers = [];

	/**
	 * @var array
	 */
	protected array $queries = [];

	/**
	 * @var bool
	 */
	protected bool $debug = false;

	/**
	 * DefaultAdapter constructor.
	 * @param  string $token
	 */
	public function __construct(protected string $token)
	{
	}

	/**
	 * @param  string $token
	 * @return AdapterInterface
	 */
	public function token(string $token) : AdapterInterface
	{
		$this->token = $token;

		return $this;
	}

	/**
	 * @param  int $seconds
	 * @return AdapterInterface
	 */
	public function cache(int $seconds) : AdapterInterface
	{
		$this->cache = $seconds;

		return $this;
	}

	/**
	 * @param  string $name
	 * @param  mixed  $value
	 * @return AdapterInterface
	 */
	public function header(string $name, mixed $value) : AdapterInterface
	{
		return $this->headers([
			$name => $value,
		]);
	}

	/**
	 * @param  array $headers
	 * @return AdapterInterface
	 */
	public function headers(array $headers) : AdapterInterface
	{
		$this->headers = array_merge($this->headers, $headers);

		return $this;
	}

	/**
	 * @param  string       $method
	 * @param  string       $path
	 * @param  array        $query
	 * @param  Closure|null $callback
	 * @return mixed
	 */
	public function handle(string $method, string $path, array $query = [], Closure $callback = null) : mixed
	{
		$query = array_merge($this->queries, $query);

		if ($this->cache > 0) {
			$response = Cache::remember($path . '?query=' . md5(serialize($query)), $this->cache, function () use ($method, $path, $query) {
				return $this->send($method, $path, $query);
			});
		} else {
			$response = $this->send($method, $path, $query);
		}

		if ($callback) {
			return $callback($response) ?? $response;
		}

		return $response;
	}

	/**
	 * @param  string       $path
	 * @param  array        $query
	 * @param  Closure|null $callback
	 * @return mixed
	 */
	public function get(string $path, array $query = [], Closure $callback = null) : mixed
	{
		return $this->handle('GET', $path, $query, $callback);
	}

	/**
	 * @param  string       $path
	 * @param  array        $query
	 * @param  Closure|null $callback
	 * @return mixed
	 */
	public function put(string $path, array $query = [], Closure $callback = null) : mixed
	{
		return $this->handle('PUT', $path, $query, $callback);
	}

	/**
	 * @param  string       $path
	 * @param  array        $query
	 * @param  Closure|null $callback
	 * @return mixed
	 */
	public function post(string $path, array $query = [], Closure $callback = null) : mixed
	{
		return $this->handle('POST', $path, $query, $callback);
	}

	/**
	 * @param  string       $path
	 * @param  array        $query
	 * @param  Closure|null $callback
	 * @return mixed
	 */
	public function patch(string $path, array $query = [], Closure $callback = null) : mixed
	{
		return $this->handle('PATCH', $path, $query, $callback);
	}

	/**
	 * @param  string       $path
	 * @param  array        $query
	 * @param  Closure|null $callback
	 * @return mixed
	 */
	public function delete(string $path, array $query = [], Closure $callback = null) : mixed
	{
		return $this->handle('DELETE', $path, $query, $callback);
	}

	/**
	 * @param  array $query
	 * @return AdapterInterface
	 */
	public function query(array $query) : AdapterInterface
	{
		$this->queries = $query;

		return $this;
	}

	/**
	 * @param  string $method
	 * @param  string $path
	 * @param  array  $query
	 * @return mixed
	 */
	public function send(string $method, string $path, array $query = []) : mixed
	{
		return (match ($method) {
			'GET' => $this->getClient()->get($path, $query),
			'PUT' => $this->getClient()->put($path, $query),
			'POST' => $this->getClient()->post($path, $query),
			'PATCH' => $this->getClient()->patch($path, $query),
			'DELETE' => $this->getClient()->delete($path, $query),
		})->json();
	}

	/**
	 * @return PendingRequest
	 */
	private function getClient() : PendingRequest
	{
		return Http::withToken($this->token)
			->withHeaders($this->headers)
			->withOptions([
				'base_uri' => AdapterInterface::VULTR_ENDPOINT,
				'debug'    => $this->debug,
			]);
	}
}

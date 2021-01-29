<?php

namespace Octopy\Vultr\Adapter;

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
	 * @param  string $method
	 * @param  string $path
	 * @param  array  $query
	 * @return array|null
	 */
	public function handle(string $method, string $path, array $query = []) : array|null
	{
		if ($this->cache > 0) {
			return Cache::remember($path . '?query=' . md5(serialize($query)), $this->cache, function () use ($method, $path, $query) {
				return $this->send($method, $path, $query);
			});
		}

		return $this->send($method, $path, $query);
	}

	/**
	 * @param  string $path
	 * @param  array  $query
	 * @return array|null
	 */
	public function get(string $path, array $query = []) : array|null
	{
		return $this->handle('GET', $path, $query);
	}

	/**
	 * @param  string $method
	 * @param  string $path
	 * @param  array  $query
	 * @return array|null
	 */
	public function send(string $method, string $path, array $query = []) : array|null
	{
		return (match ($method) {
			'GET' => $this->getClient()->get($path, $query),
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

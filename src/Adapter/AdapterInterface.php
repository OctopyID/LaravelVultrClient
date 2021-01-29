<?php

namespace Octopy\Vultr\Adapter;

interface AdapterInterface
{
	/**
	 * @const string
	 */
	const VULTR_ENDPOINT = 'https://api.vultr.com/v2/';

	/**
	 * @param  string $token
	 * @return AdapterInterface
	 */
	public function token(string $token) : AdapterInterface;

	/**
	 * @param  int $seconds
	 * @return AdapterInterface
	 */
	public function cache(int $seconds) : AdapterInterface;

	/**
	 * @param  string $name
	 * @param  mixed  $value
	 * @return AdapterInterface
	 */
	public function header(string $name, mixed $value) : AdapterInterface;

	/**
	 * @param  array $headers
	 * @return AdapterInterface
	 */
	public function headers(array $headers) : AdapterInterface;

	/**
	 * @param  string $method
	 * @param  string $path
	 * @param  array  $query
	 * @return array|null
	 */
	public function handle(string $method, string $path, array $query = []) : array|null;

	/**
	 * @param  string $path
	 * @param  array  $query
	 * @return array|null
	 */
	public function get(string $path, array $query = []) : array|null;

	/**
	 * @param  string $method
	 * @param  string $path
	 * @param  array  $query
	 * @return array|null
	 */
	public function send(string $method, string $path, array $query = []) : array|null;

}

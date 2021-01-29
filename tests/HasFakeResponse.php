<?php

namespace Octopy\Vultr\Tests;

interface HasFakeResponse
{
	/**
	 * @param  string|null $name
	 * @return array
	 */
	public function fakeResponse(string|null $name = null) : array;
}

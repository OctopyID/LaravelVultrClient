<?php

namespace Octopy\Vultr\Tests;

interface HasFakeResponse
{
	/**
	 * @return array
	 */
	public function fakeResponse() : array;
}

<?php

namespace Octopy\Vultr\Tests\Unit;

use Octopy\Vultr\Tests\VultrTestCase;
use Octopy\Vultr\Adapter\AdapterInterface;

class ClientTest extends VultrTestCase
{
	/**
	 * @return void
	 */
	public function testDefaultAdapterHasCreated()
	{
		$this->assertInstanceOf(AdapterInterface::class, $this->vultr->getAdapter());
	}
}

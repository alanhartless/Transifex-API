<?php
/**
 * @copyright  Copyright (C) 2012-2013 Michael Babker. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace BabDev\Tests\Http;

use BabDev\Http\HttpFactory;

use Joomla\Registry\Registry;

/**
 * Test class for \BabDev\Http\HttpFactory.
 *
 * @since  1.0
 */
class HttpFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Tests the getHttp method.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetHttp()
	{
		$this->assertInstanceOf(
			'\\BabDev\\Http\\Http',
			HttpFactory::getHttp()
		);
	}

	/**
	 * Tests the getAvailableDriver method.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testGetAvailableDriver()
	{
		$this->assertFalse(
			HttpFactory::getAvailableDriver(new Registry, array()),
			'Passing an empty array should return false due to there being no adapters to test'
		);

		$this->assertFalse(
			HttpFactory::getAvailableDriver(new Registry, array('fopen')),
			'A false should be returned if a class is not present or supported'
		);
	}
}

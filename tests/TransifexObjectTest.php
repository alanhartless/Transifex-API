<?php

/*
 * BabDev Transifex Package
 *
 * (c) Michael Babker <michael.babker@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\{
    Http, TransifexObject
};
use Joomla\Test\TestHelper;

/**
 * Test class for \BabDev\Transifex\TransifexObject.
 */
class TransifexObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Http
     */
    private $client;

    /**
     * @var TransifexObject
     */
    private $object;

    /**
     * @var array
     */
    private $options;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->options = [
            'api.url'      => 'http://www.transifex.com/api/2',
            'api.username' => 'MyTestUser',
            'api.password' => 'MyTestPass',
        ];
        $this->client  = $this->createMock(Http::class);
        $this->object  = $this->getMockForAbstractClass(
            TransifexObject::class,
            [$this->options, $this->client]
        );
    }

    /**
     * @testdox __construct() with no injected client creates a Transifex instance with a default Http object
     *
     * @covers  \BabDev\Transifex\TransifexObject::__construct
     * @covers  \BabDev\Transifex\Http::__construct
     */
    public function test__constructWithNoInjectedClient()
    {
        $object = $this->getMockForAbstractClass(TransifexObject::class, [$this->options]);

        $this->assertInstanceOf(
            TransifexObject::class,
            $object
        );

        $this->assertAttributeInstanceOf(
            Http::class,
            'client',
            $object
        );
    }

    /**
     * @testdox fetchUrl() returns the full API URL
     *
     * @covers  \BabDev\Transifex\TransifexObject::fetchUrl
     * @uses    \BabDev\Transifex\Http
     * @uses    \BabDev\Transifex\TransifexObject::__construct
     */
    public function testFetchUrlBasicAuth()
    {
        // Use Reflection to trigger fetchUrl()
        $this->assertSame(
            TestHelper::invoke($this->object, 'fetchUrl', '/formats'),
            'http://www.transifex.com/api/2/formats'
        );
    }
}

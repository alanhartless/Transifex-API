<?php
/**
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Tests\Transifex;

use BabDev\Transifex\Http;
use BabDev\Transifex\Projects;

use Joomla\Http\Response;

/**
 * Test class for \BabDev\Transifex\Projects.
 *
 * @since  1.0
 */
class ProjectsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    array  Options for the Projects object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    Http  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    Response  Mock response object.
	 * @since  1.0
	 */
	protected $response;

	/**
	 * @var    Projects  Object under test.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * @var    string  Sample JSON string.
	 * @since  1.0
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * @var    string  Sample JSON error message.
	 * @since  1.0
	 */
	protected $errorString = '{"message": "Generic Error"}';

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		$this->options = array();
		$this->client = $this->getMock('\\BabDev\\Transifex\\Http', array('get', 'post', 'delete', 'put', 'patch'));
		$this->response = $this->getMock('\\Joomla\\Http\\Response');

		$this->object = new Projects($this->options, $this->client);
	}

	/**
	 * Tests the createProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::createProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateProject()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('post')
			->with('/projects/')
			->will($this->returnValue($this->response));

		// Additional options
		$options = array(
			'long_description'   => 'My test project',
		    'private'            => true,
		    'homepage'           => 'http://www.example.com',
		    'feed'               => 'http://www.example.com/feed.xml',
		    'anyone_submit'      => true,
		    'hidden'             => false,
		    'bug_tracker'        => 'http://www.example.com/tracker',
		    'trans_instructions' => 'http://www.example.com/instructions.html',
		    'tags'               => 'joomla, babdev',
		    'maintainers'        => 'joomla',
		    'outsource'          => 'thirdparty',
		    'auto_join'          => true,
		    'license'            => 'other_open_source',
		    'fill_up_resources'  => false,
			'repository_url'     => 'http://www.example.com'
	);

		$this->assertEquals(
			$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB', $options),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the createProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::createProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateProjectFailureForABadRequest()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('post')
			->with('/projects/')
			->will($this->returnValue($this->response));

		$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB', array('repository_url' => 'http://www.joomla.org'));
	}

	/**
	 * Tests the createProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::createProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateProjectsBadLicense()
	{
		$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB', array('license' => 'failure'));
	}

	/**
	 * Tests the createProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::createProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testCreateProjectFailureForMissingFields()
	{
		$this->object->createProject('Joomla Platform', 'joomla-platform', 'Project for the Joomla Platform', 'en_GB');
	}

	/**
	 * Tests the deleteProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::deleteProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteProject()
	{
		$this->response->code = 204;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla-platform')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->deleteProject('joomla-platform'),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the deleteProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::deleteProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testDeleteProjectFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('delete')
			->with('/project/joomla-platform')
			->will($this->returnValue($this->response));

		$this->object->deleteProject('joomla-platform');
	}

	/**
	 * Tests the getProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::getProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetProject()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/?details')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getProject('joomla-platform', true),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::getProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetProjectFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/project/joomla-platform/?details')
			->will($this->returnValue($this->response));

		$this->object->getProject('joomla-platform', true);
	}

	/**
	 * Tests the getProjects method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::getProjects
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetProjects()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/projects/')
			->will($this->returnValue($this->response));

		$this->assertEquals(
			$this->object->getProjects(),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the getProjects method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::getProjects
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testGetProjectsFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/projects/')
			->will($this->returnValue($this->response));

		$this->object->getProjects();
	}

	/**
	 * Tests the updateProject method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::updateProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateProject()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/')
			->will($this->returnValue($this->response));

		// Additional options
		$options = array(
			'name'               => 'Joomla Platform',
			'description'        => 'Project for the Joomla Platform',
			'long_description'   => 'My test project',
		    'private'            => true,
		    'homepage'           => 'http://www.example.com',
		    'feed'               => 'http://www.example.com/feed.xml',
		    'anyone_submit'      => true,
		    'hidden'             => false,
		    'bug_tracker'        => 'http://www.example.com/tracker',
		    'trans_instructions' => 'http://www.example.com/instructions.html',
		    'tags'               => 'joomla, babdev',
		    'maintainers'        => 'joomla',
		    'outsource'          => 'thirdparty',
		    'auto_join'          => true,
		    'license'            => 'other_open_source',
		    'fill_up_resources'  => false
		);

		$this->assertEquals(
			$this->object->updateProject('joomla-platform', $options),
			json_decode($this->sampleString)
		);
	}

	/**
	 * Tests the updateProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \DomainException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::updateProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateProjectFailure()
	{
		$this->response->code = 500;
		$this->response->body = $this->errorString;

		$this->client->expects($this->once())
			->method('put')
			->with('/project/joomla-platform/')
			->will($this->returnValue($this->response));

		$this->object->updateProject('joomla-platform', array('name' => 'Joomla Platform'));
	}

	/**
	 * Tests the updateProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \RuntimeException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::updateProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateProjectRuntimeException()
	{
		$this->object->updateProject('joomla-platform');
	}

	/**
	 * Tests the updateProject method - failure
	 *
	 * @return  void
	 *
	 * @expectedException  \InvalidArgumentException
	 * @since              1.0
	 *
	 * @covers  \BabDev\Transifex\Projects::checkLicense
	 * @covers  \BabDev\Transifex\Projects::updateProject
	 * @covers  \BabDev\Transifex\TransifexObject::processResponse
	 * @uses    \BabDev\Transifex\Http
	 * @uses    \BabDev\Transifex\TransifexObject
	 */
	public function testUpdateProjectBadLicense()
	{
		$this->object->updateProject('joomla-platform', array('license' => 'failure'));
	}
}

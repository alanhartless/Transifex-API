<?php
/**
 * BabDev HTTP Package
 *
 * The BabDev HTTP package is a fork of the Joomla HTTP package as found in Joomla! CMS 3.1.1
 * and provides selected bug fixes and a single codebase for consistent use in CMS 2.5 and newer.
 *
 * @copyright  Copyright (C) 2012-2014 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace BabDev\Http;

/**
 * HTTP response data object class.
 *
 * @since  1.0
 */
class Response
{
	/**
	 * The server response code.
	 *
	 * @var    integer
	 * @since  1.0
	 */
	public $code;

	/**
	 * Response headers.
	 *
	 * @var    array
	 * @since  1.0
	 */
	public $headers = array();

	/**
	 * Server response body.
	 *
	 * @var    string
	 * @since  1.0
	 */
	public $body;
}
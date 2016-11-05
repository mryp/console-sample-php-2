<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * REST API設定
 */
return array(
	'default_format' => 'json',
	'xml_basenode' => 'data',
	'realm' => 'REST API',
	'auth' => 'basic',
	'valid_logins' => array(
		'admin' => '1234',
	),
	'ignore_http_accept' => false,
);

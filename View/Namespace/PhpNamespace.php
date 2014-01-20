<?php
/**
 * Namespace class for the php namespace.
 *
 * PHP 5
 *
 * Cake Markup Language (http://github.com/jameswatts/cake-markup-language)
 * Copyright 2012, James Watts (http://github.com/jameswatts)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2012, James Watts (http://github.com/jameswatts)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cml.View.Namespace
 * @since         CakePHP(tm) v 2.1.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('CmlNamespace', 'Cml.View');

/**
 * Namespace class for the php namespace.
 *
 * @package       Cml.View.Namespace
 */
class PhpNamespace extends CmlNamespace {

/**
 * Method used to initialize the namespace, with optional settings.
 * 
 * @param array $settings Optional settings to configure the namespace.
 */
	public function load(array $settings = null) {
		$vars = array(
			'server' => array(),
			'session' => array(),
			'request' => array(),
			'cookie' => array()
		);
		foreach ($_SERVER as $key => $value) {
			$vars['server'][strtolower($key)] = $value;
		}
		if (isset($_SESSION)) {
			foreach ($_SESSION as $key => $value) {
				$vars['session'][$key] = $value;
			}
		}
		foreach ($_REQUEST as $key => $value) {
			$vars['request'][$key] = $value;
		}
		foreach ($_COOKIE as $key => $value) {
			$vars['cookie'][$key] = $value;
		}
		$this->_view->viewVars['Php'] = $vars;
	}

}


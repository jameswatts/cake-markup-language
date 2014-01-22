<?php
/**
 * Base class for namespaces in the Cake Markup Language.
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
 * @package       Cml.View
 * @since         CakePHP(tm) v 2.1.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('View', 'View');

/**
 * Base class for namespaces in the Cake Markup Language.
 *
 * @package       Cml.View
 */
abstract class CmlNamespace extends Object {

/**
 * Reference to the controller object.
 * 
 * @var Controller
 */
	protected $_Controller = null;

/**
 * Reference to the view object.
 * 
 * @var View
 */
	protected $_View = null;

/**
 * Constructor
 *
 * @param Controller $controller A controller object to pull View::_passedVars from.
 */
	public function __construct(Controller &$controller, View &$view) {
		$this->_Controller = $controller;
		$this->_View = $view;
	}

/**
 * Abstract method used to initialize the namespace, with optional settings.
 * 
 * @param array $settings Optional settings to configure the namespace.
 */
	abstract public function load(array $settings = null);

}


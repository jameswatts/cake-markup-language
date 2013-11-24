<?php
/**
 * Component which enables CakeML views.
 *
 * PHP 5
 *
 * Cake Markup Language (http://github.com/jameswatts/cake-markup-language)
 * Copyright 2013, James Watts (http://github.com/jameswatts)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2013, James Watts (http://github.com/jameswatts)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cml.Controller.Component
 * @since         CakePHP(tm) v 2.1.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Component', 'Controller');

/**
 * The Parser component parses the markup and compiles the output.
 *
 * @package       Cml.Controller.Component
 */
class ParserComponent extends Component {

/**
 * An array containing the names of helpers this controller uses. The array elements should
 * not contain the "Helper" part of the classname.
 *
 * @var mixed A single name as a string or a list of names as an array.
 */
	public $helpers = null;

/**
 * The name of the layout file to render the view inside of. The name specified
 * is the filename of the layout in /app/View/Layouts without the .ctp
 * extension.
 *
 * @var string
 */
	public $layout = null;

/**
 * Used to define methods a controller that will be cached. To cache a
 * single action, the value is set to an array containing keys that match
 * action names and values that denote cache expiration times (in seconds).
 *
 * $cacheAction can also be set to a strtotime() compatible string. This
 * marks all the actions in the controller for view caching.
 *
 * @var mixed
 */
	public $cacheAction = false;

/**
 * Determines which actions of the controller should not have their views rendered 
 * using the CakeML view. Can be a single action as a string, or an array of 
 * actions to ignore.
 *
 * @var mixed
 */
	public $ignoreAction = null;

/**
 * An array containing the namespaces this view uses, specifying the plugin 
 * name using dot notation, for example, Example.Tools, where "Example" is the 
 * plugin name, and "Tools" is the namespace.
 *
 * @var mixed A single name as a string or a list of names as an array.
 */
	public $namespaces = null;

/**
 * Determines the name of the Html helper in the View.
 *
 * @var string
 */
	public $htmlHelper = 'Html';

/**
 * Determines the name of the Form helper in the View.
 *
 * @var string
 */
	public $formHelper = 'Form';

/**
 * Determines if layouts are parsed as markup.
 *
 * @var boolean
 */
	public $renderLayout = false;

/**
 * Determines if elements are parsed as markup.
 *
 * @var boolean
 */
	public $renderElement = false;

/**
 * Determines if debug mode is enabled.
 *
 * @var boolean
 */
	public $debug = false;

/**
 * Static render settings for the View object.
 *
 * @var boolean
 */
	public static $renderSettings = array();

/**
 * Called before the Controller::beforeRender(), and before the view class is 
 * loaded, and before Controller::render().
 *
 * @param Controller $controller Controller with components to beforeRender.
 * @return void
 */
	public function beforeRender(Controller $controller) {
		if (!$this->ignoreAction || ((is_string($this->ignoreAction) && $this->ignoreAction != $controller->action) || (is_array($this->ignoreAction) && !in_array($controller->action, $this->ignoreAction)))) {
			self::$renderSettings['layout'] = $this->renderLayout;
			self::$renderSettings['element'] = $this->renderElement;
			$controller->viewClass = 'Cml.Cml';
			if (is_array($this->helpers)) {
				if (!is_array($controller->helpers)) {
					$controller->helpers = $this->helpers;
				} else {
					array_merge($controller->helpers, $this->helpers);
				}
			}
			if (is_string($this->layout)) {
				$controller->layout = $this->layout;
			}
			if (is_array($this->cacheAction)) {
				if (!is_array($controller->cacheAction)) {
					$controller->cacheAction = $this->cacheAction;
				} else {
					array_merge($controller->cacheAction, $this->cacheAction);
				}
			}
		}
	}

/**
 * Formats the array as a short array syntax string for the View.
 *
 * @param array $array The array to format.
 * @return string
 */
	public function formatArray($array = array()) {
		$items = array();
		foreach ($array as $key => $value) {
			$item = '';
			if (!is_numeric($key)) {
				$item .= "'" . $this->formatString($key) . "' => ";
			}
			if (is_array($value)) {
				$item .= $this->formatArray($value);
			} else {
				$item .= (is_string($value))? "'" . $this->formatString($value) . "'" : $value;
			}
			$items[] = $item;
		}
		return '[' . implode(', ', $items) . ']';
	}

/**
 * Formats the string as escaped for the View.
 *
 * @param string $string The string to format.
 * @return string
 */
	public function formatString($string = '') {
		return htmlentities($string, ENT_QUOTES, 'UTF-8', false);
	}

}


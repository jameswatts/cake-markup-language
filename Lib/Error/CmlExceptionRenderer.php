<?php
/**
 * Exception renderer class for the Cake Markup Language.
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
 * @package       Cml.Lib.Error
 * @since         CakePHP(tm) v 2.1.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('ExceptionRenderer', 'Error');

/**
 * Exception Renderer.
 *
 * Captures and handles all unhandled exceptions. Displays helpful framework errors when debug > 1.
 * When debug < 1 a CakeException will render 404 or 500 errors. If an uncaught exception is thrown
 * and it is a type that ExceptionHandler does not know about it will be treated as a 500 error.
 *
 * @package       Cml.Lib.Error
 */
class CmlExceptionRenderer extends ExceptionRenderer {

/**
 * Renders the response for the exception.
 *
 * @return void
 */
	public function render() {}

/**
 * Generate the response using the controller object.
 *
 * @param string $template The template to render.
 * @return void
 */
	protected function _outputMessage($template) {}

/**
 * A safer way to render error messages, replaces all helpers, with basics
 * and doesn't call component methods.
 *
 * @param string $template The template to render
 * @return void
 */
	protected function _outputMessageSafe($template) {}

}


<?php
/**
 * Namespace class for the cake namespace.
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
 * Namespace class for the cake namespace.
 *
 * @package       Cml.View.Namespace
 */
class CakeNamespace extends CmlNamespace {

/**
 * Method used to initialize the namespace, with optional settings.
 * 
 * @param array $settings Optional settings to configure the namespace.
 */
	public function load(array $settings = null) {
		$this->_view->viewVars['Cake'] = array(
			'plugin' => $this->_controller->plugin,
			'controller' => $this->_controller->name,
			'action' => $this->_controller->action,
			'view' => $this->_controller->view,
			'layout' => $this->_controller->layout,
			'modelClass' => $this->_controller->modelClass,
			'modelKey' => $this->_controller->modelKey,
			'validationErrors' => $this->_controller->validationErrors,
			'passedArgs' => $this->_controller->passedArgs,
			'Request' => array(
				'params' => $this->_controller->request->params,
				'data' => $this->_controller->request->data,
				'query' => $this->_controller->request->query,
				'url' => $this->_controller->request->url,
				'base' => $this->_controller->request->base,
				'webroot' => $this->_controller->request->webroot,
				'here' => $this->_controller->request->here,
				'domain' => $this->_controller->request->domain(),
				'subdomains' => $this->_controller->request->subdomains(),
				'host' => $this->_controller->request->host(),
				'method' => $this->_controller->request->method(),
				'referer' => $this->_controller->request->referer(),
				'clientIp' => $this->_controller->request->clientIp()
			)
		);
	}

}


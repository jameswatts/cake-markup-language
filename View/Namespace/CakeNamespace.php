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
 * Settings for this namespace.
 *
 * @var array
 */
	public $settings = array(
		'classes' => array(
			'Html' => 'Html',
			'Form' => 'Form',
			'Paginator' => 'Paginator',
			'Js' => 'Js',
			'Text' => 'Text',
			'Number' => 'Number',
			'Time' => 'Time',
			'Cache' => 'Cache',
			'Session' => 'Session'
		)
	);

/**
 * Method used to initialize the namespace, with optional settings.
 *
 * @return void
 */
	public function load() {
		$this->_View->viewVars['Cake'] = array(
			'version' => Configure::version(),
			'debug' => Configure::read('debug'),
			'plugin' => $this->_Controller->plugin,
			'controller' => $this->_Controller->name,
			'action' => $this->_Controller->action,
			'view' => $this->_Controller->view,
			'layout' => $this->_Controller->layout,
			'modelClass' => $this->_Controller->modelClass,
			'modelKey' => $this->_Controller->modelKey,
			'validationErrors' => $this->_Controller->validationErrors,
			'passedArgs' => $this->_Controller->passedArgs,
			'request' => array(
				'params' => $this->_Controller->request->params,
				'data' => $this->_Controller->request->data,
				'query' => $this->_Controller->request->query,
				'url' => $this->_Controller->request->url,
				'base' => $this->_Controller->request->base,
				'webroot' => $this->_Controller->request->webroot,
				'here' => $this->_Controller->request->here,
				'domain' => $this->_Controller->request->domain(),
				'subdomains' => $this->_Controller->request->subdomains(),
				'host' => $this->_Controller->request->host(),
				'method' => $this->_Controller->request->method(),
				'referer' => $this->_Controller->request->referer(),
				'clientIp' => $this->_Controller->request->clientIp()
			)
		);
	}

}


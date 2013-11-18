<?php
/**
 * Extended View class for the Cake Markup Language.
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
 * @package       Cml.View
 * @since         CakePHP(tm) v 2.1.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('View', 'View');

/**
 * View, the V in the MVC triad. View interacts with Helpers and view variables passed
 * in from the controller to render the results of the controller action.  Often this is HTML,
 * but can also take the form of JSON, XML, PDF's or streaming files.
 *
 * CakePHP uses a two-step-view pattern.  This means that the view content is rendered first,
 * and then inserted into the selected layout.  This also means you can pass data from the view to the
 * layout using `$this->set()`
 *
 * @package       Cml.View
 */
class CmlView extends View {

/**
 * Self-closing tag.
 */
	const TAG_SELF = 1;

/**
 * Opening tag.
 */
	const TAG_OPEN = 2;

/**
 * Closing tag.
 */
	const TAG_CLOSE = 3;

/**
 * Parser processing timeout.
 * 
 * @var integer
 */
	protected $_timeout = 10000;

/**
 * Contains the registered namespaces.
 * 
 * @var array
 */
	protected $_namespaces = array(
		'Php' => 'Cml',
		'Cake' => 'Cml'
	);

/**
 * Contains the helpers used.
 * 
 * @var array
 */
	protected $_helpers = array(
		'Html' => null,
		'Form' => null
	);

/**
 * Enables debug mode.
 * 
 * @var boolean
 */
	protected $_debug = false;

/**
 * Constructor
 *
 * @param Controller $controller The controller object.
 */
	public function __construct(Controller $controller = null) {
		parent::__construct($controller);
		$nsSettings = array();
		if (is_array($controller->Parser->namespaces)) {
			$namespaces = (empty($controller->Parser->namespaces))? array() : Set::normalize((array) $controller->Parser->namespaces);
			foreach ($namespaces as $namespace => $settings) {
				list($plugin, $ns) = explode('.', $namespace);
				$nsSettings[$ns] = $settings;
				$this->_namespaces[$ns] = $plugin;
			}
		} else if (is_string($controller->Parser->namespaces)) {
			list($plugin, $ns) = explode('.', $controller->Parser->namespaces);
			$nsSettings[$ns] = array();
			$this->_namespaces[$ns] = $plugin;
		}
		foreach ($this->_namespaces as $ns => $plugin) {
			$class = $ns . 'Namespace';
			App::uses($class, ((!empty($plugin))? $plugin . '.' : '') . 'View/Namespace');
			if (!class_exists($class)) {
				throw new CakeException(sprintf('Unknown namespace: %s', $class));
			}
			$namespace = new $class($controller, $this);
			$namespace->load((isset($nsSettings[$ns]))? $nsSettings[$ns] : array());
		}
		$this->_helpers['Html'] = $controller->Parser->htmlHelper;
		$this->_helpers['Form'] = $controller->Parser->formHelper;
		$this->_debug = $controller->Parser->debug;
		$this->_controller = $controller;
	}

/**
 * Parses the view file, generating and then executing the PHP syntax.
 *
 * Parse triggers helper callbacks, which are fired before and after the view is parsed,
 * as well as before and after the layout.  The helper callbacks are called:
 *
 * - `beforeRender`
 * - `afterRender`
 * - `beforeLayout`
 * - `afterLayout`
 *
 * @param string $viewFile Path to the view file.
 * @return string Rendered Elements
 * @throws CakeException if there is an error in the view.
 */
	protected function _parse($viewFile) {
		$this->_current = $this->_parsed = $viewFile;
		$this->getEventManager()->dispatch(new CakeEvent('View.beforeRenderFile', $this, array($viewFile)));
		$markup = file_get_contents($viewFile);
		ob_start();
		if ($this->_debug) {
			$output = $source = $this->_parseMarkup($markup);
			ob_clean();
			try {
				eval(' ?> ' . $output . ' <?php ');
			} catch(Exception $e) {
				$error = array(
					'message' => $e->getMessage(),
					'file' => $e->getFile(),
					'line' => $e->getLine()
				);
			}
			if (error_get_last()) {
				$error = error_get_last();
			}
			ob_clean();
			$this->response->type('text/html');
			$this->response->charset('UTF-8');
			$this->layout = 'Cml.debug';
			if (isset($error)) {
				echo '<p class="error"><b>Error:</b> ' . $error['message'] . '</p>';
				if ($error['file'] === $viewFile || strstr($error['file'], 'eval()\'d')) {
					echo '<script type="text/javascript">ERROR_LINE = \'L' . $error['line'] . '\';</script>';
				}
			}
			debug($source);
			$content = str_replace(array("\"cake-debug\">\n&#039;", "&#039;\n</pre>"), array('"cake-debug">', '</pre>'), ob_get_clean());
			preg_match('/"cake\-debug">([.\s\S\n\r]*?)<\/pre>/', $content, $matches);
			$lines = explode("\n", $matches[1]);
			$i = 1;
			$code = '';
			foreach ($lines as $line) {
				foreach (array(10 => '    ', 100 => '   ', 1000 => '  ', 10000 => ' ') as $size => $space) {
					if ($i < $size) {
						$code .= '<span id="L' . $i . '" class="cake-debug-line"><a href="#L' . $i . '" class="cake-debug-number">' . $i . $space . '</a> ' . str_replace("\t", '    ', $line) . '</span>' . "\n";
						break;
					}
				}
				$i++;
			}
			$content = str_replace(array($matches[1], '%START%', '%END%', '%OPEN%', '%CLOSE%'), array($code, '<', '>', '{', '}'), $content);
		} else {
			$output = $this->_parseMarkup($markup);
			eval(' ?> ' . $output . ' <?php ');
			$content = ob_get_clean();
		}
		$this->assign('content', $content);
		$afterEvent = new CakeEvent('View.afterRenderFile', $this, array($viewFile, $content));
		//TODO: For BC puporses, set extra info in the event object. Remove when appropriate
		$afterEvent->modParams = 1;
		$this->getEventManager()->dispatch($afterEvent);
		$content = $afterEvent->data[1];
		return $content;
	}

/**
 * Parses the markup and returns the compiled output.
 *
 * @param string $markup The markup to parse.
 * @return string
 */
	protected function _parseMarkup($markup = '') {
		if (is_string($markup) && !preg_match('/^\s*$/', $markup)) {
			$markup = str_replace(array('%START%', '<?', '<%', '%END%', '?>', '%>'), array('&lt;', '&lt;?', '&lt;%', '&gt;', '?&gt;', '%&gt;'), $markup);
			$markup = preg_replace('/(<\!\-\-comment\-\->[.\s\S\n\r]*?<\!\-\-\/comment\-\->)/i', '', $markup);
			if (preg_match_all('/((%|&)\{([^\}]+)\})/i', $markup, $vars, PREG_OFFSET_CAPTURE)) {
				if ($vars && count($vars) === 4) {
					for ($i = 0; $i < count($vars[3]); $i++) {
						$method = '_process' . (($vars[2][$i][0] === '%')? 'Variable' : 'Reference');
						$markup = str_replace($vars[2][$i][0] . '{' . $vars[3][$i][0] . '}', $this->$method($vars[3][$i][0]), $markup);
					}
				}
			}
			if (preg_match_all('/(#\{([^\}]+)\})/i', $markup, $i18n, PREG_OFFSET_CAPTURE)) {
				if ($i18n && count($i18n) === 3) {
					for ($i = 0; $i < count($i18n[2]); $i++) {
						$markup = str_replace('#{' . $i18n[2][$i][0] . '}', $this->_processLiteral($i18n[2][$i][0]), $markup);
					}
				}
			}
			$init = time()+$this->_timeout;
			while (preg_match('/(<)(|\/)([\w\-]+)\:/i', $markup, $match, PREG_OFFSET_CAPTURE)) {
				$start = $match[1][1];
				if ($init < time()) {
					break;
				}
				preg_match('/(|\s+([\w\-]+=")[^"]*("))*\s*(|\/)(>)/i', $markup, $match, PREG_OFFSET_CAPTURE, $start);
				$end = $match[5][1];
				$raw = substr($markup, $start, ($end-$start)+1);
				preg_match('/<(|\/)([\w\-]+):([\w\-]+)(|\s+([\w\-]+=")[^"]*("))*\s*(|\/)>/i', $raw, $matches, PREG_OFFSET_CAPTURE);
				$ns = $matches[2][0];
				$tag = $matches[3][0];
				if (!empty($ns) && !empty($tag)) {
					$ns = str_replace(' ', '', ucwords(str_replace('-', ' ', $ns)));
					if (isset($this->_namespaces[$ns])) {
						$state = ($matches[count($matches)-1][0] === '/')? self::TAG_SELF : (($matches[1][0] === '/')? self::TAG_CLOSE : self::TAG_OPEN);
						$markup = str_replace($raw, $this->_parseTag($this->_namespaces[$ns], $ns, str_replace('-', '_', strtolower($tag)), ($state === self::TAG_CLOSE)? array() : $this->_parseAttributes($raw), $state, $raw), $markup);
					} else {
						$markup = str_replace($raw, str_replace(array('<', '>'), array('%START%', '%END%'), $raw), $markup);
					}
				}
			}
			return str_replace(array('%START%', '%END%', '%OPEN%', '%CLOSE%'), array('<', '>', '{', '}'), $markup);
		}
		return '';
	}

/**
 * Renders the template for the given namespace and tag.
 *
 * @param string $plugin Name of the plugin.
 * @param string $namespace The parsed namespace.
 * @param string $tag The parsed tag name.
 * @param string $attributes The parsed attributes.
 * @param string $state The tag state.
 * @param string $raw The raw string from the parser.
 * @return string
 * @throws CakeException if the template cannot be found or an error occurs.
 */
	protected function _parseTag($plugin, $namespace, $tag, $attributes, $state, $raw) {
		$file = APP . 'Plugin' . DS . $plugin . DS . 'View' . DS . 'Namespace' . DS . $namespace . DS . $tag . '.ctp';
		if (!is_file($file) || !is_readable($file)) {
			return h($raw);
		}
		try {
			ob_start();
			include $file;
			$output = ob_get_clean();
		} catch(Exception $e) {
			ob_end_clean();
			throw new CakeException($e->getMessage());
		}
		return $output;
	}

/**
 * Parses the given attributes from a tag and returns a key/value array.
 *
 * @param string $tag The tag to parse.
 * @return array
 */
	protected function _parseAttributes($tag) {
		$attributes = array();
		if (is_string($tag) && !preg_match('/^\s+$/', $tag)) {
			$tag = preg_replace('/[\s]{2,}/', ' ', $tag);
			preg_match_all('/\s+([\w\-]+)\=("[^"]{1,}")/i', $tag, $parts, PREG_OFFSET_CAPTURE);
			if (isset($parts) && count($parts) === 3) {
				for ($i = 0; $i < count($parts[0]); $i++) {
					$attributes[$parts[1][$i][0]] = substr($parts[2][$i][0], 1, strlen($parts[2][$i][0])-2);
				}
			}
		}
		return $attributes;
	}

/**
 * Processes an attribute with a default value, and optionally formats as an attribute.
 *
 * @param array $attributes The attributes to use.
 * @param string $name The attribute to process.
 * @param array $options The processing options.
 * @return string
 */
	protected function _processAttribute(array $attributes, $name, array $options = null) {
		$options = array_merge(array(
			'default' => null,
			'format' => '"%s"',
			'replace' => array(array('<?php echo ', '; ?>'), array('%OPEN%', '%CLOSE%')),
			'parse' => null
		), (array) $options);
		$attribute = (isset($attributes[$name]))? $attributes[$name] : $options['default'];
		if (!is_null($attribute)) {
			$string = strtolower(trim($attribute));
			$gnirts = strrev($string);
			if ($string === 'true' || $string === 'false' || $string === 'null') {
				return (is_string($options['format']))? ((is_array($options['replace']))? sprintf($options['format'], str_replace($options['replace'][0], $options['replace'][1], (string) $attribute)) : sprintf($options['format'], (string) $attribute)) : (($string === 'null')? null : ($string === 'true'));
			} else if (strlen($string) > 0 && $string{0} === '[' && $gnirts{0} === ']') {
				return str_replace(array('[', ']'), array('array(', ')'), preg_replace('/(<\?php echo )(\$this\->_processVariable\(\'([\w\-]+)\'\))(\; \?>)/', '{$2}', trim($attribute)));
			} else {
				if (substr($string, 0, 7) === '$this->') {
					$value = $attribute;
				} else {
					if (is_string($options['format'])) {
						if (is_array($options['replace'])) {
							$replaced = str_replace($options['replace'][0], $options['replace'][1], (string) $attribute);
							$value = (substr($replaced, 0, 7) === '$this->')? $replaced : sprintf($options['format'], $replaced);
						} else {
							$value = sprintf($options['format'], $attribute);
						}
					} else {
						$value = $attribute;
					}
				}
				if ($options['parse'] === true) {
					$options['parse'] = array('/(%OPEN%)(\$this\->_processValue\(\'([\w\-]+)\'\))(%CLOSE%)/', '$2');
				}
				return (is_array($options['parse']))? preg_replace($options['parse'][0], $options['parse'][1], $value) : $value;
			}
		} else {
			return (is_string($options['format']))? sprintf($options['format'], '') : null;
		}
	}

/**
 * Processes a view variable and returns the value.
 *
 * @param string $name The name of the view variable.
 * @return mixed
 */
	protected function _processVariable($name) {
		return $this->_compile('echo $this->_processValue(\'' . $name . '\');');
	}

/**
 * Processes a view variable and returns a reference at run-time.
 *
 * @param string $name The name of the view variable.
 * @return mixed
 */
	protected function _processReference($name) {
		if (strstr($name, '.')) {
			$parts = explode('.', $name);
			$array = $this->viewVars;
			foreach ($parts as $part) {
				$isObject = is_object($array);
				if (($isObject && isset($array->$part)) || isset($array[$part])) {
					$array = ($isObject)? $array->$part : $array[$part];
				} else {
					throw new Exception('View variable not found: ' . $name);
				}
			}
			return $array;
		} else {
			if (isset($this->viewVars[$name])) {
				return $this->viewVars[$name];
			} else {
				throw new CakeException('View variable not found: ' . $name);
			}
		}
	}

/**
 * Processes a I18N literal and returns the generated PHP code.
 *
 * @param string $name The name of the I18N literal.
 * @return string
 */
	protected function _processLiteral($literal) {
		$raw = ($literal{0} === ':');
		if ($raw) {
			$literal = substr($literal, 1);
		}
		if (strstr($literal, '^')) {
			$parts = explode('^', $literal);
			$domain = str_replace(array('<?php ', 'echo ', '; ?>'), '', array_shift($parts));
			$domain = (substr($domain, 0, 7) === '$this->')? $domain : "'" . $domain . "'";
			$literal = implode('', $parts);
		}
		if (strstr($literal, '|')) {
			$parts = explode('|', $literal);
			$literal = array_shift($parts);
			$values = array();
			foreach ($parts as $part) {
				$part = str_replace(array('<?php ', 'echo ', '; ?>'), '', $part);
				$values[] = (substr($part, 0, 7) === '$this->')? $part : "'" . str_replace("'", "\'", $part) . "'";
			}
		}	
		$literal = str_replace(array('<?php ', 'echo ', '; ?>'), '', $literal);
		$literal = (substr($literal, 0, 7) === '$this->')? $literal : "'" . $literal . "'";
		return (($raw)? '' : '<?php echo ') . '__' . ((isset($domain))? "d({$domain}, {$literal}" : "({$literal}") . ((isset($values))? ', ' . implode(', ', $values) : '') . ')' . (($raw)? '' : '; ?>');
	}

/**
 * Processes the value of a view variable.
 *
 * @param string $name The name of the view variable.
 * @return mixed
 */
	protected function _processValue($name) {
		if (strstr($name, '.')) {
			$parts = explode('.', $name);
			$array = $this->viewVars;
			foreach ($parts as $part) {
				$isObject = is_object($array);
				if (($isObject && isset($array->$part)) || isset($array[$part])) {
					$array = ($isObject)? $array->$part : $array[$part];
				} else {
					throw new Exception('View variable not found: ' . $name);
				}
			}
			return $array;
		} else if (isset($this->viewVars[$name])) {
			return $this->viewVars[$name];
		} else {
			throw new CakeException('View variable not found: ' . $name);
		}
	}

/**
 * Determines if a value exists.
 *
 * @param mixed $value The value to check.
 * @return boolean
 */
	protected function _processIsset($value = null) {
		return (isset($value) && !is_null($value));
	}

/**
 * Determines if a value is empty.
 *
 * @param mixed $value The value to check.
 * @return boolean
 */
	protected function _processEmpty($value = null) {
		return (!isset($value) || empty($value));
	}

/**
 * Compiles code for the PHP interpreter.
 *
 * @param string $code The code to generate.
 * @return string
 */
	protected function _compile() {
		$args = func_get_args();
		return '<?php ' . ((count($args) > 1)? call_user_func_array('sprintf', $args) : $args[0]) . ' ?>';
	}

/**
 * Renders view for given view file and layout.
 *
 * If View::$autoRender is false and no `$layout` is provided, the view will be returned bare.
 *
 * View and layout names can point to plugin views/layouts.  Using the `Plugin.view` syntax
 * a plugin view/layout can be used instead of the app ones.  If the chosen plugin is not found
 * the view will be located along the regular view path cascade.
 *
 * @param string $view Name of view file to use.
 * @param string $layout Layout to use.
 * @return string Rendered Element
 * @throws CakeException if there is an error in the view.
 */
	public function render($view = null, $layout = null) {
		if ($this->hasRendered) {
			return true;
		}
		if ($view) {
			$this->view = $view;
		}
		if (!$this->_helpersLoaded) {
			$this->loadHelpers();
		}
		$this->assign('content', '');
		$this->_overrideExtType = true;
		if ($view !== false && $viewFileName = $this->_getViewFileName($this->view)) {
			$this->_currentType = self::TYPE_VIEW;
			$this->getEventManager()->dispatch(new CakeEvent('View.beforeRender', $this, array($viewFileName)));
			$this->assign('content', $this->_parse($viewFileName));
			$this->getEventManager()->dispatch(new CakeEvent('View.afterRender', $this, array($viewFileName)));
		}
		if ($layout === null) {
			$layout = $this->layout;
		}
		if ($layout && $this->autoLayout) {
			$this->assign('content', $this->renderLayout('', $layout));
		}
		$this->hasRendered = true;
		return $this->fetch('content');
	}

/**
 * Get the extensions that view files can use.
 * 
 * If _overrideExtType is set to "true", the $ext will be ".cml" by force.
 *
 * @return array Array of extensions view files use.
 */
	protected function _getExtensions() {
		if ($this->_overrideExtType) {
			$this->_overrideExtType = false;
			return array('.cml');
		}
		return parent::_getExtensions();
	}	

}


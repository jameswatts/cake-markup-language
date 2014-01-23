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
 * Null type.
 */
	const TYPE_NULL = 'null';

/**
 * Boolean type.
 */
	const TYPE_BOOLEAN = 'boolean';

/**
 * Integer type.
 */
	const TYPE_INTEGER = 'integer';

/**
 * Float type.
 */
	const TYPE_FLOAT = 'float';

/**
 * Numeric type.
 */
	const TYPE_NUMERIC = 'numeric';

/**
 * String type.
 */
	const TYPE_STRING = 'string';

/**
 * Array type.
 */
	const TYPE_ARRAY = 'array';

/**
 * Object type.
 */
	const TYPE_OBJECT = 'object';

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
 * Enables debug mode.
 * 
 * @var boolean
 */
	protected $_debug = false;

/**
 * Overrides the extension as Cake doesn't allow different $ext between views and layouts.
 * 
 * This is reset to false upon calling _getExtensions().
 * 
 * @var boolean
 */
	protected $_overrideExtType = false;

/**
 * Determines if an element's parsing options ahve been overridden.
 * 
 * @var boolean
 */
	protected $_overrideElement = false;

/**
 * The currently parsed view file.
 *
 * @var string
 */
        protected $_parsed = null;

/**
 * A captured error.
 *
 * @var array
 */
        protected $_error = null;

/**
 * Constructor
 *
 * @param Controller $controller The controller object.
 * @throws CakeException if an unknown namespace is included.
 */
	public function __construct(Controller $controller = null) {
		parent::__construct($controller);
		$nsSettings = array();
		if (is_array($controller->Parser->namespaces)) {
			$namespaces = (empty($controller->Parser->namespaces))? array() : Set::normalize((array) $controller->Parser->namespaces);
			foreach ($namespaces as $namespace => $settings) {
				list($plugin, $ns) = pluginSplit($namespace);
				$this->_namespaces[$ns] = ($plugin)? $plugin : false;
				$nsSettings[$ns] = $settings;
			}
		} else if (is_string($controller->Parser->namespaces)) {
			list($plugin, $ns) = pluginSplit($controller->Parser->namespaces);
			$this->_namespaces[$ns] = ($plugin)? $plugin : false;
			$nsSettings[$ns] = array();
		}
		foreach ($this->_namespaces as $ns => $plugin) {
			$class = $ns . 'Namespace';
			App::uses($class, ((!empty($plugin))? $plugin . '.' : '') . 'View/Namespace');
			if (!class_exists($class)) {
				throw new CakeException(sprintf('Unknown namespace: %s', $class));
			}
			$namespace = new $class($controller, $this, (isset($nsSettings[$ns]))? $nsSettings[$ns] : array());
			$namespace->load();
			$this->$ns = $namespace;
		}
		$this->_debug = $controller->Parser->debug;
		$this->_controller = $controller;
		foreach ($this->viewVars as $key => $value) {
			if (strstr($key, '.')) {
				$parts = explode('.', $key);
				$viewVars = &$this->viewVars;
				foreach ($parts as $part) {
					$viewVars = &$viewVars[$part];
				}
				$viewVars = $value;
			}
		}
		if ($this->_debug) {
			Configure::write('Exception.renderer', 'Cml.CmlExceptionRenderer');
		}
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
		$this->_current = $viewFile;
		$this->getEventManager()->dispatch(new CakeEvent('View.beforeRenderFile', $this, array($viewFile)));
		$markup = file_get_contents($viewFile);
		ob_start();
		if ($this->_debug) {
			$this->_parsed = (!$this->_parsed)? $this->_current : $this->_parsed;
			$this->assign('css', '');
			$this->assign('script', '');
			$source = null;
			$error = null;
			try {
				$output = $source = $this->_parseMarkup($markup);
				ob_clean();
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
			} else if (!$error) {
				$error = $this->_error;
			}
			ob_clean();
			$this->response->type('text/html');
			$this->response->charset('UTF-8');
			$this->layout = 'Cml.debug';
			if ($error) {
				echo '<p class="error"><b>Error:</b> ' . $error['message'] . ' on line ' . (($this->_error)? $this->_error['line'] : $error['line']) . ' of ' . $this->_parsed . '</p>';
				if ($this->_parsed === $viewFile) {
					echo '<script type="text/javascript">ERROR_LINE = \'L' . (($this->_error)? $this->_error['line'] : $error['line']) . '\';</script>';
				}
				$this->_parsed = $viewFile;
			}
			if (!$source) {
				$source = '';
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
			$content = str_replace(array($matches[1], '%START%', '%END%', '%OPEN%', '%CLOSE%', '%LEFT%', '%RIGHT%'), array($code, '<', '>', '{', '}', '[', ']'), $content);
		} else {
			$this->_parsed = $this->_current;
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
 * Parses the backtrace to resolve the real line number.
 *
 * @return integer
 */
	protected function _parseError() {
		$backtrace = debug_backtrace(false);
		for ($i = 0; $i < count($backtrace); $i++) {
			if (isset($backtrace[$i]['file']) && strstr($backtrace[$i]['file'], 'eval()\'d code')) {
				$this->_error = $backtrace[$i];
				break;
			}
		}
	}

/**
 * Parses the markup and returns the compiled output.
 *
 * @param string $markup The markup to parse.
 * @return string
 * @throws CakeException if invalid markup syntax is detected.
 */
	protected function _parseMarkup($markup = '') {
		if (!preg_match('/^\s*$/', (string) $markup)) {
			$markup = str_replace(array('%START%', '<?', '<%', '%END%', '?>', '%>'), array('&lt;', '&lt;?', '&lt;%', '&gt;', '?&gt;', '%&gt;'), (string) $markup);
			$markup = preg_replace('/(<\!\-\-comment\-\->[.\s\S\n\r]*?<\!\-\-\/comment\-\->)/i', '', $markup);
			if (preg_match_all('/((%|&)\{([^\}]+)\})/i', $markup, $vars, PREG_OFFSET_CAPTURE)) {
				if ($vars && count($vars) === 4) {
					for ($i = 0; $i < count($vars[3]); $i++) {
						$method = ($vars[2][$i][0] === '%')? 'variable' : 'reference';
						$markup = str_replace($vars[2][$i][0] . '{' . $vars[3][$i][0] . '}', $this->$method($vars[3][$i][0]), $markup);
					}
				}
			}
			if (preg_match_all('/(#\{([^\}]+)\})/i', $markup, $i18n, PREG_OFFSET_CAPTURE)) {
				if ($i18n && count($i18n) === 3) {
					for ($i = 0; $i < count($i18n[2]); $i++) {
						$markup = str_replace('#{' . $i18n[2][$i][0] . '}', $this->literal($i18n[2][$i][0]), $markup);
					}
				}
			}
			$init = time()+$this->_timeout;
			$start = 0;
			$offset = 0;
			if (preg_match('/([\w\-]+\s+=")|([\w\-]+\s+=\s+")|([\w\-]+=\s+")|([\w\-]+="\s*"[^\s\/]+")|([\w\-]+="[^"]*"\s*")/i', $markup, $match, PREG_OFFSET_CAPTURE)) {
				$lines = explode(PHP_EOL, $markup);
				$line = 0;
				for ($i = 0; $i < count($lines); $i++) {
					if (strstr($lines[$i], $match[0][0])) {
						$line = $i+1;
						break;
					}
				}
				$this->_error = array(
					'message' => 'Parser error, invalid syntax',
					'file' => $this->_current,
					'line' => $line
				);
				throw new CakeException('Parser error, invalid syntax');
			}
			while (preg_match('/(<)(|\/)([\w\-]+)\:/i', $markup, $match, PREG_OFFSET_CAPTURE, $start+$offset)) {
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
						$replace = $this->_parseTag($this->_namespaces[$ns], $ns, str_replace('-', '_', strtolower($tag)), ($state === self::TAG_CLOSE)? array() : $this->_parseAttributes($raw), $state, $raw);
					} else {
						$replace = str_replace(array('<', '>'), array('%START%', '%END%'), $raw);
					}
					$markup = str_replace($raw, $replace, $markup);
					$offset = strlen($replace);
				}
			}
			return str_replace(array('%START%', '%END%', '%OPEN%', '%CLOSE%', '%LEFT%', '%RIGHT%'), array('<', '>', '{', '}', '[', ']'), $markup);
		}
		return '';
	}

/**
 * Renders the template for the given namespace and tag.
 *
 * @param string $plugin Name of the plugin.
 * @param string $namespace The parsed namespace.
 * @param string $tag The parsed tag name.
 * @param string $attrs The parsed attributes.
 * @param string $state The tag state.
 * @param string $raw The raw string from the parser.
 * @return string
 * @throws CakeException if the template cannot be found or an error occurs.
 */
	protected function _parseTag($plugin, $ns, $tag, $attrs, $state, $raw) {
		$file = APP . (($plugin)? 'Plugin' . DS . $plugin . DS : DS) . 'View' . DS . 'Namespace' . DS . $ns . DS . $tag . '.ctp';
		if (!is_file($file)) {
			return h($raw);
		}
		try {
			ob_start();
			include $file;
			$output = ob_get_clean();
		} catch(Exception $e) {
			ob_end_clean();
			$this->_parseError();
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
	protected function _parseAttributes($tag = '') {
		$attrs = array();
		if (!preg_match('/^\s+$/', (string) $tag)) {
			$tag = preg_replace('/[\s]{2,}/', ' ', (string) $tag);
			preg_match_all('/\s+([\w\-]+)\=("[^"]{1,}")/i', $tag, $parts, PREG_OFFSET_CAPTURE);
			if (count($parts) === 3) {
				for ($i = 0; $i < count($parts[0]); $i++) {
					$attrs[$parts[1][$i][0]] = substr($parts[2][$i][0], 1, strlen($parts[2][$i][0])-2);
				}
			}
		}
		return $attrs;
	}

/**
 * Processes and resolves an attribute with default options.
 *
 * @param array $attrs The attributes to use.
 * @param string $name The attribute to process.
 * @param array $options The processing options.
 * @return string
 */
	public function resolve(array $attrs, $name, array $options = null) {
		$options = array_merge(array(
			'default' => null,
			'format' => '"%s"',
			'replace' => array(array('<?php echo ', '; ?>'), array('%OPEN%', '%CLOSE%')),
			'parse' => null,
			'type' => self::TYPE_STRING
		), (array) $options);
		$attr = (array_key_exists($name, $attrs))? $attrs[$name] : $options['default'];
		if ($attr === null) {
			switch ($options['type']) {
				case self::TYPE_NULL:
					return 'null';
				case self::TYPE_BOOLEAN:
					return 'false';
				case self::TYPE_INTEGER:
				case self::TYPE_FLOAT:
				case self::TYPE_NUMERIC:
					return 0;
				case self::TYPE_ARRAY:
				case self::TYPE_OBJECT:
					return 'array()';
				default:
					return (is_string($options['format']))? sprintf($options['format'], '') : '';
			}
		} else {
			if (strstr($attr, '&')) {
				$attr = html_entity_decode($attr, ENT_QUOTES);
			}
			$string = strtolower(trim($attr));
			$gnirts = strrev($string);
			if ($options['type'] === self::TYPE_NULL || $string === 'null') {
				return ($string === 'null')? 'null' : $string;
			} else if ($options['type'] === self::TYPE_BOOLEAN || $string === 'true' || $string === 'false') {
				if ($options['type'] === self::TYPE_BOOLEAN) {
					return ($string === 'false' || $string === '0' || $string === '')? 'false' : 'true';
				} else {
					return (is_string($options['format']))? ((is_array($options['replace']))? sprintf($options['format'], str_replace($options['replace'][0], $options['replace'][1], (string) $attr)) : sprintf($options['format'], (string) $attr)) : (($string === 'null')? '' : ($string === 'true'));
				}
			} else if ($options['type'] === self::TYPE_INTEGER) {
				return (int) $string;
			} else if ($options['type'] === self::TYPE_FLOAT) {
				return (float) $string;
			} else if ($options['type'] === self::TYPE_NUMERIC) {
				return 0+$string;
			} else if ($options['type'] === self::TYPE_ARRAY || $options['type'] === self::TYPE_OBJECT || (strlen($string) > 0 && $string{0} === '[' && $gnirts{0} === ']')) {
				return str_replace(array('[', ']'), array('array(', ')'), preg_replace('/(<\?php echo )(\$this\->(translate|translateDomain|reference|variable|value)\(\'([^\)]+)\'\))(\; \?>)/', '$2', trim($attr)));
			} else {
				if (substr($string, 0, 7) === '$this->') {
					$value = $attr;
				} else {
					if (is_string($options['format'])) {
						if (is_array($options['replace'])) {
							$replaced = str_replace($options['replace'][0], $options['replace'][1], (string) $attr);
							$value = (substr($replaced, 0, 7) === '$this->')? $replaced : sprintf($options['format'], $replaced);
						} else {
							$value = sprintf($options['format'], $attr);
						}
					} else {
						$value = $attr;
					}
				}
				if ($options['parse'] === true) {
					$options['parse'] = array('/(%OPEN%)(\$this\->(translate|translateDomain|reference|variable|value)\(\'([^\)]+)\'\))(%CLOSE%)/', '$2');
				}
				return (is_array($options['parse']))? preg_replace($options['parse'][0], $options['parse'][1], $value) : $value;
			}
		}
	}

/**
 * Processes a view variable and returns the value.
 *
 * @param string $name The name of the view variable.
 * @return mixed
 */
	public function variable($name) {
		return $this->compile('echo $this->value(\'' . str_replace(array('[', ']'), array('%LEFT%', '%RIGHT%'), $name) . '\');');
	}

/**
 * Processes a view variable and returns a reference at run-time.
 *
 * @param string $name The name of the view variable.
 * @return mixed
 */
	public function reference($name) {
		return $this->value($name);
	}

/**
 * Processes a I18N literal and returns the generated PHP code.
 *
 * @param string $name The name of the I18N literal.
 * @return string
 */
	public function literal($literal) {
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
		return (($raw)? '' : '<?php echo ') . '$this->translate' . ((isset($domain))? "Domain({$domain}, {$literal}" : "({$literal}") . ((isset($values))? ', ' . implode(', ', $values) : '') . ')' . (($raw)? '' : '; ?>');
	}

/**
 * Translates a literal through the i18n system.
 *
 * @param string $literal The literal to lookup.
 * @return string
 */
	public function translate($literal) {
		$args = func_get_args();
		return call_user_func_array('__', $args);
	}

/**
 * Translates a domain literal through the i18n system.
 *
 * @param string $domain The i18n domain.
 * @param string $literal The literal to lookup.
 * @return string
 */
	public function translateDomain($domain, $literal) {
		$args = func_get_args();
		return call_user_func_array('__d', $args);
	}

/**
 * Processes the value of a view variable. Use the * symbol to specify a default 
 * in case the variable is undefined.
 *
 * @param string $name The name of the view variable.
 * @param boolean $silent Forces null to be returned instead of an exception thrown.
 * @return mixed
 * @throws CakeException if an unknown View variable is requested.
 */
	public function value($name, $silent = false) {
		$default = null;
		if (strstr($name, '*')) {
			$parts = explode('*', $name);
			$name = $parts[0];
			array_shift($parts);
			$default = implode('*', $parts);
		}
		if (strstr($name, '[')) {
			while (preg_match('/\[([\w\-\.\*]+)\]/i', $name, $match, PREG_OFFSET_CAPTURE, 0)) {
				$name = str_replace($match[0][0], '.' . $this->value($match[1][0]), $name);
			}
		}
		if (strstr($name, '.')) {
			$parts = explode('.', $name);
			$array = $this->viewVars;
			$found = true;
			foreach ($parts as $part) {
				$isArray = is_array($array);
				$isObject = is_object($array);
				if (($isObject && (property_exists($array, $part) || method_exists($array, $part))) || ($isArray && array_key_exists($part, $array))) {
					$array = ($isObject)? ((method_exists($array, $part))? $array->$part() : $array->$part) : $array[$part];
				} else {
					if (ParserComponent::$loadSettings['configure'] || ParserComponent::$loadSettings['session']) {
						$found = false;
						break;
					}
					if ($default) {
						return $default;
					} else {
						if ($silent) {
							return null;
						} else {
							$this->_parseError();
							throw new CakeException('View variable not found: ' . $name);
						}
					}
				}
			}
			if ($found) {
				return $array;
			}
			if (ParserComponent::$loadSettings['configure'] || ParserComponent::$loadSettings['session']) {
				if (Configure::read($name) !== null) {
					return Configure::read($name);
				} else if ($this->_controller->Session->read($name) !== null) {
					return $this->_controller->Session->read($name);
				} else {
					if ($default) {
						return $default;
					} else {
						if ($silent) {
							return null;
						} else {
							$this->_parseError();
							throw new CakeException('View variable not found: ' . $name);
						}
					}
				}
			}
		} else if (array_key_exists($name, $this->viewVars)) {
			return $this->viewVars[$name];
		} else if (ParserComponent::$loadSettings['configure'] && Configure::read($name) !== null) {
			return Configure::read($name);
		} else if (ParserComponent::$loadSettings['session'] && $this->_controller->Session->read($name) !== null) {
			return $this->_controller->Session->read($name);
		} else if ($default) {
			return $default;
		} else {
			if ($silent) {
				return null;
			} else {
				$this->_parseError();
				throw new CakeException('View variable not found: ' . $name);
			}
		}
	}

/**
 * Determines if a value exists.
 *
 * @param mixed $value The value to check.
 * @return boolean
 */
	protected function _isset($value = null) {
		return (isset($value) && !is_null($value));
	}

/**
 * Determines if a value is empty.
 *
 * @param mixed $value The value to check.
 * @return boolean
 */
	protected function _empty($value = null) {
		return (!isset($value) || empty($value));
	}

/**
 * Compiles code for the PHP interpreter.
 *
 * @param string $code The code to generate.
 * @return string
 */
	public function compile() {
		$args = func_get_args();
		return '<?php ' . ((count($args) > 1)? call_user_func_array('sprintf', $args) : $args[0]) . ' ?>';
	}

/**
 * Returns filename of given action's template file (.ctp) as a string.
 * CamelCased action names will be under_scored! This means that you can have
 * LongActionNames that refer to long_action_names.ctp views.
 *
 * @param string $name Controller action to find template filename for
 * @return string Template filename
 * @throws MissingViewException when a view file could not be found.
 */
	protected function _getViewFileName($name = null) {
		$this->ext = '.cml';
		$this->_overrideExtType = true;
		return parent::_getViewFileName($name);
	}

/**
 * Returns layout filename for this template as a string.
 *
 * @param string $name The name of the layout to find.
 * @return string Filename for layout file (.ctp).
 * @throws MissingLayoutException when a layout cannot be located
 */
	protected function _getLayoutFileName($name = null) {
		if (ParserComponent::$renderSettings['layout'] && $name !== 'Cml.debug') {
			$this->ext = '.cml';
			$this->_overrideExtType = true;
		}
		return parent::_getLayoutFileName($name);
	}

/**
 * Renders a piece of PHP with provided parameters and returns HTML, XML, or any other string.
 *
 * This realizes the concept of Elements, (or "partial layouts") and the $params array is used to send
 * data to be used in the element. Elements can be cached improving performance by using the `cache` option.
 *
 * @param string $name Name of template file in the/app/View/Elements/ folder,
 *   or `MyPlugin.template` to use the template element from MyPlugin. If the element
 *   is not found in the plugin, the normal view path cascade will be searched.
 * @param array $data Array of data to be made available to the rendered view (i.e. the Element)
 * @param array $options Array of options. Possible keys are:
 * - `cache` - Can either be `true`, to enable caching using the config in View::$elementCache. Or an array
 *   If an array, the following keys can be used:
 *   - `config` - Used to store the cached element in a custom cache configuration.
 *   - `key` - Used to define the key used in the Cache::write(). It will be prefixed with `element_`
 * - `plugin` - Load an element from a specific plugin. This option is deprecated, see below.
 * - `callbacks` - Set to true to fire beforeRender and afterRender helper callbacks for this element.
 *   Defaults to false.
 * - `ignoreMissing` - Used to allow missing elements. Set to true to not trigger notices.
 * - `parse` - If `true` the element is parsed as markup, expecting a `.cml` file, otherwise it will look 
 *   for a ".ctp" file and include it as normal. If the global `renderElement` setting is set on the 
 *   Parser component then this check will be bypassed.
 *   Defaults to false.
 * @return string Rendered Element
 * @deprecated The `$options['plugin']` is deprecated and will be removed in CakePHP 3.0. Use
 *   `Plugin.element_name` instead.
 */
	public function element($name, $data = array(), $options = array()) {
		$parse = array_key_exists('parse', $options);
		if (ParserComponent::$renderSettings['element'] && (!$parse || ($parse && $options['parse']))) {
			$this->ext = '.cml';
			$this->_overrideExtType = true;
			$this->_overrideElement = true;
			if (is_array($data)) {
				foreach ($data as $key => $value) {
					$this->viewVars[(string) $key] = $value;
				}
			}
		}
		return parent::element($name, $data, $options);
	}

/**
 * Renders an element and fires the before and afterRender callbacks for it
 * and writes to the cache if a cache is used
 *
 * @param string $file Element file path
 * @param array $data Data to render
 * @param array $options Element options
 * @return string
 */
        protected function _renderElement($file, $data, $options) {
                $this->_parsed = $file;
                return parent::_renderElement($file, $data, $options);
        }

/**
 * Sandbox method to evaluate a template / view script in.
 *
 * @param string $viewFile Filename of the view
 * @param array $dataForView Data to include in rendered view.
 *    If empty the current View::$viewVars will be used.
 * @return string Rendered output
 */
	protected function _evaluate($viewFile, $dataForView) {
		$this->ext = '.ctp';
		$this->_overrideExtType = false;
		if ($this->_currentType === self::TYPE_VIEW
			|| ($this->_currentType === self::TYPE_LAYOUT && ParserComponent::$renderSettings['layout'] && substr($viewFile, -27) !== '/Cml/View/Layouts/debug.ctp')
			|| ($this->_currentType === self::TYPE_ELEMENT && $this->_overrideElement)) {
			$this->_parsed = $viewFile;
			$this->_overrideElement = false;
			return $this->_parse($viewFile);
		} else {
			return parent::_evaluate($viewFile, $dataForView);
		}
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


<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->_compile('$this->viewVars[\'COUNT\'] = 0; while (%s): $this->viewVars[\'COUNT\']++;', str_replace(array('isset(', 'empty('), array('$this->_processIsset(', '$this->_processEmpty('), $this->_processAttribute($attributes, 'expr', array('default' => 'true', 'format' => '%s', 'parse' => true))));
		break;
	case self::TAG_CLOSE:
		echo $this->_compile('endwhile;');
}


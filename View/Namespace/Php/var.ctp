<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$this->viewVars[%s] = %s;', $this->_processAttribute($attributes, 'name'), str_replace(array('isset(', 'empty('), array('$this->_processIsset(', '$this->_processEmpty('), $this->_processAttribute($attributes, 'expr', array('default' => 'true', 'format' => '%s', 'parse' => true))));
}


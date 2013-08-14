<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$name = %s; $var = %s; $get = %s; $call = %s; $args = %s; $object = (!empty($var))? $this->viewVars[$var] : $this->$name; $out = (!empty($get))? $object->$get : call_user_func_array(array($object, $call), $args); $set = %s; if (!empty($set)) { $this->viewVars[$set] = $out; } else { echo $out; }', $this->_processAttribute($attributes, 'name'), $this->_processAttribute($attributes, 'var'), $this->_processAttribute($attributes, 'get'), $this->_processAttribute($attributes, 'call'), $this->_processAttribute($attributes, 'args', array('default' => 'array()', 'format' => null)), $this->_processAttribute($attributes, 'set'));
}


<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('echo call_user_func_array(array($this, \'element\'), array(%s, %s, %s));', $this->_processAttribute($attributes, 'name'), $this->_processAttribute($attributes, 'vars', array('default' => 'array()', 'format' => null)), $this->_processAttribute($attributes, 'options', array('default' => 'array()', 'format' => null)));
}


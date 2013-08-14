<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$this->viewVars[%s] = %s;', $this->_processAttribute($attributes, 'name'), $this->_processAttribute($attributes, 'value', array('default' => '')));
}


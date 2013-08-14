<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('ob_start();') . $this->_processAttribute($attributes, 'value', array('format' => null)) . $this->_compile('$value = ob_get_clean(); $this->append(%s, $value);', $this->_processAttribute($attributes, 'name'));
}


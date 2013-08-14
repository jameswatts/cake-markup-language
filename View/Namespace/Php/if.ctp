<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->_compile('if (%s):', str_replace(array('isset(', 'empty('), array('$this->_processIsset(', '$this->_processEmpty('), $this->_processAttribute($attributes, 'expr', array('default' => 'true', 'format' => '%s', 'parse' => true))));
		break;
	case self::TAG_CLOSE:
		echo $this->_compile('endif;');
}


<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->_compile('$this->start%s(%s);', ($this->_processAttribute($attributes, 'empty', array('default' => true, 'format' => null)))? '' : 'IfEmpty', $this->_processAttribute($attributes, 'name'));
		break;
	case self::TAG_CLOSE:
		echo $this->_compile('$this->end();');
}


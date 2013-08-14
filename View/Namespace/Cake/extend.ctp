<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$this->extend(%s);', $this->_processAttribute($attributes, 'view', array('default' => '')));
}


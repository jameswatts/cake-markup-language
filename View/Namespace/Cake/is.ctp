<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->_compile('if ($this->request->is(%s)):', $this->_processAttribute($attributes, 'type'));
		break;
	case self::TAG_SELF:
		echo $this->_compile('if ($this->request->is(%s)) { echo %s; }', $this->_processAttribute($attributes, 'type'), $this->_processAttribute($attributes, 'value'));
		break;
	case self::TAG_CLOSE:
		echo $this->_compile('endif;');
		break;
}


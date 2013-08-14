<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('debug($this->_processValue(%s));', $this->_processAttribute($attributes, 'var'));
}


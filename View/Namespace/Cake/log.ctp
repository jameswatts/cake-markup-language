<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$this->log(%s, %s);', $this->_processAttribute($attributes, 'message'), $this->_processAttribute($attributes, 'type', array('default' => 'debug')));
}


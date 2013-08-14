<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('echo htmlentities(%s);', $this->_processAttribute($attributes, 'expr'));
}


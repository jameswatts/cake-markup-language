<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('echo $this->getVar(%s);', $this->_processAttribute($attributes, 'name'));
}


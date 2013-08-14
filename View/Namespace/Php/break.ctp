<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		$nested = $this->_processAttribute($attributes, 'nested'); echo $this->_compile(' break%s;', ($nested)? ' ' . $nested : '');
}


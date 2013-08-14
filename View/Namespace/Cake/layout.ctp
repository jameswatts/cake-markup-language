<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$this->viewVars[\'Cake\'][\'layout\'] = $this->layout = %s;', $this->_processAttribute($attributes, 'name'));
}


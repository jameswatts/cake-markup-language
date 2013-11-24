<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		$set = $this->_processAttribute($attributes, 'set', array('format' => null));
		echo $this->_compile('ob_start();') . $this->_processAttribute($attributes, 'default', array('format' => null)) . $this->_compile('$default = ob_get_clean(); %s $this->fetch(%s, $default);', ($set)? '$this->viewVars["' . $set . '"] = ' : 'echo', $this->_processAttribute($attributes, 'name'));
}


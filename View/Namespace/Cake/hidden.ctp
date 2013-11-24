<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$out = $this->%s->hidden(%s, %s); $set = %s; if (!empty($set)) { $this->viewVars[$set] = $out; } else { echo $out; }', $this->_helpers['Form'], $this->_processAttribute($attributes, 'field'), $this->_processAttribute($attributes, 'options', array('default' => 'array()', 'format' => null)), $this->_processAttribute($attributes, 'set'));
}


<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$out = $this->%s->submit(%s, %s); $set = %s; if (!empty($set)) { $this->viewVars[$set] = $out; } else { echo $out; }', $this->_helpers['Form'], $this->_processAttribute($attributes, 'caption'), $this->_processAttribute($attributes, 'options'), $this->_processAttribute($attributes, 'set'));
}


<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->_compile('$out = $this->%s->button(%s, %s); echo substr($out, 0, -9);', $this->_helpers['Form'], $this->_processAttribute($attributes, 'value'), $this->_processAttribute($attributes, 'options'));
		break;
	case self::TAG_SELF:
		echo $this->_compile('$out = $this->%s->button(%s, %s); $set = %s; if (!empty($set)) { $this->viewVars[$set] = $out; } else { echo $out; }', $this->_helpers['Form'], $this->_processAttribute($attributes, 'value'), $this->_processAttribute($attributes, 'options'), $this->_processAttribute($attributes, 'set'));
		break;
	case self::TAG_CLOSE:
		echo '</button>';
}

